<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event_session extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_id',
        'speaker_id',
        'proposal_id',
        'organizer_id',
        'start_date',
        'end_date',
    ];
public static function boot()
{
    parent::boot();
    
    static::creating(function($session) {
        if (!$session->event_id || !$session->speaker_id || !$session->proposal_id) {
            throw new \Exception("All foreign keys are required");
        }
    });
}

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

    public function speaker()
    {
        return $this->belongsTo(User::class, 'speaker_id');
    }

    public function getFormattedStartDateAttribute()
    {
        return $this->start_date->format('M d, Y H:i');
    }

    public function getFormattedEndDateAttribute()
    {
        return $this->end_date->format('H:i');
    }

    public function getDurationAttribute()
    {
        return $this->start_date->diffInMinutes($this->end_date);
    }
}