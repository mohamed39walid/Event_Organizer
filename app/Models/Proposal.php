<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    public function speaker()
    {
        return $this->belongsTo(User::class, 'speaker_id');
    }
    
public function session()
{
    return $this->hasOne(Event_session::class);
}
    protected $fillable = [
        'title',
        'description',
        'status',
        'cv',
        'speaker_id',
        'event_id',
    ];
}
