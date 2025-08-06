<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function CreateEvent()
    {
        return view('pages.organizer.create-event');
    }

    public function StoreEvent(EventRequest $request)
    {
        $events = $request->validated();

        $events['status'] = "available";
        $events['organizer_id'] = Auth::id();
        Event::create($events);
        return redirect()->route('events')->with('success', 'Event has been created successfully.');
    }

  public function UpdateEvent(Request $request, $id)
{
    $event = Event::findOrFail($id);

    $data = $request->validate([
        'event_name' => 'required|string|min:3|max:255',
        'location' => 'required|string|min:3|max:255',
        'available_tickets' => 'required|integer|min:1',
        'start_date' => 'required|date|after_or_equal:today',
        'end_date' => 'required|date|after:start_date',
        'status' => 'required|in:available,upcoming,closed',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', 
    ]);
    
    $event->update($data);

    return redirect()->back()->with('success', 'Event has been updated successfully.');
}

}
