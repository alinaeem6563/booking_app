 <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="#" class="flex-shrink-0 flex items-center">
                        <svg class="h-8 w-auto text-indigo-600" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span class="ml-2 text-xl font-bold">BookEase</span>
                    </a>
                </div>
                
                <!-- Desktop Navigation -->
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="/" class="text-gray-600 hover:text-indigo-600 px-3 py-2 text-sm font-medium">Home</a>
                    <a href="{{route('providers.index')}}" class="text-gray-600 hover:text-indigo-600 px-3 py-2 text-sm font-medium">Providers</a>
                    <a href="#" class="text-gray-600 hover:text-indigo-600 px-3 py-2 text-sm font-medium">Categories</a>
                    <a href="#" class="text-gray-600 hover:text-indigo-600 px-3 py-2 text-sm font-medium">How it Works</a>
                </nav>
                @guest
                <div class="hidden md:flex items-center">
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-indigo-600 px-3 py-2 text-sm font-medium">Login</a>
                    <a href="{{ route('register') }}" class="ml-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Sign Up</a>
                </div>
                @endguest
                @auth
                <div class="hidden md:flex items-center">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button href="" class="ml-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">LogOut</button>
                    </form>
                </div>
                @endauth
                
                <!-- Mobile menu button -->
                <div class="flex items-center md:hidden">
                    <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" aria-controls="mobile-menu" aria-expanded="false" x-data="{ open: false }" @click="open = !open">
                        <span class="sr-only">Open main menu</span>
                        <svg class="h-6 w-6" x-show="!open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg class="h-6 w-6" x-show="open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile menu, show/hide based on menu state -->
        <div class="md:hidden" id="mobile-menu" x-data="{ open: false }" x-show="open" style="display: none;">
            <div class="pt-2 pb-3 space-y-1">
                <a href="/" class="block px-3 py-2 text-base font-medium text-indigo-600 border-l-4 border-indigo-500 bg-indigo-50">Home</a>
                <a href="{{route('providers.index')}}" class="block px-3 py-2 text-base font-medium text-gray-600 hover:text-indigo-600 hover:bg-gray-50 hover:border-indigo-500 border-l-4 border-transparent">Providers</a>
                <a href="#" class="block px-3 py-2 text-base font-medium text-gray-600 hover:text-indigo-600 hover:bg-gray-50 hover:border-indigo-500 border-l-4 border-transparent">Categories</a>
                <a href="#" class="block px-3 py-2 text-base font-medium text-gray-600 hover:text-indigo-600 hover:bg-gray-50 hover:border-indigo-500 border-l-4 border-transparent">How it Works</a>
            </div>
            <div class="pt-4 pb-3 border-t border-gray-200">
                @guest
                <div class="flex items-center px-4">
                    <a href="{{ route('login') }}" class="block px-3 py-2 text-base font-medium text-gray-600 hover:text-indigo-600">Login</a>
                    <a href="{{ route('register') }}" class="block px-3 py-2 text-base font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">Sign Up</a>
                </div>
                @endguest
                @auth
                <div class="flex items-center px-4">
                     <form method="POST" action="{{ route('logout') }}">
        @csrf
                    <button href="{{ route('logout') }}"  class="block px-3 py-2 text-base font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">LogOut</button>
                     </form>
                </div>
                @endauth
            </div>
        </div>
    </header>