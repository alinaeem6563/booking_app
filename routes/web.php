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
use App\Http\Controllers\Provider\SavedProviderController;
use App\Http\Controllers\ReviewController as ControllersReviewController;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Service;
use App\Models\Review;


// ----------------------------
// Home & Static Pages
// ----------------------------
Route::get('/', [HomeController::class, 'index'])->name('/');
Route::get('coupon-management', function () {
    return view('coupons.coupon-management');
});


Route::get('all-categories',[CategoryController::class ,'UserCategory'])->name('all-categories');

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
        $categories=Category::all()
;        $services = $role === 'provider' ? Service::with('provider')->get() : collect();
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
            'admin'    => view('admin.admin-dashboard', compact('categories', 'services')),
            'provider' => view('provider.provider-dashboard', compact('services', 'reviews' ,'ProviderBookings', 'upcomingBookings', 'totalEarning', 'providerCompletedBookings', 'providerUpComingBooking', 'totalClients', 'categories')),
            'user'     => view('customer.user-dashboard', compact('upComingBooking','completedBookings','totalSpent','reviews', 'services', 'bookings', 'recommendedServices')),
            default    => abort(403),
        };
    })->middleware(['verified'])->name('dashboard');


    // ----------------------------
    // Payments
    // ----------------------------
    Route::get('payment-methods', [PaymentController::class, 'index'])->name('payment-methods');
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
    // Route::get('/provider/calendar/service/{id}', [CalendarController::class, 'create'])->name('provider-calendar');

    // Provider adds timeslot or day off
    Route::post('time-slot', [CalendarController::class, 'storeTimeSlot'])->name('time-slot');
    Route::post('days-off', [CalendarController::class, 'storeDayOff'])->name('days-off');
    Route::get('/calendar/slots', [CalendarController::class, 'getSlots']);
    Route::get('/calendar/daysoff', [CalendarController::class, 'getDaysOff']);


    // View services of a specific provider
    Route::get('/providers/{provider}/services', [CalendarController::class, 'getProviderServices']);
    
    // ----------------------------
    // Booking
    // ----------------------------
    Route::post('booking', [BookingController::class, 'store'])->name('booking-store');
    Route::post('/booking/{id}/accept', [BookingController::class, 'accept'])->name('booking.accept');
    Route::post('/booking/{id}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');

    // ----------------------------
    // Categories & Reviews
    // ----------------------------
    Route::resource('categories', CategoryController::class);
    Route::resource('reviews', ReviewController::class);
    Route::middleware(['auth'])->prefix('provider')->group(function () {
        // Route::get('reviews', [ReviewController::class, 'index'])->name('provider.reviews.index');
        Route::patch('reviews/{review}/approve', [ReviewController::class, 'approve'])->name('provider.reviews.approve');
        Route::delete('reviews/bulk-delete', [ReviewController::class, 'bulkDelete'])->name('provider.reviews.bulk-delete');
        Route::get('reviews/export', [ReviewController::class, 'export'])->name('provider.reviews.export');
    });

    
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

Route::middleware(['auth'])->group(function () {
    Route::get('/provider/services/{providerId}', [CalendarController::class, 'getProviderServices']);
    Route::get('/calendar/daysoff', [CalendarController::class, 'getDaysOff']);
    Route::get('/calendar/slots', [CalendarController::class, 'getAvailableSlots']);
});
// web.php
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/providers', [CalendarController::class, 'getAllProviders']);
});
Route::post('/saved-providers', [SavedProviderController::class, 'toggle'])->middleware('auth');
Route::get('/all-saved-providers', [SavedProviderController::class, 'index'])->middleware('auth')->name('all-saved-providers');
Route::get('get-saved-providers', [SavedProviderController::class, 'getJson'])->middleware('auth');
Route::get('upcoming-bookings', [BookingController::class, 'UpcomingBookings'])->middleware('auth')->name('upcoming-bookings');
Route::get('all-booking-requests', [BookingController::class, 'BookingRequests'])->middleware('auth')->name('all-booking-requests');


Route::get('print-receipt',function(){
    return view('payment.print-receipt');
})->name('print-receipt');
Route::get('earnings',function(){
    return view('earning.earnings');
})->name('earnings');
Route::get('invoices',function(){
    return view('invoice.invoices');
})->name('invoices');
Route::get('single-invoice',function(){
    return view('invoice.single-invoice-page');
})->name('single-invoice');
// ----------------------------
// Auth & Provider Specific Routes
// ----------------------------
require __DIR__ . '/auth.php';
require __DIR__ . '/provider.php';
