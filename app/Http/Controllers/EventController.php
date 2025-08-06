<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function CreateEvent()
    {
        return view('pages.organizer.create-event');
    }

public function StoreEvent(EventRequest $request)
{
    $events = $request->validated();

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = $image->getClientOriginalName(); 
        $image->storeAs('events', $imageName, 'public'); 
        $events['image'] = $imageName;
    }

    $events['status'] = "Available";
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
        'status' => 'required|in:Available,Upcoming,closed',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', 
    ]);

    if ($request->hasFile('image')) {
        if ($event->image && Storage::disk('public')->exists($event->image)) {
            Storage::disk('public')->delete($event->image);
        }
        $imagePath = $request->file('image')->store('events', 'public');
        $data['image'] = $imagePath;
    }

    $event->update($data);

    return redirect()->back()->with('success', 'Event has been updated successfully.');
}


}
