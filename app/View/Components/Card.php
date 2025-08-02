<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Card extends Component
{
    public $eventName, $date, $location, $image;

    public function __construct($eventName, $date, $location, $image)
    {
        $this->eventName = $eventName;
        $this->date = $date;
        $this->location = $location;
        $this->image = $image;
    }

    public function render()
    {
        return view('components.card');
    }
}
