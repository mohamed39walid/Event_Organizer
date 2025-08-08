<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{

    public function events()
    {
        $events = Event::all();
        return view('pages.shared.events', compact('events'));
    }

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

        $validator = Validator::make($request->all(), [
            'event_name' => 'required|string|min:3|max:255',
            'location' => 'required|string|min:3|max:255',
            'available_tickets' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:Available,Upcoming,Closed',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator, 'organizer')
                ->withInput();
        }

        $data = $validator->validated();

        if ($request->hasFile('image')) {
            if ($event->image) {
                $oldImagePath = str_replace('storage/', '', $event->image);
                if (Storage::disk('public')->exists('events/' . $oldImagePath)) {
                    Storage::disk('public')->delete('events/' . $oldImagePath);
                }
            }

            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $imagePath = $request->file('image')->storeAs('events', $imageName, 'public');
            $data['image'] = $imageName;
        }

        $event->update($data);

        return redirect()->back()->with('success', 'Event has been updated successfully.');
    }


    public function DeleteEvent($id)
    {
        $event = Event::findorfail($id);
        $event->delete();
        return redirect()->back()->with('Success', 'Event has been Deleted Successfully');
    }
}
