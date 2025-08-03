<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProposalsController extends Controller
{
    // viewing all the proposals
    // public function AllProposals()
    // {
    //     $proposals = Proposal::all();
    //     return view('pages.organizer.proposals');
    // }

    public function AcceptProposal($id) {
        $proposal = Proposal::findorfail($id);
        $proposal -> status = 'approved';

        $proposal->save();

        return redirect()->route('proposals')->with('success', 'Speakers Propsal has been Approved ');
    }
    public function RejectProposal($id) {

        $proposal = Proposal::findorfail($id);

        $proposal -> status = 'rejected';

        $proposal->save();

        return redirect()->route('events.')->with('rejected', 'Speakers Propsal has been Rejected ');
    }
}
