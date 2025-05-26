<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Review\ReviewController;
use App\Http\Controllers\category\CategoryController;
use App\Http\Controllers\Calendar\CalendarController;
use App\Http\Controllers\Booking\BookingController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\payment\PaymentController;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Review;


// ----------------------------
// Home & Static Pages
// ----------------------------
Route::get('/', [HomeController::class, 'index'])->name('/');
Route::get('coupon-management', function () {
    return view('coupons.coupon-management');
});

Route::get('categories', function () {
    return view('category.user-category');
});

Route::get('admin-category', function () {
    return view('category.admin-category');
});

// ----------------------------
// Authenticated Routes
// ----------------------------
Route::middleware('auth')->group(function () {

    // ----------------------------
    // Profile
    // ----------------------------
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ----------------------------
    // Dashboard (based on role)
    // ----------------------------


    Route::get('/dashboard', function () {
        $role = Auth::user()->account_type;

        $services = $role === 'provider' ? Service::with('provider')->get() : collect();
        $reviews  = $role === 'user' ? Review::with('user')->get() : collect();
        $bookings = collect();

        
            $bookings = Booking::with(['service', 'provider', 'timeSlot'])
                ->where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();
        $ProviderBookings = Booking::with(['user', 'service','provider', 'timeSlot'])
            ->where('provider_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        $providerId = Auth::id();
        $upcomingBookings = Booking::with(['user', 'service', 'timeSlot'])
            ->where('provider_id', Auth::id())
            ->where('status', '!=', 'completed')
            ->where('start_time', '>', now())
            ->get();

        $totalSpent = Booking::where('user_id', Auth::id())->sum('total_amount');
        $totalEarning = Booking::where('provider_id', Auth::id())->sum('total_amount');
           $completedBookings= Booking::where('user_id', Auth::id())
                ->where('status', 'completed')
                ->count();
           $providerCompletedBookings= Booking::where('provider_id', Auth::id())
                ->where('status', 'completed')
                ->count();
                $upComingBooking= Booking::where('user_id', Auth::id())
                ->whereIn('status', ['pending', 'confirmed'])
                ->where('payment_status', 'confirmed')
                ->count();
                $providerUpComingBooking= Booking::where('provider_id', Auth::id())
                ->whereIn('status', ['pending', 'confirmed'])
                ->where('payment_status', 'confirmed')
                ->count();
            $recommendedServices = Service::with(['provider', 'reviews'])->inRandomOrder()->limit(3)->get();
        $totalClients= Booking::where('provider_id', $providerId)
            ->distinct('user_id')
            ->count('user_id');

        return match ($role) {
            'admin'    => view('admin.admin-dashboard'),
            'provider' => view('provider.provider-dashboard', compact('services', 'ProviderBookings', 'upcomingBookings', 'totalEarning', 'providerCompletedBookings', 'providerUpComingBooking', 'totalClients')),
            'user'     => view('customer.user-dashboard', compact('upComingBooking','completedBookings','totalSpent','reviews', 'services', 'bookings', 'recommendedServices')),
            default    => abort(403),
        };
    })->middleware(['verified'])->name('dashboard');


    // ----------------------------
    // Payments
    // ----------------------------
    Route::get('/payment/{booking}', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/{booking}/process', [PaymentController::class, 'process'])->name('payment.process');
    Route::get('/payment/{booking}/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/{booking}/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
    Route::get('/payment-declined', function () {
        return view('payment.payment-declined');
    })->name('payment-declined');

    // ----------------------------
    // Billing
    // ----------------------------
    Route::post('/billing-info', [PaymentController::class, 'storeBillingInfo'])->name('billing.info');

    // ----------------------------
    // Calendar & Availability
    // ----------------------------

    // Provider adds timeslot or day off
    Route::post('time-slot', [CalendarController::class, 'storeTimeSlot'])->name('time-slot');
    Route::post('days-off', [CalendarController::class, 'storeDayOff'])->name('days-off');
    
    // View services of a specific provider
    Route::get('/providers/{provider}/services', [CalendarController::class, 'getProviderServices']);
    
    // ----------------------------
    // Booking
    // ----------------------------
    Route::post('booking', [BookingController::class, 'store'])->name('booking-store');
    
    // ----------------------------
    // Categories & Reviews
    // ----------------------------
    Route::resource('categories', CategoryController::class);
    Route::resource('reviews', ReviewController::class);

    
});

    // Provider calendar slots view
    Route::get('/calendar/provider-slots', [CalendarController::class, 'getSlots'])->name('calendar.provider-slots');

    // User calendar views
    Route::get('/calendar/daysoff', [CalendarController::class, 'getDaysOff']);
    Route::get('/calendar/slots', [CalendarController::class, 'getAvailableSlots']);

// ----------------------------
// Fallback 404
// ----------------------------
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});

// ----------------------------
// Auth & Provider Specific Routes
// ----------------------------
require __DIR__ . '/auth.php';
require __DIR__ . '/provider.php';
