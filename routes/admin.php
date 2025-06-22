<?php

use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Calendar\CalendarController;
use Illuminate\Support\Facades\Route;;

Route::middleware(['auth', 'can:manage-users'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserManagementController::class, 'create'])->name('users.create');
    Route::post('/users', [UserManagementController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserManagementController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
});
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin/providers', [CalendarController::class, 'getAllProviders']);
});
