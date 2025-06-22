<!-- Mobile sidebar backdrop -->
<div x-show="sidebarOpen" @click="sidebarOpen = false"
    class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm transition-all duration-300 md:hidden"
    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
</div>

<!-- Compact Responsive Sidebar -->
<div class="fixed inset-y-0 left-0 z-50 transition-all duration-300 ease-in-out"
    :class="{
        'w-64': sidebarOpen || (!sidebarCollapsed && window.innerWidth >= 768),
        'w-16': sidebarCollapsed && window.innerWidth >= 768 && !sidebarOpen,
        '-translate-x-full': !sidebarOpen && window.innerWidth < 768,
        'translate-x-0': sidebarOpen || window.innerWidth >= 768
    }"
    x-show="sidebarOpen || window.innerWidth >= 768" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in duration-300" x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full">

    <div class="flex h-full flex-col bg-white shadow-xl border-r border-gray-200">
        <!-- Sidebar Header -->
        <div class="flex items-center justify-between p-4 border-b border-gray-200 bg-gradient-to-r from-indigo-50 to-purple-50"
            :class="sidebarCollapsed && window.innerWidth >= 768 ? 'px-2' : 'px-4'">
            <div class="flex items-center space-x-3"
                x-show="!sidebarCollapsed || sidebarOpen || window.innerWidth < 768">
                <div class="p-2 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg shadow-lg">
                    <svg class="h-6 w-6 text-white" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </div>
                <div>
                    <span
                        class="text-lg font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">BookEase</span>
                    <div class="text-xs text-gray-500 font-medium">{{ ucfirst(auth()->user()->account_type) }}</div>
                </div>
            </div>

            <!-- Collapsed state logo -->
            <div x-show="sidebarCollapsed && !sidebarOpen && window.innerWidth >= 768"
                class="flex justify-center w-full">
                <div class="p-2 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg shadow-lg">
                    <svg class="h-6 w-6 text-white" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </div>
            </div>

            <button @click="sidebarOpen = false"
                class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 overflow-y-auto p-2 space-y-1">
            <!-- Main Section -->
            <div class="mb-4">
                <div class="mb-2 px-2 text-xs font-bold text-gray-400 uppercase tracking-wider flex items-center"
                    x-show="!sidebarCollapsed || sidebarOpen || window.innerWidth < 768">
                    <svg class="w-3 h-3 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        </path>
                    </svg>
                    Main
                </div>

                <a href="{{ route('dashboard') }}"
                    class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg bg-gradient-to-r from-indigo-500 to-purple-600 text-white shadow-md transform transition-all duration-200 hover:scale-105"
                    :class="sidebarCollapsed && window.innerWidth >= 768 && !sidebarOpen ? 'justify-center' : ''">
                    <div class="p-1 bg-white/20 rounded-md group-hover:bg-white/30 transition-colors duration-200"
                        :class="sidebarCollapsed && window.innerWidth >= 768 && !sidebarOpen ? '' : 'mr-3'">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4">
                            <path fill-rule="evenodd"
                                d="M1.5 9.832v1.793c0 1.036.84 1.875 1.875 1.875h17.25c1.035 0 1.875-.84 1.875-1.875V9.832a3 3 0 0 0-.722-1.952l-3.285-3.832A3 3 0 0 0 16.215 3h-8.43a3 3 0 0 0-2.278 1.048L2.222 7.88A3 3 0 0 0 1.5 9.832ZM7.785 4.5a1.5 1.5 0 0 0-1.139.524L3.881 8.25h3.165a3 3 0 0 1 2.496 1.336l.164.246a1.5 1.5 0 0 0 1.248.668h2.092a1.5 1.5 0 0 0 1.248-.668l.164-.246a3 3 0 0 1 2.496-1.336h3.165l-2.765-3.226a1.5 1.5 0 0 0-1.139-.524h-8.43Z"
                                clip-rule="evenodd" />
                            <path
                                d="M2.813 15c-.725 0-1.313.588-1.313 1.313V18a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3v-1.688c0-.724-.588-1.312-1.313-1.312h-4.233a3 3 0 0 0-2.496 1.336l-.164.246a1.5 1.5 0 0 1-1.248.668h-2.092a1.5 1.5 0 0 1-1.248-.668l-.164-.246A3 3 0 0 0 7.046 15H2.812Z" />
                        </svg>
                    </div>
                    <span x-show="!sidebarCollapsed || sidebarOpen || window.innerWidth < 768">Dashboard</span>
                </a>

                <a href="/"
                    class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:bg-gradient-to-r hover:from-gray-50 hover:to-gray-100 transition-all duration-200 hover:shadow-sm"
                    :class="sidebarCollapsed && window.innerWidth >= 768 && !sidebarOpen ? 'justify-center' : ''">
                    <div class="p-1 bg-gray-100 rounded-md group-hover:bg-indigo-100 group-hover:text-indigo-600 transition-all duration-200"
                        :class="sidebarCollapsed && window.innerWidth >= 768 && !sidebarOpen ? '' : 'mr-3'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </div>
                    <span x-show="!sidebarCollapsed || sidebarOpen || window.innerWidth < 768">Home</span>
                </a>

                @if (auth()->user()->account_type === 'admin')
                    <a href="{{ route('calendar.index') }}"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:bg-gradient-to-r hover:from-gray-50 hover:to-gray-100 transition-all duration-200 hover:shadow-sm"
                        :class="sidebarCollapsed && window.innerWidth >= 768 && !sidebarOpen ? 'justify-center' : ''">
                        <div class="p-1 bg-gray-100 rounded-md group-hover:bg-indigo-100 group-hover:text-indigo-600 transition-all duration-200"
                            :class="sidebarCollapsed && window.innerWidth >= 768 && !sidebarOpen ? '' : 'mr-3'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <span x-show="!sidebarCollapsed || sidebarOpen || window.innerWidth < 768">Admin
                            Calendar</span>
                    </a>
                @endif

                @if (auth()->user()->account_type === 'provider')
                    <a href="{{ route('calendar.create') }}"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:bg-gradient-to-r hover:from-gray-50 hover:to-gray-100 transition-all duration-200 hover:shadow-sm"
                        :class="sidebarCollapsed && window.innerWidth >= 768 && !sidebarOpen ? 'justify-center' : ''">
                        <div class="p-1 bg-gray-100 rounded-md group-hover:bg-green-100 group-hover:text-green-600 transition-all duration-200"
                            :class="sidebarCollapsed && window.innerWidth >= 768 && !sidebarOpen ? '' : 'mr-3'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <span x-show="!sidebarCollapsed || sidebarOpen || window.innerWidth < 768">Provider
                            Calendar</span>
                    </a>
                @endif

                <a href="{{ route('profile.edit') }}"
                    class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:bg-gradient-to-r hover:from-gray-50 hover:to-gray-100 transition-all duration-200 hover:shadow-sm"
                    :class="sidebarCollapsed && window.innerWidth >= 768 && !sidebarOpen ? 'justify-center' : ''">
                    <div class="p-1 bg-gray-100 rounded-md group-hover:bg-purple-100 group-hover:text-purple-600 transition-all duration-200"
                        :class="sidebarCollapsed && window.innerWidth >= 768 && !sidebarOpen ? '' : 'mr-3'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <span x-show="!sidebarCollapsed || sidebarOpen || window.innerWidth < 768">Profile</span>
                </a>

                @if (auth()->user()->account_type === 'admin')
                    <a href="{{ route('admin.users.create') }}"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:bg-gradient-to-r hover:from-gray-50 hover:to-gray-100 transition-all duration-200 hover:shadow-sm"
                        :class="sidebarCollapsed && window.innerWidth >= 768 && !sidebarOpen ? 'justify-center' : ''">
                        <div class="p-1 bg-gray-100 rounded-md group-hover:bg-emerald-100 group-hover:text-emerald-600 transition-all duration-200"
                            :class="sidebarCollapsed && window.innerWidth >= 768 && !sidebarOpen ? '' : 'mr-3'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                            </svg>
                        </div>
                        <span x-show="!sidebarCollapsed || sidebarOpen || window.innerWidth < 768">Create User</span>
                    </a>
                @endif
            </div>

            <!-- Categories Section (Admin Only) -->
            @if (auth()->user()->account_type === 'admin')
                <div class="mb-4">
                    <div class="mb-2 px-2 text-xs font-bold text-gray-400 uppercase tracking-wider flex items-center"
                        x-show="!sidebarCollapsed || sidebarOpen || window.innerWidth < 768">
                        <svg class="w-3 h-3 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                        Categories
                    </div>

                    <a href="{{ route('categories.create') }}"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:bg-gradient-to-r hover:from-gray-50 hover:to-gray-100 transition-all duration-200 hover:shadow-sm"
                        :class="sidebarCollapsed && window.innerWidth >= 768 && !sidebarOpen ? 'justify-center' : ''">
                        <div class="p-1 bg-gray-100 rounded-md group-hover:bg-orange-100 group-hover:text-orange-600 transition-all duration-200"
                            :class="sidebarCollapsed && window.innerWidth >= 768 && !sidebarOpen ? '' : 'mr-3'">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <span x-show="!sidebarCollapsed || sidebarOpen || window.innerWidth < 768">Add
                            Categories</span>
                    </a>

                    <a href="{{ route('categories.index') }}"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:bg-gradient-to-r hover:from-gray-50 hover:to-gray-100 transition-all duration-200 hover:shadow-sm"
                        :class="sidebarCollapsed && window.innerWidth >= 768 && !sidebarOpen ? 'justify-center' : ''">
                        <div class="p-1 bg-gray-100 rounded-md group-hover:bg-cyan-100 group-hover:text-cyan-600 transition-all duration-200"
                            :class="sidebarCollapsed && window.innerWidth >= 768 && !sidebarOpen ? '' : 'mr-3'">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                            </svg>
                        </div>
                        <span x-show="!sidebarCollapsed || sidebarOpen || window.innerWidth < 768">All
                            Categories</span>
                    </a>
                </div>
            @endif

            <!-- Services Section -->
            @if (auth()->user()->account_type === 'provider')
                <div class="mb-4">
                    <div class="mb-2 px-2 text-xs font-bold text-gray-400 uppercase tracking-wider flex items-center"
                        x-show="!sidebarCollapsed || sidebarOpen || window.innerWidth < 768">
                        <svg class="w-3 h-3 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6">
                            </path>
                        </svg>
                        Services
                    </div>

                    <a href="{{ route('services.index') }}"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:bg-gradient-to-r hover:from-gray-50 hover:to-gray-100 transition-all duration-200 hover:shadow-sm"
                        :class="sidebarCollapsed && window.innerWidth >= 768 && !sidebarOpen ? 'justify-center' : ''">
                        <div class="p-1 bg-gray-100 rounded-md group-hover:bg-indigo-100 group-hover:text-indigo-600 transition-all duration-200"
                            :class="sidebarCollapsed && window.innerWidth >= 768 && !sidebarOpen ? '' : 'mr-3'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <span x-show="!sidebarCollapsed || sidebarOpen || window.innerWidth < 768">My Services</span>
                    </a>
                </div>
            @endif

            <!-- User Services Section -->
            @if (auth()->user()->account_type === 'user')
                <div class="mb-4">
                    <div class="mb-2 px-2 text-xs font-bold text-gray-400 uppercase tracking-wider flex items-center"
                        x-show="!sidebarCollapsed || sidebarOpen || window.innerWidth < 768">
                        <svg class="w-3 h-3 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Services
                    </div>

                    <a href="{{ route('providers.index') }}"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:bg-gradient-to-r hover:from-gray-50 hover:to-gray-100 transition-all duration-200 hover:shadow-sm"
                        :class="sidebarCollapsed && window.innerWidth >= 768 && !sidebarOpen ? 'justify-center' : ''">
                        <div class="p-1 bg-gray-100 rounded-md group-hover:bg-indigo-100 group-hover:text-indigo-600 transition-all duration-200"
                            :class="sidebarCollapsed && window.innerWidth >= 768 && !sidebarOpen ? '' : 'mr-3'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <span x-show="!sidebarCollapsed || sidebarOpen || window.innerWidth < 768">Find Services</span>
                    </a>

                    <a href="{{ route('all-saved-providers') }}"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:bg-gradient-to-r hover:from-gray-50 hover:to-gray-100 transition-all duration-200 hover:shadow-sm"
                        :class="sidebarCollapsed && window.innerWidth >= 768 && !sidebarOpen ? 'justify-center' : ''">
                        <div class="p-1 bg-gray-100 rounded-md group-hover:bg-red-100 group-hover:text-red-600 transition-all duration-200"
                            :class="sidebarCollapsed && window.innerWidth >= 768 && !sidebarOpen ? '' : 'mr-3'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </div>
                        <span x-show="!sidebarCollapsed || sidebarOpen || window.innerWidth < 768">Saved
                            Providers</span>
                    </a>
                </div>
            @endif

            <!-- Reviews Section (Provider Only) -->
            @if (auth()->user()->account_type === 'provider')
                <div class="mb-4">
                    <div class="mb-2 px-2 text-xs font-bold text-gray-400 uppercase tracking-wider flex items-center"
                        x-show="!sidebarCollapsed || sidebarOpen || window.innerWidth < 768">
                        <svg class="w-3 h-3 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                            </path>
                        </svg>
                        Reviews
                    </div>

                    <a href="{{ route('reviews.index') }}"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:bg-gradient-to-r hover:from-gray-50 hover:to-gray-100 transition-all duration-200 hover:shadow-sm"
                        :class="sidebarCollapsed && window.innerWidth >= 768 && !sidebarOpen ? 'justify-center' : ''">
                        <div class="p-1 bg-gray-100 rounded-md group-hover:bg-yellow-100 group-hover:text-yellow-600 transition-all duration-200"
                            :class="sidebarCollapsed && window.innerWidth >= 768 && !sidebarOpen ? '' : 'mr-3'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.068.157 2.148.279 3.238.364.466.037.893.281 1.153.671L12 21l2.652-3.978c.26-.39.687-.634 1.153-.67 1.09-.086 2.17-.208 3.238-.365 1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                            </svg>
                        </div>
                        <span x-show="!sidebarCollapsed || sidebarOpen || window.innerWidth < 768">All Reviews</span>
                    </a>
                </div>
            @endif

            <!-- Bookings Section -->
            <div class="mb-4">
                @if (auth()->user()->account_type === 'provider')
                    <div class="mb-2 px-2 text-xs font-bold text-gray-400 uppercase tracking-wider flex items-center"
                        x-show="!sidebarCollapsed || sidebarOpen || window.innerWidth < 768">
                        <svg class="w-3 h-3 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        Bookings
                    </div>


                    <a href="{{ route('all-booking-requests') }}"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:bg-gradient-to-r hover:from-gray-50 hover:to-gray-100 transition-all duration-200 hover:shadow-sm"
                        :class="sidebarCollapsed && window.innerWidth >= 768 && !sidebarOpen ? 'justify-center' : ''">
                        <div class="p-1 bg-gray-100 rounded-md group-hover:bg-orange-100 group-hover:text-orange-600 transition-all duration-200"
                            :class="sidebarCollapsed && window.innerWidth >= 768 && !sidebarOpen ? '' : 'mr-3'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </div>
                        <span x-show="!sidebarCollapsed || sidebarOpen || window.innerWidth < 768">Booking
                            Requests</span>
  
                    </a>
                @endif

                @if (auth()->user()->account_type === 'user')
                    <a href="{{ route('upcoming-bookings') }}"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:bg-gradient-to-r hover:from-gray-50 hover:to-gray-100 transition-all duration-200 hover:shadow-sm"
                        :class="sidebarCollapsed && window.innerWidth >= 768 && !sidebarOpen ? 'justify-center' : ''">
                        <div class="p-1 bg-gray-100 rounded-md group-hover:bg-green-100 group-hover:text-green-600 transition-all duration-200"
                            :class="sidebarCollapsed && window.innerWidth >= 768 && !sidebarOpen ? '' : 'mr-3'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <span x-show="!sidebarCollapsed || sidebarOpen || window.innerWidth < 768">Upcoming
                            Bookings</span>
                    </a>
                @endif
            </div>
            <!-- Payments Section -->
            <div class="mb-4">
                @if (auth()->user()->account_type === 'user' || auth()->user()->account_type === 'provider')
                    <div class="mb-2 px-2 text-xs font-bold text-gray-400 uppercase tracking-wider flex items-center"
                        x-show="!sidebarCollapsed || sidebarOpen || window.innerWidth < 768">
                        <svg class="w-3 h-3 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                            </path>
                        </svg>
                        Payments
                    </div>

                    <a href="{{ route('payment-methods') }}"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:bg-gradient-to-r hover:from-gray-50 hover:to-gray-100 transition-all duration-200 hover:shadow-sm"
                        :class="sidebarCollapsed && window.innerWidth >= 768 && !sidebarOpen ? 'justify-center' : ''">
                        <div class="p-1 bg-gray-100 rounded-md group-hover:bg-indigo-100 group-hover:text-indigo-600 transition-all duration-200"
                            :class="sidebarCollapsed && window.innerWidth >= 768 && !sidebarOpen ? '' : 'mr-3'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </div>
                        <span x-show="!sidebarCollapsed || sidebarOpen || window.innerWidth < 768">Payment
                            Methods</span>
                    </a>
                @endif
                @if (auth()->user()->account_type === 'user')
                    <a href="{{ route('user-invoice') }}"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:bg-gradient-to-r hover:from-gray-50 hover:to-gray-100 transition-all duration-200 hover:shadow-sm"
                        :class="sidebarCollapsed && window.innerWidth >= 768 && !sidebarOpen ? 'justify-center' : ''">
                        <div class="p-1 bg-gray-100 rounded-md group-hover:bg-purple-100 group-hover:text-purple-600 transition-all duration-200"
                            :class="sidebarCollapsed && window.innerWidth >= 768 && !sidebarOpen ? '' : 'mr-3'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z" />
                            </svg>
                        </div>
                        <span x-show="!sidebarCollapsed || sidebarOpen || window.innerWidth < 768">Invoices</span>
                    </a>
                @endif

                @if (auth()->user()->account_type === 'provider')
                    <a href="{{ route('invoices') }}"
                        class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:bg-gradient-to-r hover:from-gray-50 hover:to-gray-100 transition-all duration-200 hover:shadow-sm"
                        :class="sidebarCollapsed && window.innerWidth >= 768 && !sidebarOpen ? 'justify-center' : ''">
                        <div class="p-1 bg-gray-100 rounded-md group-hover:bg-emerald-100 group-hover:text-emerald-600 transition-all duration-200"
                            :class="sidebarCollapsed && window.innerWidth >= 768 && !sidebarOpen ? '' : 'mr-3'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z" />
                            </svg>
                        </div>
                        <span x-show="!sidebarCollapsed || sidebarOpen || window.innerWidth < 768">Invoices</span>
                    </a>
                @endif
            </div>
        </nav>

        <!-- Account Section (Bottom) -->
        <div class="p-2 border-t border-gray-200 bg-gradient-to-r from-gray-50 to-white">
            <div class="mb-2 px-2 text-xs font-bold text-gray-400 uppercase tracking-wider flex items-center"
                x-show="!sidebarCollapsed || sidebarOpen || window.innerWidth < 768">
                <svg class="w-3 h-3 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Account
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button
                    class="group w-full flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:bg-gradient-to-r hover:from-red-50 hover:to-purple-50 hover:text-red-600 transition-all duration-200 hover:shadow-sm"
                    :class="sidebarCollapsed && window.innerWidth >= 768 && !sidebarOpen ? 'justify-center' : ''">
                    <div class="p-1 bg-gray-100 rounded-md group-hover:bg-red-100 group-hover:text-red-600 transition-all duration-200"
                        :class="sidebarCollapsed && window.innerWidth >= 768 && !sidebarOpen ? '' : 'mr-3'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </div>
                    <span x-show="!sidebarCollapsed || sidebarOpen || window.innerWidth < 768">Logout</span>
                </button>
            </form>
        </div>
    </div>
</div>
