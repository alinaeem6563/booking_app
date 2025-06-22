<header class="bg-white/95 backdrop-blur-sm shadow-sm border-b border-gray-200 sticky top-0 z-20">
    <div class="flex items-center justify-between h-14 md:h-16 px-4 md:px-6">
        <!-- Left Section -->
        <div class="flex items-center space-x-4">
            <!-- Mobile menu button -->
            <button @click="toggleSidebar()" 
                    class="p-2 rounded-lg text-gray-600 hover:bg-gray-100 transition-colors duration-200 md:hidden">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                </svg>
            </button>
            
            <!-- Desktop sidebar toggle -->
            <button @click="toggleSidebar()" 
                    class="hidden md:flex p-2 rounded-lg text-gray-600 hover:bg-gray-100 transition-colors duration-200">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            
            <!-- Page Title -->
            <div class="flex items-center space-x-3">
                <div class="hidden md:block">
                    <h1 class="text-lg lg:text-xl font-semibold text-gray-900">
                        {{ ucfirst(auth()->user()->account_type) }} Dashboard
                    </h1>
                    <p class="text-xs text-gray-500 hidden lg:block">
                        Welcome back, {{ auth()->user()->first_name }}
                    </p>
                </div>
                <div class="md:hidden">
                    <h1 class="text-lg font-semibold text-gray-900">Dashboard</h1>
                </div>
            </div>
        </div>

        <!-- Right Section -->
        <div class="flex items-center space-x-2 md:space-x-4">

            <!-- Notifications -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open; $store.notifications.resetUnreadCount()" 
                        class="relative p-2 rounded-lg text-gray-600 hover:bg-gray-100 transition-colors duration-200">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <!-- Notification Badge -->
                    <template x-if="$store.notifications && $store.notifications.unread > 0">
                    <span class="absolute -top-1 -right-1 h-4 w-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-medium">
                        {{ $unreadCount }}
                    </span>
                    </template>
                </button>

                <!-- Notifications Dropdown -->
                <div x-show="open" 
                     @click.away="open = false"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border border-gray-200 py-2 z-50"
                     style="display: none;">
                    
                     <div class="px-4 py-3 border-b border-gray-100">
                        <h3 class="text-sm font-semibold text-gray-900">Notifications</h3>
                        <p class="text-xs text-gray-500">
                            You have {{ $unreadCount }} unread notification{{ $unreadCount === 1 ? '' : 's' }}
                        </p>
                    </div>
                    
                    
                    <div class="max-h-64 overflow-y-auto">
                        @forelse($notifications as $notification)
                            <div class="px-4 py-3 hover:bg-gray-50 transition-colors duration-200">
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="h-8 w-8 bg-{{ $notification['color'] }}-100 rounded-full flex items-center justify-center">
                                            <svg class="h-4 w-4 text-{{ $notification['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M13 16h-1v-4h-1m1-4h.01M12 17h.01M4.293 6.707a1 1 0 011.414 0L12 13.586l6.293-6.879a1 1 0 011.414 1.414L12 16.414l-8.707-8.707a1 1 0 010-1.414z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900">{{ $notification['title'] }}</p>
                                        <p class="text-xs text-gray-500">{{ $notification['message'] }}</p>
                                        <p class="text-xs text-gray-400 mt-1">{{ $notification['time'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="px-4 py-3 text-sm text-gray-500">No notifications</div>
                        @endforelse
                    </div>
                    
                    
                    <div class="px-4 py-2 border-t border-gray-100">
                        <button class="text-xs text-indigo-600 hover:text-indigo-800 font-medium">
                            View all notifications
                        </button>
                    </div>
                </div>
            </div>



            <!-- User Profile Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" 
                        class="flex items-center space-x-2 p-1 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                    <!-- User Avatar -->
                    <div class="h-8 w-8 md:h-9 md:w-9 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-sm font-semibold shadow-sm">
                        {{ strtoupper(substr(auth()->user()->first_name, 0, 1) . substr(auth()->user()->last_name, 0, 1)) }}
                    </div>
                    
                    <!-- User Info (Desktop) -->
                    <div class="hidden md:block text-left">
                        <p class="text-sm font-medium text-gray-900 leading-tight">
                            {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
                        </p>
                        <p class="text-xs text-gray-500 leading-tight">
                            {{ ucfirst(auth()->user()->account_type) }}
                        </p>
                    </div>
                    
                    <!-- Dropdown Arrow -->
                    <svg class="h-4 w-4 text-gray-500 transition-transform duration-200" 
                         :class="open ? 'rotate-180' : ''"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <!-- Profile Dropdown -->
                <div x-show="open" 
                     @click.away="open = false"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-200 py-2 z-50"
                     style="display: none;">
                    
                    <!-- User Info Header -->
                    <div class="px-4 py-3 border-b border-gray-100">
                        <div class="flex items-center space-x-3">
                            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-semibold">
                                {{ strtoupper(substr(auth()->user()->first_name, 0, 1) . substr(auth()->user()->last_name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">
                                    {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
                                </p>
                                <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Menu Items -->
                    <div class="py-1">
                        <a href="{{ route('profile.edit') }}" 
                           class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                            <svg class="h-4 w-4 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Your Profile
                        </a>
                        
                        @if (auth()->user()->account_type === 'provider')
                        <a href="#" 
                           class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                            <svg class="h-4 w-4 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            Analytics
                        </a>
                        @endif
                        
                        <a href="{{route('support')}}" 
                           class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                            <svg class="h-4 w-4 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Help & Support
                        </a>
                    </div>
                    
                    <!-- Logout -->
                    <div class="border-t border-gray-100 pt-1">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200">
                                <svg class="h-4 w-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Sign out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('notifications', {
            unread: {{ $unreadCount }},
            resetUnreadCount() {
                fetch("{{ route('notifications.reset') }}")
                    .then(() => this.unread = 0);
            }
        });
    });
</script>