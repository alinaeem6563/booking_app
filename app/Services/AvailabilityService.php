<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\TimeSlot;
use Carbon\Carbon;

class AvailabilityService
{
    public function getAvailabilityForService($serviceId, $days = 7)
    {
        $availability = [];

        for ($i = 0; $i < $days; $i++) {
            $date = Carbon::today()->addDays($i)->toDateString();

            $totalSlots = TimeSlot::where('service_id', $serviceId)
                ->whereDate('start_time', $date)
                ->count();

            $bookedSlots = Booking::where('service_id', $serviceId)
                ->whereDate('start_time', $date)
                ->count();

            if ($totalSlots === 0) {
                $availability[$date] = 'No Slots';
            } elseif ($bookedSlots >= $totalSlots) {
                $availability[$date] = 'Fully Booked';
            } else {
                $availability[$date] = 'Available Today';
            }
        }

        return $availability;
    }

    public function getTodayStatus($serviceId)
    {
        $availability = $this->getAvailabilityForService($serviceId, 1);
        return $availability[Carbon::today()->toDateString()] ?? 'No Slots';
    }
}
