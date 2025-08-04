<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        "checked_in",
        "user_id",
        "event_id",
    ];
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
