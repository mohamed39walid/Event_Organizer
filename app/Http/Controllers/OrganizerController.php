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
     *
     */
    // Zeyad Hyman Create (eventDetails, events) and removed (EditEvent)
    public function eventDetails($id)
    {
        $event = Event::findOrFail($id);
        $proposals = Proposal::where('event_id', $id)->get();
        $evntSessions = Event_session::where('event_id', $id)->get();
        return view('pages.shared.event-details', compact('proposals', 'evntSessions', 'event'));
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

        // Delete when the upper code is uncommented
        return view('pages.organizer.events');
    }

    // Event Form
    public function CreateEvent()
    {
        return view('pages.organizer.create-event');
    }

    // Zeyad Hyman (Fix This Function )
    // // Event Form Logic -> Store
    // public function StoreEvent(OrganizerForm $request)
    // {
    //     $data = $request->validated();

    //     $data['organizer_id'] = Auth::user()->id;

    //     Event::create($data);

    //     return redirect()->route('events.index')->with('Success', 'Event has been created successfully.');
    // }

    // Zeyad Hyman
    public function StoreEvent(StoreEventRequest $request)
    {
        $validated = $request->validated();
        $organizer_id = Auth::id();
        $status = "Avalaible";
        Event::create([
            "event_name" => $validated['event_name'],
            "location" => $validated['location'],
            "start_date" => $validated['start_date'],
            "end_date" => $validated['end_date'],
            "available_tickets" => $validated['available_tickets'],
            "status" => $status,
            "organizer_id" => $organizer_id,
        ]);
        return redirect()->route('events')->with('success', 'Event has been created successfully.');
    }


    // i don't need this funcion
    // // Showing Event Form
    // public function EditEvent($id)
    // {
    //     $event = Event::findorfail($id);
    //     return view('pages.organizer.editform', compact('event'));
    // }

    // Zeyad Hyman (Fix This Function )
    // // Updating an Event
    // public function UpdateEvent(OrganizerForm $request, $id)
    // {
    //     $data = $request->validated();

    //     $event = Event::findOrFail($id);

    //     $event->update($data);

    //     return redirect()->route('events.index')->with('Success', 'Event has been updated successfully.');
    // }

    public function UpdateEvent(Request $request, $id)
    {
        $data = $request->all();

        $event = Event::findOrFail($id);

        $event->update($data);

        return redirect()->route('events')->with('Success', 'Event has been updated successfully.');
    }

    // Delete an Event
    public function DeleteEvent($id)
    {
        $event = Event::findorfail($id);
        $event->delete();
        return redirect()->route('events.events')->with('Success', 'Event has been Deleted Successfully');
    }

    // View SpecificProposal For An Event
    public function SpecificProposal($id)
    {
        $event = Event::findorfail($id);

        $proposals = Proposal::where('event_id', $id)->get();
        return view('pages.organizer.eventproposals', compact('proposals', 'event'));
    }
}
