<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Psy\Readline\Hoa\EventException;

class TicketController extends Controller
{
    public function BookTicket($id)
    {
        $event = Event::find($id);
        $user_id = Auth::id();

        if (!$event) {
            return redirect()->back()->with('error', 'Invalid event ID.');
        }

        $existing_ticket = Ticket::where('user_id', $user_id)->where('event_id', $id)->first();

        if ($existing_ticket) {
            return redirect()->back()->with('info', 'You have already booked this event.');
        }

        Ticket::create([
            'checked_in' => 'no',
            'user_id' => $user_id,
            'event_id' => $id,
        ]);

        return redirect()->route('tickets.my-tickets')->with('success', 'Ticket booked successfully.');
    }

    public function UnBookTicket($id)
    {
        $user_id = Auth::id();
        $ticket = Ticket::where('id', $id)->where('user_id', $user_id)->first();

        if (!$ticket) {
            return redirect()->back()->with('error', "Ticket not found or doesn't belong to you.");
        }

        $ticket->delete();

        return redirect()->route('tickets.my-tickets')->with('success', 'Ticket unbooked successfully.');
    }



    public function mytickets()
    {
        $user_id = Auth::id();
        $tickets = Ticket::where("user_id", $user_id)->get();
        $event = Event::where("id", )->get();
        return view("pages.user.my-tickets", compact("tickets", 'event'));
    }
}



