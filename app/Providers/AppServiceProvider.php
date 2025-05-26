<?php

namespace App\Providers;

use Illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
    public function boot()
    {
        config(['app.timezone' => 'Asia/Karachi']);
        date_default_timezone_set('Asia/Karachi');
        Carbon::setLocale('en');
    }

    /**
     * Bootstrap any application services.
     */
    
}
