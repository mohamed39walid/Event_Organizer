<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Card extends Component
{
    public $eventid, $eventName, $date, $endDate, $location, $image, $tickets, $status, $organizer;

    public function __construct($eventid, $eventName, $date, $location, $image, $endDate = null, $tickets = 'Available', $status = 'Active', $organizer = 'Unknown')
    {
        $this->eventid = $eventid;
        $this->eventName = $eventName;
        $this->date = $date;
        $this->endDate = $endDate ?? $date;
        $this->location = $location;
        $this->image = $image;
        $this->tickets = $tickets;
        $this->status = $status;
        $this->organizer = $organizer;
    }

    public function render()
    {
        return view('components.card');
    }
}
