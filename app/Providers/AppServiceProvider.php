<?php

namespace App\Providers;

use App\Http\Controllers\dashboard\DashboardController;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
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
        Gate::define('manage-users', fn($user) => $user->account_type === 'admin');
        View::composer('navigation.UserHeader', function ($view) {
            $data = DashboardController::getHeaderNotifications();
            $view->with('notifications', $data['notifications'])
                ->with('unreadCount', $data['unreadCount']);
        });
    }

    /**
     * Bootstrap any application services.
     */
    
    
}
