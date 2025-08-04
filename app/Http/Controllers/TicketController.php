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
        $checked_in = "no";
        if (!$event) {
            echo "enter a real id";
        } else {
            $existing_id = Ticket::where("user_id", $user_id)->where("event_id", $id)->first();
            if ($existing_id) {
                echo "this event is booked";
            } else {

                Ticket::create([
                    "checked_in" => $checked_in,
                    "user_id" => $user_id,
                    "event_id" => $id,
                ]);
                echo "Ticket Booked Successfully";
            }
        }
    }

    public function UnBookTicket($id){
        $user_id = Auth::id();
        $ticket = Ticket::where("id",$id)->where("user_id",$user_id)->first();
        if(!$ticket){
            echo "enter a valid ticket id or this ticket isn't for you";
        }else{
            $ticket->delete();
            echo "the ticket unbooked";
        }
    }


    public function mytickets(){
        $user_id = Auth::id();
        $tickets = Ticket::where("user_id",$user_id)->get();
        echo $tickets;
    }
}
