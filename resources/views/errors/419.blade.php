@extends('layouts.app')
<title>BookEase - Session Expired</title>

@section('content')
    <!-- Background with gradient -->
    <div class="min-h-screen bg-gradient-to-br from-red-50 via-white to-orange-50 flex items-center justify-center">
        <!-- Decorative elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-40 -right-32 w-80 h-80 rounded-full bg-gradient-to-br from-red-400/20 to-orange-600/20 blur-3xl"></div>
            <div class="absolute -bottom-40 -left-32 w-80 h-80 rounded-full bg-gradient-to-tr from-orange-400/20 to-red-600/20 blur-3xl"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 rounded-full bg-gradient-to-r from-red-300/10 to-orange-300/10 blur-3xl"></div>
        </div>

        <!-- Main Content -->
        <main class="relative container mx-auto px-4 sm:px-6 lg:px-8 py-12" x-data="error419()">
            <div class="max-w-2xl mx-auto text-center">
                <!-- Error Icon -->
                <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-r from-red-600 to-orange-600 rounded-3xl mb-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>

                <!-- Error Title -->
                <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-red-600 to-orange-600 bg-clip-text text-transparent mb-4">
                    Session Expired
                </h1>
                
                <!-- Error Code -->
                <div class="inline-block bg-red-100 text-red-800 px-4 py-2 rounded-full text-sm font-semibold mb-6">
                    Error 419 - CSRF Token Mismatch
                </div>

                <!-- Error Description -->
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-8 mb-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">What happened?</h2>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Your session has expired for security reasons. This usually happens when you've been inactive for too long or when there's a security token mismatch. Don't worry - this is a normal security measure to protect your account.
                    </p>

                    <!-- Steps to resolve -->
                    <div class="text-left">
                        <h3 class="font-semibold text-gray-900 mb-4 text-center">Here's how to fix it:</h3>
                        <div class="space-y-3">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-6 h-6 bg-indigo-100 rounded-full flex items-center justify-center mr-3 mt-0.5">
                                    <span class="text-indigo-600 text-sm font-semibold">1</span>
                                </div>
                                <p class="text-gray-600">Refresh this page or go back to the previous page</p>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-6 h-6 bg-indigo-100 rounded-full flex items-center justify-center mr-3 mt-0.5">
                                    <span class="text-indigo-600 text-sm font-semibold">2</span>
                                </div>
                                <p class="text-gray-600">If you were filling out a form, you may need to re-enter your information</p>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-6 h-6 bg-indigo-100 rounded-full flex items-center justify-center mr-3 mt-0.5">
                                    <span class="text-indigo-600 text-sm font-semibold">3</span>
                                </div>
                                <p class="text-gray-600">Make sure your browser allows cookies for this website</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center mb-8">
                    <button @click="refreshPage()" 
                            class="bg-indigo-600  hover:from-indigo-700 hover:to-purple-700 text-white font-semibold py-3 px-8 rounded-xl transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-lg">
                        <span class="flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Refresh Page
                        </span>
                    </button>
                    
                    <button @click="goHome()" 
                            class="bg-white hover:bg-gray-50 text-gray-700 font-semibold py-3 px-8 rounded-xl border border-gray-200 transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 shadow-lg">
                        <span class="flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            Go to Homepage
                        </span>
                    </button>
                </div>

                <!-- Additional Help -->
                <div class="bg-blue-50/80 backdrop-blur-sm rounded-2xl border border-blue-200/50 p-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4 text-left">
                            <h3 class="font-semibold text-blue-900 mb-1">Still having trouble?</h3>
                            <p class="text-blue-700 text-sm mb-3">
                                If this error keeps happening, it might be a browser or connectivity issue. Try clearing your browser cache or using a different browser.
                            </p>
                            <a href="{{ route('support') }}" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-500 transition-colors">
                                Contact Support
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Auto-refresh countdown -->
                <div x-show="countdown > 0" class="mt-6 text-sm text-gray-500">
                    <p>This page will automatically refresh in <span x-text="countdown" class="font-semibold text-indigo-600"></span> seconds</p>
                </div>
            </div>
        </main>
    </div>
@endsection

<script>
    function error419() {
    return {
        countdown: 30,

        init() {
            // Start countdown for auto-refresh
            this.startCountdown();
        },

        startCountdown() {
            const timer = setInterval(() => {
                this.countdown--;
                if (this.countdown <= 0) {
                    clearInterval(timer);
                    this.refreshPage();
                }
            }, 1000);
        },

        refreshPage() {
            window.location.reload();
        },

        goHome() {
            window.location.href = "/";
        },

        goBack() {
            if (window.history.length > 1) {
                window.history.back();
            } else {
                this.goHome();
            }
        },
    };
}

</script>