<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrganizerForm;
use App\Models\Event;
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

        // $data['organizer_id'] = auth()->id();

        Event::create($data);

        return redirect()->route('events.index')->with('Success', 'Event has been created successfully.');
    }


    public function EditEvent($id)
    {
        $event = Event::findorfail($id);
        return view('pages.organizer.editform', compact('event'));
    }

    public function UpdateEvent(OrganizerForm $request, $id)
    {
        $data = $request->validated();

        $event = Event::findOrFail($id); 

        $event->update($data);

        return redirect()->route('events.index')->with('Success', 'Event has been updated successfully.');
    }

    public function DeleteEvent($id){
        $event = Event::findorfail($id);
        $event ->delete();
        return redirect()->route('events.events')->with('Success', 'Event has been Deleted Successfully');
    }
}
