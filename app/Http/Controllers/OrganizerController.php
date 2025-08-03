<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrganizerForm;
use App\Models\Event;
use App\Models\Proposal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrganizerController extends Controller
{
    /**
     * 
     */
    public function OrganizerEvents()
    {
        // UnCommecnt when the FrontEnd Part Ends ----> Test Page FOR NOW

        // $user = Auth::user();
        // $events = $user->events; 
        // return view('pages.organizer.events', compact('events'));

        // Delete when the upper code is uncommented 
        return view('pages.organizer.events');
    }

    // Event Form
    public function CreateEvent()
    {
        return view('pages.organizer.CreateEvent');
    }

    // Event Form Logic -> Store
    public function StoreEvent(OrganizerForm $request)
    {
        $data = $request->validated();

        $data['organizer_id'] = Auth::user()->id;

        Event::create($data);

        return redirect()->route('events.index')->with('Success', 'Event has been created successfully.');
    }

    // Showing Event Form
    public function EditEvent($id)
    {
        $event = Event::findorfail($id);
        return view('pages.organizer.editform', compact('event'));
    }
    // Updating an Event
    public function UpdateEvent(OrganizerForm $request, $id)
    {
        $data = $request->validated();

        $event = Event::findOrFail($id); 

        $event->update($data);

        return redirect()->route('events.index')->with('Success', 'Event has been updated successfully.');
    }
    // Delete an Event
    public function DeleteEvent($id){
        $event = Event::findorfail($id);
        $event ->delete();
        return redirect()->route('events.events')->with('Success', 'Event has been Deleted Successfully');
    }

    // View SpecificProposal For An Event
    public function SpecificProposal($id){
        $event = Event::findorfail($id);

        $proposals = Proposal::where('event_id', $id)->get();
        return view('pages.organizer.eventproposals', compact('proposals', 'event'));
    }
}
