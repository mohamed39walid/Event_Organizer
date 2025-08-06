<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    protected $fillable = [
        'event_name',
        'location',
        'start_date',
        'end_date',
        'available_tickets',
        'status',
         'image',
        'organizer_id', 
    ];
}
