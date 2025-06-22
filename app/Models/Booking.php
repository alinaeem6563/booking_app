<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];
    protected $fillable = ['user_id', 'provider_id', 'service_id', 'slot_id', 'start_time', 'end_time', 'duration', 'status', 'payment_status', 'service_offering_id', 'special_instruction'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function timeSlot()
    {
        return $this->belongsTo(TimeSlot::class);
    }
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function billingInformation()
    {
        return $this->hasOne(BillingInformation::class);
    }
    
}
