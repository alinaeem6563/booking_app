<?php

use App\Http\Controllers\Booking\BookingController;
use App\Http\Controllers\invoice\InvoiceController;
use App\Http\Controllers\payment\PaymentController;
use App\Http\Controllers\PrintReceipt\PrintReceiptController;
use App\Http\Controllers\Provider\SavedProviderController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'is_user'])->group(function () {
    Route::get('/payment/{id}', [PaymentController::class, 'edit'])->name('payment.edit');
    Route::post('/payment/{booking}/process', [PaymentController::class, 'process'])->name('payment.process');
    Route::get('/payment/{booking}/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/{booking}/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
    Route::get('/payment/{booking}/decline', [PaymentController::class, 'decline'])->name('payment-declined');
    // Billing
    Route::post('/billing-info', [PaymentController::class, 'storeBillingInfo'])->name('billing.info');

    //receipt
    Route::get('print-receipt', [PrintReceiptController::class, 'index'])->name('print-receipt');
    Route::get('print-receipt/{id}', [PrintReceiptController::class, 'show'])->name('receipt.show');

    //invoice
    Route::get('user-invoice', [InvoiceController::class, 'userInvoice'])->name('user-invoice');

    //booking reschedule
    Route::post('/bookings/{booking}/reschedule', [BookingController::class, 'reschedule'])
        ->name('bookings.reschedule');
    Route::get('/bookings/{booking}/reschedule', [BookingController::class, 'showRescheduleForm'])
        ->name('bookings.reschedule.form');


    //payment
    Route::get('/payment/{booking}', [PaymentController::class, 'show'])->name('payment.show');

    // Booking
    Route::post('booking', [BookingController::class, 'store'])->name('booking-store');
    Route::get('upcoming-bookings', [BookingController::class, 'UpcomingBookings'])->middleware('auth')->name('upcoming-bookings');

    //saved
    Route::post('/saved-providers', [SavedProviderController::class, 'toggle']);
    Route::get('/all-saved-providers', [SavedProviderController::class, 'index'])->name('all-saved-providers');
    Route::get('get-saved-providers', [SavedProviderController::class, 'getJson']);
});
