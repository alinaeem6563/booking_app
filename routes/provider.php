<?php

use App\Http\Controllers\Calendar\CalendarController;
use App\Http\Controllers\Provider\ProviderAppointmentController;
use Illuminate\Support\Facades\Route;

Route::resource('providers', ProviderAppointmentController::class);
Route::resource('calendar', CalendarController::class);

