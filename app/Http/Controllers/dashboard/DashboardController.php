<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Booking, Category, Review, SavedProvider, Service, User};
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->account_type;

        $categories = Category::all();
        $services = $role === 'provider' ? Service::with('provider')->get() : collect();
        $reviews  = $role === 'user' ? Review::with('user')->get() : collect();

        $bookings = Booking::with(['service', 'provider', 'timeSlot'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        $providerAllBookings = Booking::with(['user', 'service', 'provider', 'timeSlot'])
            ->where('provider_id', $user->id)
            ->latest()
            ->get();

        $upcomingBookings = Booking::with(['user', 'service', 'timeSlot'])
            ->where('provider_id', $user->id)
            ->where('status', '!=', 'completed')
            ->where('start_time', '>', now())
            ->get();

        $totalSpent = Booking::where('user_id', $user->id)->sum('total_amount');
        $totalEarning = Booking::where('provider_id', $user->id)->sum('total_amount');

        $completedBookings = Booking::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();

        $providerCompletedBookings = Booking::where('provider_id', $user->id)
            ->where('status', 'completed')
            ->count();

        $upComingBooking = Booking::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('payment_status', 'confirmed')
            ->count();

        $providerUpComingBooking = Booking::where('provider_id', $user->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('payment_status', 'confirmed')
            ->count();

        $recommendedServices = Service::with(['provider', 'reviews'])->inRandomOrder()->limit(3)->get();

        $totalClients = Booking::where('provider_id', $user->id)
            ->distinct('user_id')
            ->count('user_id');

        $savedProviders = SavedProvider::where('user_id', $user->id)->count();
        $allUsers = User::orderBy('created_at', 'desc')->take(5)->get();
        $allUserCount = User::all()->count();
        $allBookingCount = Booking::all()->count();
        $allProviderCount = User::where('account_type', 'provider')->count();
        $totalRevenue = Booking::sum('total_amount');


        // Current and last month ranges
        $startOfCurrentMonth = Carbon::now()->startOfMonth();
        $endOfCurrentMonth = Carbon::now()->endOfMonth();
        $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();

        // Users
        $currentUserCount = User::whereBetween('created_at', [$startOfCurrentMonth, $endOfCurrentMonth])->count();
        $lastUserCount = User::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();
        $userGrowth = $this->calculateGrowth($currentUserCount, $lastUserCount);

        // Bookings
        $currentBookingCount = Booking::whereBetween('created_at', [$startOfCurrentMonth, $endOfCurrentMonth])->count();
        $lastBookingCount = Booking::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();
        $bookingGrowth = $this->calculateGrowth($currentBookingCount, $lastBookingCount);

        // Providers
        $currentProviderCount = User::where('account_type', 'provider')
            ->whereBetween('created_at', [$startOfCurrentMonth, $endOfCurrentMonth])->count();
        $lastProviderCount = User::where('account_type', 'provider')
            ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();
        $providerGrowth = $this->calculateGrowth($currentProviderCount, $lastProviderCount);

        // Revenue
        $currentRevenue = Booking::whereBetween('created_at', [$startOfCurrentMonth, $endOfCurrentMonth])->sum('total_amount');
        $lastRevenue = Booking::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->sum('total_amount');
        $revenueGrowth = $this->calculateGrowth($currentRevenue, $lastRevenue);

        //Recent Activities
        $recentActivities = $this->getRecentActivities();

        $revenueChartData  = collect([]);
        $userActivityData = collect([]);

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i)->format('Y-m-d');

            $dailyRevenue = Booking::whereDate('created_at', $date)->sum('total_amount');
            $dailyUsers = User::whereDate('created_at', $date)->count();

            $revenueChartData->push([
                'date' => Carbon::parse($date)->format('d M'),
                'total' => $dailyRevenue,
            ]);

            $userActivityData->push([
                'date' => Carbon::parse($date)->format('d M'),
                'users' => $dailyUsers,
            ]);
        }

            $colors = ['blue', 'green', 'indigo', 'red', 'yellow', 'purple', 'pink'];
            $index = 0;

            $earningsByService = Service::where('provider_id', $user->id)
                ->withSum('bookings as total_earned', 'total_amount')
                ->get()
                ->map(function ($service) use (&$index, $colors) {
                    $color = $colors[$index % count($colors)];
                    $index++;

                    return [
                        'name' => $service->service_name,
                        'color' => $color,
                        'total' => $service->total_earned ?? 0,
                    ];
                });
            $revenueChartDataForProvider  = collect([]);

            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::today()->subDays($i)->format('Y-m-d');
                $revenue = Booking::where('provider_id', $user->id) // Filter by provider if needed
                    ->whereDate('created_at', $date)
                    ->sum('total_amount');

                $dailyRevenueProvider = Booking::whereDate('created_at', $date)->sum('total_amount');

                $revenueChartDataForProvider->push([
                    'date' => Carbon::parse($date)->format('d M'),
                    'total' => $dailyRevenueProvider,
                ]);
            }
        
        return match ($role) {
            'admin' => view('admin.admin-dashboard', compact(
                'categories',
                'services',
                'allUsers',
                'allUserCount',
                'allBookingCount',
                'allProviderCount',
                'totalRevenue',
                'userGrowth',
                'bookingGrowth',
                'providerGrowth',
                'revenueGrowth',
                'recentActivities',
                'userActivityData',
                'revenueChartData'
            )),
            'provider' => view('provider.provider-dashboard', compact(
                'services',
                'reviews',

                'upcomingBookings',
                'totalEarning',
                'providerCompletedBookings',
                'providerUpComingBooking',
                'totalClients',
                'categories',
                'providerAllBookings',
                'earningsByService',
                'revenueChartDataForProvider'
            )),
            'user' => view('customer.user-dashboard', compact(
                'upComingBooking',
                'completedBookings',
                'totalSpent',
                'reviews',
                'services',
                'bookings',
                'recommendedServices',
                'savedProviders'
            )),
            default => abort(403),
        };
    }
    function calculateGrowth($current, $previous)
    {
        if ($previous == 0) {
            return $current > 0 ? '+100%' : '0%';
        }
        $change = (($current - $previous) / $previous) * 100;
        return ($change >= 0 ? '+' : '') . number_format($change, 2) . '%';
    }
    private function getRecentActivities(): array
    {
        $activities = [];

        // 1. New provider registrations
        $newProviders = User::where('account_type', 'provider')
            ->latest()->take(3)->get();

        foreach ($newProviders as $provider) {
            $activities[] = [
                'type' => 'provider',
                'iconColor' => 'from-green-400 to-green-600',
                'icon' => 'plus',
                'message' => "New provider <span class='font-semibold text-indigo-600'>{$provider->first_name} {$provider->last_name}</span> registered",
                'time' => $provider->created_at->diffForHumans(),
            ];
        }

        // 2. Payments processed
        $recentBookings = Booking::where('payment_status', 'confirmed')
            ->latest()->take(3)->get();
        foreach ($recentBookings as $booking) {
            $formattedId = sprintf('#BE-%s-%05d', now()->year, $booking->id);

            $activities[] = [
                'type' => 'payment',
                'iconColor' => 'from-blue-400 to-blue-600',
                'icon' => 'credit-card',
                'message' => "Payment of <span class='font-semibold text-green-600'>\$" . number_format($booking->total_amount, 2) . "</span> processed for booking <span class='text-gray-700 font-semibold'>{$formattedId}</span>",
                'time' => $booking->updated_at->diffForHumans(),
            ];
        }

        // 3. Disputes (if your app has them — replace with any 'status = dispute' logic)
        $disputes = Booking::where('status', 'disputed')->latest()->take(3)->get();

        foreach ($disputes as $booking) {
            $customerName = optional($booking->user)->first_name . ' ' . optional($booking->user)->last_name;
            $activities[] = [
                'type' => 'dispute',
                'iconColor' => 'from-red-400 to-red-600',
                'icon' => 'shield-exclamation',
                'message' => "Dispute filed for booking <span class='font-semibold text-red-600'>#{$booking->id}</span> by customer {$customerName}",
                'time' => $booking->updated_at->diffForHumans(),
            ];
        }

        // 4. New customers
        $newCustomers = User::where('account_type', 'user')
            ->latest()->take(3)->get();

        foreach ($newCustomers as $customer) {
            $activities[] = [
                'type' => 'customer',
                'iconColor' => 'from-indigo-400 to-indigo-600',
                'icon' => 'user',
                'message' => "New customer <span class='font-semibold text-indigo-600'>{$customer->first_name} {$customer->last_name}</span> registered",
                'time' => $customer->created_at->diffForHumans(),
            ];
        }

        return collect($activities)->sortByDesc('time')->take(6)->toArray();
    }
    public static function getHeaderNotifications()
    {
        $user = Auth::user();
        $notifications = collect();

        if (!$user) {
            return ['notifications' => [], 'unreadCount' => 0];
        }

        // ✅ For PROVIDER
        if ($user->account_type === 'provider') {
            $recentBookings = Booking::where('provider_id', $user->id)
                ->where('payment_status', 'confirmed')
                ->latest()->take(5)->get();

            foreach ($recentBookings as $booking) {
                $notifications->push([
                    'title' => 'Payment received',
                    'message' => '$' . number_format($booking->total_amount, 2) . ' from ' . optional($booking->user)->first_name,
                    'time' => $booking->created_at->diffForHumans(),
                    'color' => 'green',
                ]);
            }
        }

        // ✅ For USER
        if ($user->account_type === 'user') {
            $userBookings = Booking::where('user_id', $user->id)
                ->latest()->take(5)->get();

            foreach ($userBookings as $booking) {
                $notifications->push([
                    'title' => 'Booking update',
                    'message' => 'Your booking for ' . optional($booking->service)->service_name . ' is ' . $booking->status,
                    'time' => $booking->updated_at->diffForHumans(),
                    'color' => 'blue',
                ]);
            }
        }

        // ✅ For ADMIN
        if ($user->account_type === 'admin') {
            $activities = (new static)->getRecentActivities(); // use the existing function
            foreach ($activities as $activity) {
                $notifications->push([
                    'title' => ucfirst($activity['type']) . ' activity',
                    'message' => strip_tags($activity['message']),
                    'time' => $activity['time'],
                    'color' => match ($activity['type']) {
                        'provider' => 'green',
                        'payment' => 'blue',
                        'dispute' => 'red',
                        'customer' => 'indigo',
                        default => 'gray'
                    },
                ]);
            }
        }

        // Store unread count in session
        session(['unread_notifications' => $notifications->count()]);

        return [
            'notifications' => $notifications,
            'unreadCount' => session('unread_notifications', 0),
        ];
    }
}
