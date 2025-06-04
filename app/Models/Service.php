<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $casts = [
        'faqs' => 'array',
        'work_gallery' => 'array',
        'service_offerings' => 'array',
        
    ];
    public function getOfferingById($offeringId)
    {
        // Decode outer JSON if it's still a string
        $offerings = $this->service_offerings;

        if (is_string($offerings)) {
            $offerings = json_decode($offerings, true);
        }

        if (!is_array($offerings)) {
            return null; // Not an array, so nothing to loop
        }

        foreach ($offerings as $offeringJson) {
            $offering = is_string($offeringJson) ? json_decode($offeringJson, true) : $offeringJson;
            if (isset($offering['service_id']) && $offering['service_id'] === $offeringId) {
                return $offering;
            }
        }

        return null;
    }


    protected $fillable=['service_name', 'service_description', 'category_id', 'service_duration', 'service_price', 'service_location', 'service_image', 'service_status','provider_id','work_gallery', 'service_offerings', 'additional_services', 'qualifications_certifications', 'faqs','service_fee', 'tax'];
    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function timeSlots()
    {
        return $this->hasMany(TimeSlot::class);
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    public function savedProviders()
    {
        return $this->hasMany(SavedProvider::class);
    }
}
