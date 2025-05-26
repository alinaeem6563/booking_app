<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    protected $fillable=['provider_id', 'service_id', 'date', 'duration', 'start_time', 'end_time', 'is_booked'];
    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function booking()
    {
        return $this->hasOne(Booking::class);
    }
}
