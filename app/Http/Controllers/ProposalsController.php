<?php

namespace App\Http\Controllers;

use App\Http\Requests\Proposal\AddedProposalRequest;
use App\Models\Event;
use App\Models\Proposal;
use Illuminate\Support\Facades\Auth;

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
        $speaker_id = Auth::id();
        $cvPath = $request->file('cv')->store('cvs', 'public');
        $existing_proposal = Proposal::where("event_id", $id)->where("speaker_id", $speaker_id)->exists();
        if ($existing_proposal) {
            return redirect()->back()->with('info', 'You have already applied to this event.');
        }

        Proposal::create([
            "title" => $validated["title"],
            "description" => $validated['description'],
            "cv" => $cvPath,
            "status" => "pending",
            "speaker_id" => $speaker_id,
            "event_id" => $id
        ]);

        return redirect()->route('home')->with('success', 'Proposal applied successfully.');
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
        $proposal = Proposal::findorfail($id);
        $proposal->status = 'approved';

        $proposal->save();

        return redirect()->route('proposals')->with('success', 'Speakers Propsal has been Approved ');
    }
    public function RejectProposal($id)
    {

        $proposal = Proposal::findorfail($id);

        $proposal->status = 'rejected';

        $proposal->save();

        return redirect()->route('events.')->with('rejected', 'Speakers Propsal has been Rejected ');
    }
}
