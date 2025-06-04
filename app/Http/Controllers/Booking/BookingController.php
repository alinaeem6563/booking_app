<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\TimeSlot;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index(){
        $bookings = Booking::all();
        return view('provider.provider-dashboard',compact('bookings'));

    }

public function UpcomingBookings(){
return view('booking.upcoming-bookings');
}
public function BookingRequests(){
return view('provider.booking-requests');
}
    public function store(Request $request)
    {
        $request->validate([
            'provider_id' => 'required|exists:users,id',
            'service_id'  => 'required|exists:services,id',
            'service_offering_id'=>'required|string',
            'slot_id'     => 'required|exists:time_slots,id',
            'start_time'  => 'required|date|after_or_equal:now',
            'end_time'    => 'required|date|after:start_time',
            'duration'    => 'required|integer|min:1',
            'additional_services' => 'nullable|array',  // Validate as array
            'total_amount' => 'required|numeric|min:0',
        ]);

        // Check if the slot is already booked (status: pending or confirmed)
        $exists = Booking::where('slot_id', $request->slot_id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($exists) {
            return redirect()->back()->withErrors('This slot has already been booked.');
        }

        // Convert ISO strings to Carbon instances
        $start = Carbon::parse($request->start_time);
        $end   = Carbon::parse($request->end_time);

        // Create and save the booking
        $booking = new Booking();
        $booking->user_id        = Auth::id();
        $booking->provider_id    = $request->provider_id;
        $booking->service_id     = $request->service_id;
        $booking->slot_id        = $request->slot_id;
        $booking->start_time     = $start; // Will be stored as DATETIME
        $booking->end_time       = $end;
        $booking->duration       = $request->duration;
        $booking->status         = 'pending';
        $booking->payment_status = 'pending';
        $booking->service_offering_id = $request->service_offering_id;
        $additionalServices = $request->additional_services;
        if ($request->has('additional_services')) {
            // Store as JSON string
            $booking->additional_services = json_encode($request->additional_services);
        } else {
            $booking->additional_services = null;
        }

        $booking->total_amount = $request->total_amount;
        $booking->save();

        //  Mark the slot as booked
        $slot = TimeSlot::find($request->slot_id);
        if ($slot) {
            $slot->is_booked = 1;
            $slot->save();
        }
        return redirect()->route('payment.show', ['booking' => $booking->id])
            ->with('success', 'Booking created successfully!');
    }
    public function accept($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'confirmed';
        $booking->save();

        return redirect()->back()->with('success', 'Booking confirmed successfully.');
    }

    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'canceled';
        $booking->save();

        return redirect()->back()->with('success', 'Booking canceled successfully.');
    }
}
