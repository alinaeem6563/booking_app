<?php

use App\Http\Controllers\category\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Review\ReviewController;
use App\Models\Review;
use App\Models\Service;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home/Home');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/payment',function(){
    return view('payment.payment');
});
Route::get('/payment-declined',function(){
    return view('payment.payment-declined');
});
Route::get('/payment-success',function(){
    return view('payment.payment-success');
});
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
Route::get('/dashboard', function () {
    $role = Auth()->user()->account_type;

    // Get the services for the provider role
    $services = null;
    if ($role === 'provider') {
        $services = Service::with('provider')->get();  // Get all services for the provider
    }
    $reviews = null;
    if ($role === 'user') {
        $reviews = Review::with('user')->get();  
    }

    // Return the view with services for the provider role or empty if not a provider
    return match ($role) {
        'admin' => view('admin.admin-dashboard'),
        'provider' => view('provider.provider-dashboard', compact('services')), // Pass services data to the view
        'user' => view('customer.user-dashboard',compact('reviews')),
        default => abort(403),
    };
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('coupon-management',function(){
    return view('coupons.coupon-management');
});
Route::get('categories',function(){
    return view('category.user-category');
});
Route::get('admin-category',function(){
    return view('category.admin-category');
});
Route::resource('categories',CategoryController::class);
Route::resource('reviews',ReviewController::class);

require __DIR__.'/auth.php';
require __DIR__.'/provider.php';
