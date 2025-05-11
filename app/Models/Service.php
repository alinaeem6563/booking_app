<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable=['service_name', 'service_description', 'service_category', 'service_duration', 'service_price', 'service_location', 'service_image', 'service_status','provider_id','work_gallery', 'service_offerings', 'additional_services', 'qualifications_certifications'];
    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
