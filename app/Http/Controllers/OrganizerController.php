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
    // Zeyad Hyman Create (eventDetails, events) and removed (EditEvent)
    public function eventDetails($id)
    {
        $event = Event::findOrFail($id);
        $proposals = Proposal::where('event_id', $id)->get();
        $eventSessions = Event_session::where('event_id', $id)->get();
        return view('pages.shared.event-details', compact('proposals', 'eventSessions', 'event'));
    }

    public function events()
    {
        $events = Event::all();
        return view('pages.shared.events', compact('events'));
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
