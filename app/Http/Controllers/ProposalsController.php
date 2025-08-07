<?php

namespace App\Http\Controllers;

use App\Http\Requests\Proposal\AddedProposalRequest;
use App\Models\Event;
use App\Models\Event_session;
use App\Models\Proposal;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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


public function AcceptProposal($id)
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

        if (!$proposal->speaker) {
            throw new \Exception("The speaker user record doesn't exist");
        }

        if (!$proposal->event) {
            throw new \Exception("The event record doesn't exist");
        }
   
        DB::transaction(function() use ($proposal) {
            $session = Event_session::create([
                'event_id' => $proposal->event_id,
                'speaker_id' => $proposal->speaker_id,
                'proposal_id' => $proposal->id,
                'start_date' => now()->addDays(1)->setHour(10)->setMinute(0), // DEFUALT Api 
                'end_date' => now()->addDays(1)->setHour(11)->setMinute(0), // DEFUALT 
            ]);
            
            $proposal->update(['status' => 'approved']);
        });
        
        return back()->with('success', 'Proposal Approved and Session Scheduled');
        
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
