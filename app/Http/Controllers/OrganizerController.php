<?php

namespace App\Http\Controllers;

use App\Http\Requests\Event\StoreEventRequest;
use App\Http\Requests\OrganizerForm;
use App\Models\Event;
use App\Models\Event_session;
use App\Models\Proposal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrganizerController extends Controller
{
    /**
     * Adam Ahmed -> Retrived Sessions with all the data 
     */
public function eventDetails($id)
{
    $event = Event::findOrFail($id);
    $proposals = Proposal::where('event_id', $id)->get();
 
    // Get sessions with speaker and proposal information
    $eventSessions = Event_session::with(['speaker', 'proposal'])
        ->where('event_id', $id)
        ->orderBy('start_date', 'asc')
        ->get();
        
    return view('pages.shared.event-details', compact('proposals', 'eventSessions', 'event'));
}

    public function homeEvents()
    {
        $events = Event::latest()->take(3)->get();
        return view('pages.shared.home', compact('events'));
    }


    public function OrganizerEvents()
    {
        $user = Auth::user();
        $events = $user->events;
        return view('pages.organizer.events', compact('events'));

    }

    // View SpecificProposal For An Event
    public function SpecificProposal($id)
    {
        $event = Event::findorfail($id);
        $proposals = Proposal::where('event_id', $id)->get();
        return view('pages.organizer.eventproposals', compact('proposals', 'event'));
    }
}
