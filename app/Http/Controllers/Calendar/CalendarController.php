<?php

namespace App\Http\Controllers\Calendar;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\DayOff;
use App\Models\Service;
use App\Models\TimeSlot;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $providers = User::where('account_type', 'provider')->get();
        $services = Service::all();
        return view('calendar.admin-calendar', compact('providers', 'services'));
    }
    public function getAllProviders()
    {
        return User::where('account_type', 'provider')
            ->get()
            ->map(fn($user) => ['id' => $user->id, 'name' => $user->full_name]);
    }


    public function getProviderServices($providerId)
    {
        $services = Service::where('provider_id', $providerId)->get(['id', 'service_name', 'service_duration', 'service_offerings']);
    
        $result = [];
    
        foreach ($services as $service) {
            $result[] = [
                'id' => $service->id,
                'service_name' => $service->service_name,
                'service_duration' => $service->service_duration,
                'offerings' => json_decode($service->service_offerings, true),
            ];
        }
    
        return response()->json($result);
    }
    
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $providerServices = Service::where('provider_id', Auth::id())->get();

        $events = TimeSlot::with('service.provider')->get()->map(function ($slot) {
            return [
                'title' => $slot->is_available ? 'Available' : 'Booked',
                'start' => $slot->start_time,
                'end' => $slot->end_time,
                'service_id' => $slot->service_id,
                'provider_id' => $slot->service->provider_id ?? null,
                'extendedProps' => [
                    'service_name' => $slot->service->service_name ?? 'Service',
                    'provider_name' => $slot->service->provider->first_name ?? 'Provider',
                ],
            ];
        });

        return view('calendar.provider-calendar', compact('providerServices', 'events'));
    }
    public function sidebar($id)
    {
        $service = Service::findOrFail($id);
        return view('navigation.sidebar', compact('service'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function storeTimeSlot(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'date' => 'required|date',
            'duration' => 'required|integer|min:1',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        // Prevent adding slots on off-days
        if ($this->isDayOff($request->provider_id, $request->date)) {
            return redirect()->back()->with('error', 'Selected day is off');
        }


        // Optional: Check for overlapping time slots
        $exists = TimeSlot::where('provider_id', Auth::id())
            ->where('date', $request->date)
            ->where(function ($q) use ($request) {
                $q->whereBetween('start_time', [$request->start_time, $request->end_time])
                    ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                    ->orWhere(function ($q2) use ($request) {
                        $q2->where('start_time', '<=', $request->start_time)
                            ->where('end_time', '>=', $request->end_time);
                    });
            })->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Slot overlaps with an existing slot');
        }


        TimeSlot::create([
            'provider_id' => Auth::id(),
            'service_id' => $request->service_id,
            'date' => $request->date,
            'duration' => $request->duration,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'is_booked' => $request->has('is_booked') ? $request->is_booked : false,
        ]);

        return redirect()->back()->with('success', 'Slot added');
    }


    public function storeDayOff(Request $request)
    {
        $request->validate([
            'type' => 'required|in:weekly,date',
            'day_name' => 'nullable|string',
            'off_date' => 'nullable|date',
        ]);

        DayOff::create([
            'provider_id' => Auth::id(),
            'type' => $request->type,
            'day_name' => $request->day_name,
            'off_date' => $request->off_date,
        ]);

        return redirect()->back()->with('success', 'Slot added');
    }

    public function getSlots(Request $request)
    {
        // Optionally parse start and end if you want to filter slots by date range:
        $start = $request->query('start');
        $end = $request->query('end');

        $query = TimeSlot::where('provider_id', Auth::id());

        if ($start && $end) {
            $startDate = Carbon::parse($start)->toDateString();
            $endDate = Carbon::parse($end)->toDateString();

            $query->whereBetween('date', [$startDate, $endDate]);
        }

        $slots = $query->get()->map(function ($slot) {
            return [
                'slot_id' => $slot->id,
                'title' => $slot->is_booked ? 'Booked' : 'Available',
                'start' => $slot->date . 'T' . $slot->start_time,
                'end' => $slot->date . 'T' . $slot->end_time,
                'is_booked' => $slot->is_booked,
            ];
        });

        return response()->json($slots);
    }


    public function getDaysOff(Request $request)
    {
        $serviceId = $request->service_id;

        $service = Service::findOrFail($serviceId);
        $providerId = $service->provider_id;

        $dayOffs = DayOff::where('provider_id', $providerId)->get();
        $events = [];

        foreach ($dayOffs as $off) {
            if ($off->type === 'weekly') {
                $events[] = [
                    'daysOfWeek' => [$this->convertDayNameToIndex($off->day_name)], // 0 = Sunday, 6 = Saturday
                    'display' => 'background',
                    'color' => '#f8d7da',
                    'title' => 'Day Off',
                ];
            } elseif ($off->type === 'date') {
                $events[] = [
                    'start' => $off->off_date,
                    'end' => Carbon::parse($off->off_date)->addDay()->toDateString(), // FullCalendar uses exclusive end
                    'display' => 'background',
                    'color' => '#f8d7da',
                    'title' => 'Day Off',
                    'allDay' => true,
                ];
            }
        }

        return response()->json($events);
    }

    public function getAvailableSlots(Request $request)
    {
        try {
            Log::info('getAvailableSlots called with:', $request->all());

            $serviceId = $request->service_id;
            $startInput = $request->start;
            $endInput = $request->end;

            if (!$serviceId || !$startInput || !$endInput) {
                return response()->json(['error' => 'Missing service_id, start, or end'], 400);
            }

            $service = Service::findOrFail($serviceId); // May throw exception if not found
            Log::info("Found service: {$service->id}");

            $providerId = $service->provider_id;
            Log::info("Provider ID: {$providerId}");

            $start = Carbon::parse($startInput)->startOfDay();
            $end = Carbon::parse($endInput)->endOfDay();

            Log::info("Date range: $start to $end");

            $slots = TimeSlot::where('service_id', $serviceId)
                ->whereBetween('date', [$start->toDateString(), $end->toDateString()])
                ->get();

            Log::info('Slot count: ' . $slots->count());

            $events = [];

            foreach ($slots as $slot) {
                if (method_exists($this, 'isDayOff') && $this->isDayOff($providerId, $slot->date)) {
                    Log::info("Skipping slot on day off: {$slot->date}");
                    continue;
                }

                $slotStart = Carbon::parse("{$slot->date} {$slot->start_time}");
                $slotEnd = Carbon::parse("{$slot->date} {$slot->end_time}");

                $events[] = [
                    'id' => $slot->id,
                    'title' => $slot->is_booked ? 'Booked' : 'Available',
                    'start' => $slotStart->toIso8601String(),
                    'end' => $slotEnd->toIso8601String(),
                    'backgroundColor' => $slot->is_booked ? '#f87171' : '#34d399',
                    'borderColor' => $slot->is_booked ? '#ef4444' : '#10b981',
                    'className' => $slot->is_booked ? 'booked-slot' : 'available-slot',
                    'overlap' => false,
                    'editable' => false,
                ];
            }

            return response()->json($events);
        } catch (\Exception $e) {
            Log::error('Error in getAvailableSlots: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to fetch slots',
                'message' => $e->getMessage()
            ], 500);
        }
    }



    private function convertDayNameToIndex($dayName)
    {
        return [
            'Sunday' => 0,
            'Monday' => 1,
            'Tuesday' => 2,
            'Wednesday' => 3,
            'Thursday' => 4,
            'Friday' => 5,
            'Saturday' => 6,
        ][$dayName] ?? null;
    }


    protected function isDayOff($providerId, $date)
    {
        $dayOffs = DayOff::where('provider_id', $providerId)
            ->where(function ($query) use ($date) {
                $query->where(function ($q) use ($date) {
                    $q->where('type', 'date')
                        ->where('off_date', $date);
                })
                    ->orWhere(function ($q) use ($date) {
                        $dayName = Carbon::parse($date)->format('l'); // e.g. Monday
                        $q->where('type', 'weekly')
                            ->where('day_name', $dayName);
                    });
            })
            ->exists();

        return $dayOffs;
    }
}
