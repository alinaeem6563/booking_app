<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Category;
use App\Models\TimeSlot;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::all();
        return view('provider.provider-dashboard', compact('bookings'));
    }



    public function UpcomingBookings()
    {
        $today = Carbon::today();
        $bookingUpcoming = Booking::whereDate('start_time', '>=', $today)
            ->whereIn('status', ['confirmed', 'pending'])
            ->orderBy('start_time')
            ->get();
        $user = Auth::user();
        $now = now();

        // Determine role and column
        $isProvider = $user->account_type === 'provider';
        $column = $isProvider ? 'provider_id' : 'user_id';

        $upcomingBookings = Booking::with(['user', 'service.category'])
            ->where($column, $user->id)
            ->orderByRaw("CASE WHEN start_time >= ? THEN 0 ELSE 1 END", [$now]) // Upcoming first
            ->orderBy('start_time')
            ->get()
            ->map(function ($booking) {
                // Decode service offerings JSON
                $offerings = json_decode($booking->service->service_offerings ?? '[]', true);

                // Find the offering that matches the booking's offering ID
                $matchedOffering = collect($offerings)->firstWhere('service_id', $booking->service_offering_id);
                return [
                    'id' => $booking->id,
                    'clientName' => $booking->user->first_name . ' ' . $booking->user->last_name,
                    'clientPhone' => $booking->user->phone,
                    'clientImage' => $booking->user->profile_image ?? 'images/default-avatar.png',
                    'service' =>  $matchedOffering['service_name'] ?? 'Not found',
                    'category' => $booking->service->category->category_name ?? '',
                    'time' => \Carbon\Carbon::parse($booking->start_time)->format('h:i A'),
                    'endTime' => \Carbon\Carbon::parse($booking->end_time)->format('h:i A'),
                    'duration' => $booking->duration . ' Hours',
                    'total' => $booking->total_amount,
                    'status' => $booking->status,
                    'date' => \Carbon\Carbon::parse($booking->start_time)->toDateString(),
                    'isToday' => \Carbon\Carbon::parse($booking->start_time)->isToday(),
                    'address' => $booking->billingInformation->address ?? '',
                    'notes' => $booking->special_instruction ?? '',
                ];
            });

        return view('booking.upcoming-bookings', [
            'bookingUpcoming' => $bookingUpcoming,
            'upcomingBookings' => $upcomingBookings,

        ]);
    }





    public function BookingRequests()
    {
        $bookings = Booking::with(['user', 'service'])->where('provider_id', Auth::id())->get();
        $bookingsPending = Booking::with(['user', 'service'])->where('status', 'pending')->count();
        $bookingsTotal = Booking::all()->count();
        $categories = Category::all();
        $bookingRequests = $bookings->map(function ($booking) {
            // Decode service offerings JSON
            $offerings = json_decode($booking->service->service_offerings ?? '[]', true);

            // Find the offering that matches the booking's offering ID
            $matchedOffering = collect($offerings)->firstWhere('service_id', $booking->service_offering_id);

            return [
                'id' => $booking->id,
                'clientName' => trim(($booking->user->first_name ?? '') . ' ' . ($booking->user->last_name ?? '')),
                'clientImage' => $booking->user->profile_photo_url ?? asset('images/default-avatar.png'),
                'requestDate' => $booking->created_at,
                'status' => $booking->status,
                'service' => $matchedOffering['service_name'] ?? 'Not found',
                'date' => $booking->start_time->toDateString(),
                'time' => $booking->start_time->format('H:i A'),
                'duration' => $booking->duration . ' Hours',
                'total_amount' => $booking->total_amount,
                'address' => optional($booking->billingInformation)->address ?? 'N/A',
                'description' => $booking->special_instruction ?? '',
            ];
        });

        return view('provider.booking-requests', [
            'bookingRequests' => $bookingRequests,
            'bookingsPending' => $bookingsPending,
            'bookingsTotal' => $bookingsTotal,
            'categories' => $categories,
        ]);
    }



    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:confirmed,canceled,completed']);
        Booking::findOrFail($id)->update(['status' => $request->status]);
        return response()->json(['success' => true, 'message' => 'Booking status updated.']);
    }


    public function store(Request $request)
    {
        $request->validate([
            'provider_id' => 'required|exists:users,id',
            'service_id'  => 'required|exists:services,id',
            'service_offering_id' => 'required|string',
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
        $booking->special_instruction = $request->special_instruction;
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

        if ($booking->slot_id) {
            $slot = TimeSlot::find($booking->slot_id);
            if ($slot) {
                $slot->is_booked = 0;
                $slot->save();
            }
        }

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Booking canceled successfully.'
            ]);
        }

        return redirect()->back()->with('success', 'Booking canceled successfully.');
    }

    /**
     * Show reschedule form or return JSON data for AJAX
     */
    public function showRescheduleForm($id)
    {
        $booking = Booking::with('TimeSlot')->findOrFail($id);

        // Check if same-day booking
        $isToday = Carbon::parse($booking->start_time)->isToday();

        // Fetch available slots (only if not same-day)
        $availableSlots = collect();
        if (!$isToday) {
            $availableSlots = TimeSlot::where('provider_id', $booking->provider_id)
                ->where('date', '>=', now()->toDateString())
                ->where('is_booked', 0) // Only available slots
                ->orderBy('date')
                ->orderBy('start_time')
                ->get();
        }
        $offerings = json_decode($booking->service->service_offerings ?? '[]', true);

        // Find the offering that matches the booking's offering ID
        $matchedOffering = collect($offerings)->firstWhere('service_id', $booking->service_offering_id);
        // Return JSON for AJAX requests
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'booking' => [
                    'id' => $booking->id,
                    'service_name' => $matchedOffering['service_name'] ?? 'N/A',
                    'start_time' => $booking->start_time,
                    'end_time' => $booking->end_time,
                    'provider_id' => $booking->provider_id,
                ],
                'availableSlots' => $availableSlots->map(function ($slot) {
                    return [
                        'id' => $slot->id,
                        'date' => $slot->date,
                        'duration' => $slot->duration,
                        'start_time' => $slot->start_time,
                        'end_time' => $slot->end_time,
                        'is_booked' => $slot->is_booked,
                    ];
                }),
                'isToday' => $isToday,
            ]);
        }

        // Return view for non-AJAX requests
        return view('bookings.reschedule-modal', compact('booking', 'availableSlots', 'isToday'));
    }

    /**
     * Submit reschedule request
     */
    public function reschedule(Request $request, $id)
    {
        $request->validate([
            'slot_id' => 'required|exists:time_slots,id',
        ]);

        try {
            $booking = Booking::findOrFail($id);

            $newSlot = TimeSlot::findOrFail($request->slot_id);

            // Check if new slot is available
            if ($newSlot->is_booked) {
                return response()->json([
                    'success' => false,
                    'message' => 'Selected time slot is no longer available.'
                ], 400);
            }

            // Get old slot to free it up
            $oldSlot = TimeSlot::find($booking->slot_id);

            // Begin transaction
            DB::beginTransaction();

            try {
                // Update booking with new slot details
                $booking->update([
                    'slot_id' => $newSlot->id,
                    'start_time' => $newSlot->start_time,
                    'end_time' => $newSlot->end_time,
                ]);

                // Mark new slot as booked
                $newSlot->update(['is_booked' => 1]);

                // Free up old slot if it exists
                if ($oldSlot) {
                    $oldSlot->update(['is_booked' => 0]);
                }

                DB::commit();

                // Return JSON for AJAX requests
                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Booking rescheduled successfully.',
                        'booking' => [
                            'id' => $booking->id,
                            'start_time' => $booking->start_time,
                            'end_time' => $booking->end_time,
                        ]
                    ]);
                }

                return redirect()->route('dashboard')->with('success', 'Booking rescheduled successfully.');
            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to reschedule booking: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->withErrors('Failed to reschedule booking: ' . $e->getMessage());
        }
    }

    /**
     * Cancel booking (optional method)
     */
    // public function cancel($id)
    // {
    //     try {
    //         $booking = Booking::findOrFail($id);

    //         // Free up the time slot
    //         if ($booking->slot_id) {
    //             $slot = TimeSlot::find($booking->slot_id);
    //             if ($slot) {
    //                 $slot->update(['is_booked' => 0]);
    //             }
    //         }

    //         // Update booking status to cancelled
    //         $booking->update(['status' => 'cancelled']);

    //         if (request()->wantsJson()) {
    //             return response()->json([
    //                 'success' => true,
    //                 'message' => 'Booking cancelled successfully.'
    //             ]);
    //         }

    //         return redirect()->route('dashboard')->with('success', 'Booking cancelled successfully.');
    //     } catch (\Exception $e) {
    //         if (request()->wantsJson()) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Failed to cancel booking: ' . $e->getMessage()
    //             ], 500);
    //         }

    //         return redirect()->back()->withErrors('Failed to cancel booking: ' . $e->getMessage());
    //     }
    // }
}
