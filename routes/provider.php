<?php

use App\Http\Controllers\Booking\BookingController;
use App\Http\Controllers\Calendar\CalendarController;
use App\Http\Controllers\invoice\InvoiceController;
use App\Http\Controllers\Provider\ProviderAppointmentController;
use App\Http\Controllers\Review\ReviewController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

Route::resource('providers', ProviderAppointmentController::class);

Route::middleware(['auth', 'is_provider'])->group(function () {
    Route::post('/booking/{id}/accept', [BookingController::class, 'accept'])->name('booking.accept');
    Route::post('/booking/{id}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');
    //reviews
    Route::patch('reviews/{review}/approve', [ReviewController::class, 'approve'])->name('provider.reviews.approve');
    Route::delete('reviews/bulk-delete', [ReviewController::class, 'bulkDelete'])->name('provider.reviews.bulk-delete');
    Route::get('reviews/export', [ReviewController::class, 'export'])->name('provider.reviews.export');

    //bookings
    Route::get('all-booking-requests', [BookingController::class, 'BookingRequests'])->middleware('auth')->name('all-booking-requests');
    Route::post('/bookings/{id}/update-status', [BookingController::class, 'updateStatus'])->name('update-status');

    //invoice
    Route::get('invoices', [InvoiceController::class, 'index'])->name('invoices');

    //day off and slots
    Route::post('time-slot', [CalendarController::class, 'storeTimeSlot'])->name('time-slot');
    Route::post('days-off', [CalendarController::class, 'storeDayOff'])->name('days-off');
    Route::get('/calendar/slots', [CalendarController::class, 'getSlots']);
    Route::get('/calendar/daysoff', [CalendarController::class, 'getDaysOff']);

    //calendar
    Route::resource('calendar', CalendarController::class);

    //service
    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
    Route::put('/services/{service}', [ServiceController::class, 'update'])->name('services.update');
    Route::post('/services/{service}/toggle-status', [ServiceController::class, 'toggleStatus'])->name('services.toggle-status');
    Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');

    //coupon
    Route::get('coupon-management', function () {
        return view('coupons.coupon-management');
    });
});
