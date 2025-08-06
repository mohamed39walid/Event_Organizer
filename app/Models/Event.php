<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    // Event.php
    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }
    // في ملف Event.php
    protected $fillable = [
        'event_name',
        'location',
        'start_date',
        'end_date',
        'available_tickets',
        'status',
        'organizer_id', // لو فيه علاقة مع المستخدم
    ];
}
