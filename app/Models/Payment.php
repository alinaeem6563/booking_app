<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable=['booking_id', 'amount', 'payment_gateway', 'status', 'card_brand', 'card_last4'];
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
