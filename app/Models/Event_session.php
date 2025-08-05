<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event_session extends Model
{
    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }
}
