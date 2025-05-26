<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillingInformation extends Model
{
    protected $table= 'billing_information';
    protected $fillable=['booking_id', 'first_name', 'last_name', 'email', 'address', 'city', 'province', 'zip_code', 'country'];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
