<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Review\ReviewController;
use App\Http\Controllers\category\CategoryController;
use App\Http\Controllers\Calendar\CalendarController;
use App\Http\Controllers\dashboard\DashboardController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\payment\PaymentController;

// Home & Static Pages
Route::get('/', [HomeController::class, 'index'])->name('/');
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Dashboard (based on role)
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['verified'])->name('dashboard');
    // Payments
    Route::get('payment-methods', [PaymentController::class, 'index'])->name('payment-methods');
    // View services of a specific provider
    Route::get('/providers/{provider}/services', [CalendarController::class, 'getProviderServices']);
    Route::delete('/dayoffs/{id}', [CalendarController::class, 'destroy'])->name('dayoffs.destroy');
    // ----------------------------
    // Categories & Reviews
    // ----------------------------
    Route::resource('categories', CategoryController::class);
    Route::resource('reviews', ReviewController::class);

    Route::get('/provider/services/{providerId}', [CalendarController::class, 'getProviderServices']);
    Route::get('/calendar/daysoff', [CalendarController::class, 'getDaysOff']);
    Route::get('/calendar/slots', [CalendarController::class, 'getAvailableSlots']);
});
// Provider calendar slots view
Route::get('/calendar/provider-slots', [CalendarController::class, 'getSlots'])->name('calendar.provider-slots');
// User calendar views
Route::get('/calendar/daysoff', [CalendarController::class, 'getDaysOff']);
Route::get('/calendar/slots', [CalendarController::class, 'getAvailableSlots']);
// Fallback 404
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
//categories
Route::get('all-categories', [CategoryController::class, 'UserCategory'])->name('all-categories');
//support
Route::get('support', function () {
    return view('support.help-support');
})->name('support');
//notification
Route::get('/notifications/reset', function () {
    session(['unread_notifications' => 0]);
    return response()->noContent();
})->name('notifications.reset')->middleware('auth');
// Auth & Provider Specific Routes
require __DIR__ . '/auth.php';
require __DIR__ . '/provider.php';
require __DIR__ . '/customer.php';
require __DIR__ . '/admin.php';
