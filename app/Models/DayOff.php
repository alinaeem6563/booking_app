<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DayOff extends Model
{
    protected $table= 'provider_days_off';
    protected $fillable = ['provider_id', 'type', 'day_name', 'off_date'];
    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }
}
