<?php

namespace App\Http\Controllers;

use App\Http\Requests\Proposal\AddedProposalRequest;
use App\Models\Event;
use App\Models\Event_session;
use App\Models\Proposal;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


use function Pest\Laravel\json;

class ProposalsController extends Controller
{
    public function GetSpeakerProposals()
    {
        $speaker_id = Auth::id();
        $proposals = Proposal::where("speaker_id", $speaker_id)->get();
        if (!$proposals) {
            return json("msg", "there is no proposals");
        }
        return view("pages.speaker.proposals", compact("proposals"));
    }

    public function CreateProposal(AddedProposalRequest $request, $id)
    {
        $event = Event::find($id);
        if (!$event) {
            return redirect()->back()->with('error', 'Invalid event ID.');
        }

        $validated = $request->validated();
        $speaker = Auth::user(); // get full user object
        $speaker_id = $speaker->id;
        $ticket_proposal_id = Ticket::where("event_id", $id)->where("user_id", $speaker_id)->first("event_id");
        if ($ticket_proposal_id) {
            return redirect()->back()->with("error", "You can't book ticket and apply to this event");
        }
        // Handle CV upload
        $file = $request->file('cv');
        $username = Str::slug($speaker->username);
        $extension = $file->getClientOriginalExtension();
        $filename = "{$username}_event{$id}.{$extension}";
        $file->storeAs('cvs', $filename, 'public');


        $existing_proposal = Proposal::where("event_id", $id)
            ->where("speaker_id", $speaker_id)
            ->exists();

        if ($existing_proposal) {
            return redirect()->back()->with('info', 'You have already applied to this event.');
        }

        Proposal::create([
            "title" => $validated["title"],
            "description" => $validated["description"],
            "cv" => $filename,
            "status" => "pending",
            "speaker_id" => $speaker_id,
            "event_id" => $id
        ]);

        return redirect()->route('home')->with('success', 'Proposal applied successfully.');

        //   $validated = $request->validated();
        // $speaker = Auth::user();

        // // Handle CV upload with unique filename
        // $file = $request->file('cv');
        // $filename = Str::slug($speaker->username)
        //             . '_event_' . $id
        //             . '_' . time()
        //             . '.' . $file->getClientOriginalExtension();

        // $path = $file->storeAs('proposals/cvs', $filename, 'public');

        // // Create proposal
        // Proposal::create([
        //     "title" => $validated["title"],
        //     "description" => $validated["description"],
        //     "cv" => $path,  // Store full path
        //     "status" => "pending",
        //     "speaker_id" => $speaker->id,
        //     "event_id" => $id
        // ]);

        // return redirect()->route('home')
        //        ->with('success', 'Your speaker proposal has been submitted successfully!');
    }


    public function DeleteProposal($id)
    {
        $speaker_id = Auth::id();
        $proposal = Proposal::where("speaker_id", $speaker_id)->where("id", $id)->first();
        if (!$proposal) {
            return redirect()->back()->with('error', "Proposal not found or doesn't belong to you.");
        }
        $proposal->delete();
        return redirect()->route('speaker.my-proposals')->with('success', 'Ticket unbooked successfully.');
    }


    public function AcceptProposal(Request $request, $id)
    {
        try {
            $proposal = Proposal::with(['speaker', 'event'])->findOrFail($id);

            // Validate required relationships exist
            if (!$proposal->speaker_id) {
                throw new \Exception("No speaker associated with this proposal");
            }

            if (!$proposal->event_id) {
                throw new \Exception("No event associated with this proposal");
            }

            $event = $proposal->event;
            $eventStart = Carbon::parse($event->start_date);
            $eventEnd = Carbon::parse($event->end_date);

            // Custom validation rules
            $validator = Validator::make($request->all(), [
                'session_date' => [
                    'required',
                    'date',
                    function ($attribute, $value, $fail) use ($eventStart, $eventEnd) {
                        $date = Carbon::parse($value);
                        if ($date->lt($eventStart->startOfDay())) {
                            $fail("Session date must be on or after " . $eventStart->format('M d, Y'));
                        }
                        if ($date->gt($eventEnd->endOfDay())) {
                            $fail("Session date must be on or before " . $eventEnd->format('M d, Y'));
                        }
                    }
                ],
                'start_time' => 'required|date_format:H:i',
                'end_time' => [
                    'required',
                    'date_format:H:i',
                    'after:start_time',
                    function ($attribute, $value, $fail) use ($request) {
                        // $start = Carbon::parse($request->start_time);
                        // $end = Carbon::parse($value);
                        $start = Carbon::createFromFormat('H:i', $request->start_time);
                        $end = Carbon::createFromFormat('H:i', $value);
                        $duration = $start->diffInMinutes($end);

                        if ($duration < 30) {
                            $fail("Session must be at least 30 minutes long");
                        }
                        if ($duration > 240) {
                            $fail("Session cannot exceed 4 hours");
                        }
                    }
                ]
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator, 'approve_' . $proposal->id)
                    ->withInput()
                    ->with('_from_proposal_id', $proposal->id);
            }

            $validated = $validator->validated();
            $sessionDate = Carbon::parse($validated['session_date']);
            $startTime = Carbon::parse($validated['start_time']);
            $endTime = Carbon::parse($validated['end_time']);

            $sessionStart = $sessionDate->copy()
                ->setHour($startTime->hour)
                ->setMinute($startTime->minute);

            $sessionEnd = $sessionDate->copy()
                ->setHour($endTime->hour)
                ->setMinute($endTime->minute);

            DB::transaction(function () use ($proposal, $sessionStart, $sessionEnd) {
                $session = Event_session::create([
                    'event_id' => $proposal->event_id,
                    'speaker_id' => $proposal->speaker_id,
                    'proposal_id' => $proposal->id,
                    'start_date' => $sessionStart,
                    'end_date' => $sessionEnd,
                ]);

                $proposal->update(['status' => 'approved']);
            });

            return back()->with('success', 'Proposal approved and session scheduled successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function RejectProposal($id)
    {

        $proposal = Proposal::findorfail($id);

        $proposal->status = 'rejected';

        $proposal->save();

        return redirect()->back()->with('success', 'Speakers Propsal has been Rejected ');
    }
}
