<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Proposal;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
    $proposal = Proposal::where("event_id", $id)
    ->where("speaker_id", $user_id)
    ->whereIn('status', ['approved', 'pending'])
    ->first();

if ($proposal) {
    return redirect()->back()->with("error", "You can't book a ticket in this Event as you are A Speaker");
}

        DB::beginTransaction();
        try {
            if ($event->available_tickets > 0) {
                $event->available_tickets -= 1;
                $event->save();
                Ticket::create([
                    'checked_in' => 'no',
                    'user_id' => $user_id,
                    'event_id' => $id,
                ]);
                DB::commit();
                return redirect()->route('tickets.my-tickets')->with('success', 'Ticket booked successfully.');
            } else {
                DB::rollBack();
                return redirect()->back()->with('info', "There is no tickets for this event anymore.");
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function UnBookTicket($id)
    {
        $user_id = Auth::id();
        $ticket = Ticket::where('id', $id)->where('user_id', $user_id)->first();
        if (!$ticket) {
            return redirect()->back()->with('error', "Ticket not found or doesn't belong to you.");
        }
        $event = Event::find($ticket->event_id);
        DB::beginTransaction();
        try {
            $event->available_tickets += 1;
            $event->save();
            $ticket->delete();
            DB::commit();
            return redirect()->route('tickets.my-tickets')->with('success', 'Ticket unbooked successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }



    public function mytickets()
    {
        $user_id = Auth::id();
        $tickets = Ticket::where("user_id", $user_id)->get();
        $event = Event::where("id",)->get();
        return view("pages.user.my-tickets", compact("tickets", 'event'));
    }

    public function AllTicketsForOrganizer($id){
        $event = Event::findorfail($id);
        $tickets = Ticket::where('event_id', $id);

        return view('');
    }
}
