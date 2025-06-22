<section class="space-y-6" x-data="profileForm()">
    <!-- Hidden verification form -->
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <!-- Main Profile Form -->
    <form method="post" action="{{ route('profile.update') }}" class="space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Profile Photo Section with Enhanced Upload -->
        <div class="flex flex-col sm:flex-row sm:items-center gap-6 p-6 bg-gradient-to-r from-gray-50 to-gray-100 rounded-2xl border border-gray-200">
            <div class="flex-shrink-0">
                <div class="relative group">
                    <!-- Profile Photo Display -->
                    <div class="w-24 h-24 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg overflow-hidden">
                        @if ($user->profile_photo_url)
                            <img src="{{ $user->profile_photo_url }}" alt="{{ $user->first_name }}" class="w-full h-full object-cover" id="profile-preview">
                        @else
                            <span class="text-2xl font-bold text-white" id="profile-initials">
                                {{ strtoupper(substr($user->first_name ?? $user->name, 0, 1)) }}{{ strtoupper(substr($user->last_name ?? '', 0, 1)) }}
                            </span>
                        @endif
                    </div>
                    
                    <!-- Upload Overlay -->
                    <label for="profile_photo" class="absolute inset-0 bg-black bg-opacity-50 rounded-2xl flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200 cursor-pointer">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </label>

                    <!-- Upload Progress -->
                    <div x-show="uploading" class="absolute inset-0 bg-black bg-opacity-75 rounded-2xl flex items-center justify-center">
                        <div class="text-center text-white">
                            <svg class="animate-spin h-6 w-6 mx-auto mb-2" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="text-xs">Uploading...</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex-1">
                <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ __('Profile Photo') }}</h3>
                <p class="text-sm text-gray-600 mb-3">{{ __('Upload a professional photo to personalize your account') }}</p>

                <!-- Hidden File Input -->
                <input 
                    type="file" 
                    name="profile_photo" 
                    id="profile_photo" 
                    class="hidden" 
                    accept="image/jpeg,image/png,image/jpg,image/gif"
                    @change="handleFileUpload($event)"
                >

                <!-- Upload Actions -->
                <div class="flex flex-wrap gap-2">
                    <label for="profile_photo" class="cursor-pointer px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        {{ __('Upload Photo') }}
                    </label>

                    @if ($user->profile_photo_url)
                        <button type="button" @click="removePhoto()" class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            {{ __('Remove') }}
                        </button>
                    @endif
                </div>

                <!-- File Requirements -->
                <div class="mt-3 text-xs text-gray-500">
                    <p>{{ __('Supported formats: JPEG, PNG, GIF. Max size: 2MB.') }}</p>
                </div>

                <!-- Upload Error Display -->
                <div x-show="uploadError" x-text="uploadError" class="mt-2 text-sm text-red-600"></div>
            </div>
        </div>

        <!-- Personal Information Section -->
        <div class="bg-white rounded-2xl border border-gray-200 p-6">
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('Personal Information') }}</h3>
                    <p class="text-sm text-gray-600">{{ __('Update your personal details and contact information') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- First Name -->
                <div class="space-y-2">
                    <label for="first_name" class="block text-sm font-medium text-gray-700">
                        {{ __('First Name') }}
                        <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input 
                            id="first_name" 
                            name="first_name" 
                            type="text"
                            class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 @error('first_name') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                            value="{{ old('first_name', $user->first_name) }}" 
                            required 
                            autofocus 
                            autocomplete="given-name" 
                            placeholder="{{ __('Enter your first name') }}"
                            x-model="firstName"
                            @input="updateInitials()"
                        />
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    </div>
                    @error('first_name')
                        <p class="text-sm text-red-600 flex items-center mt-1">
                            <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Last Name -->
                <div class="space-y-2">
                    <label for="last_name" class="block text-sm font-medium text-gray-700">
                        {{ __('Last Name') }}
                        <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input 
                            id="last_name" 
                            name="last_name" 
                            type="text"
                            class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 @error('last_name') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                            value="{{ old('last_name', $user->last_name) }}" 
                            required 
                            autocomplete="family-name"
                            placeholder="{{ __('Enter your last name') }}"
                            x-model="lastName"
                            @input="updateInitials()"
                        />
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    </div>
                    @error('last_name')
                        <p class="text-sm text-red-600 flex items-center mt-1">
                            <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Contact Information Section -->
        <div class="bg-white rounded-2xl border border-gray-200 p-6">
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-green-600 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('Contact Information') }}</h3>
                    <p class="text-sm text-gray-600">{{ __('Manage your email and phone number') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Phone Number with Validation -->
                <div class="space-y-2">
                    <label for="phone" class="block text-sm font-medium text-gray-700">
                        {{ __('Phone Number') }}
                        <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input 
                            id="phone" 
                            name="phone" 
                            type="tel"
                            class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 @error('phone') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                            value="{{ old('phone', $user->phone) }}" 
                            required 
                            autocomplete="tel"
                            placeholder="{{ __('Enter your phone number') }}"
                            x-model="phone"
                            @input="validatePhone()"
                        />
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg x-show="phoneValid" class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <svg x-show="!phoneValid && phone.length > 0" class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            <svg x-show="phone.length === 0" class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                    </div>
                    <div x-show="!phoneValid && phone.length > 0" class="text-xs text-red-600">
                        {{ __('Please enter a valid phone number') }}
                    </div>
                    @error('phone')
                        <p class="text-sm text-red-600 flex items-center mt-1">
                            <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Email Address with Enhanced Validation -->
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        {{ __('Email Address') }}
                        <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input 
                            id="email" 
                            name="email" 
                            type="email"
                            class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 @error('email') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                            value="{{ old('email', $user->email) }}" 
                            required 
                            autocomplete="email"
                            placeholder="{{ __('Enter your email address') }}"
                            x-model="email"
                            @input="validateEmail()"
                        />
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && $user->hasVerifiedEmail())
                                <div class="flex items-center space-x-1">
                                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-xs text-emerald-600 font-medium">Verified</span>
                                </div>
                            @else
                                <svg x-show="emailValid" class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <svg x-show="!emailValid && email.length > 0" class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                <svg x-show="email.length === 0" class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            @endif
                        </div>
                    </div>
                    <div x-show="!emailValid && email.length > 0" class="text-xs text-red-600">
                        {{ __('Please enter a valid email address') }}
                    </div>
                    @error('email')
                        <p class="text-sm text-red-600 flex items-center mt-1">
                            <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror

                    <!-- Email Verification Notice -->
                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                        <div class="mt-3 p-4 bg-amber-50 border border-amber-200 rounded-xl">
                            <div class="flex items-start space-x-3">
                                <svg class="w-5 h-5 text-amber-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                </svg>
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-amber-800">{{ __('Email Verification Required') }}</h4>
                                    <p class="text-sm text-amber-700 mt-1">
                                        {{ __('Your email address is unverified. Please check your inbox for a verification link.') }}
                                    </p>
                                    <button 
                                        form="send-verification" 
                                        type="submit"
                                        class="mt-2 inline-flex items-center text-sm font-medium text-amber-800 hover:text-amber-900 underline focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 rounded"
                                        :disabled="sendingVerification"
                                        @click="sendingVerification = true"
                                    >
                                        <svg x-show="sendingVerification" class="animate-spin -ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        <span x-text="sendingVerification ? '{{ __('Sending...') }}' : '{{ __('Resend verification email') }}'"></span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        @if (session('status') === 'verification-link-sent')
                            <div class="mt-3 p-4 bg-emerald-50 border border-emerald-200 rounded-xl">
                                <div class="flex items-center space-x-3">
                                    <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-sm font-medium text-emerald-800">
                                        {{ __('A new verification link has been sent to your email address.') }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 p-6 bg-gray-50 rounded-2xl border border-gray-200">
            <div class="flex items-center space-x-4">
                <button 
                    type="submit"
                    class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-xl font-medium text-sm text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200 shadow-sm disabled:opacity-50 disabled:cursor-not-allowed"
                    :disabled="!formValid || uploading"
                >
                    <svg x-show="!uploading" class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <svg x-show="uploading" class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span x-text="uploading ? '{{ __('Saving...') }}' : '{{ __('Save Changes') }}'"></span>
                </button>

                <button 
                    type="button" 
                    @click="resetForm()"
                    class="inline-flex items-center px-6 py-3 bg-white border border-gray-300 rounded-xl font-medium text-sm text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200 shadow-sm"
                >
                    {{ __('Reset') }}
                </button>
            </div>

            <!-- Success Message -->
            @if (session('status') === 'profile-updated')
                <div 
                    x-data="{ show: true }" 
                    x-show="show" 
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform translate-x-4"
                    x-transition:enter-end="opacity-100 transform translate-x-0"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 transform translate-x-0"
                    x-transition:leave-end="opacity-0 transform translate-x-4" 
                    x-init="setTimeout(() => show = false, 4000)"
                    class="flex items-center space-x-2 px-4 py-2 bg-emerald-50 border border-emerald-200 rounded-xl"
                >
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-sm font-medium text-emerald-800">{{ __('Profile updated successfully!') }}</span>
                </div>
            @endif
        </div>
    </form>
</section>

<script>
function profileForm() {
    return {
        firstName: '{{ old('first_name', $user->first_name) }}',
        lastName: '{{ old('last_name', $user->last_name) }}',
        phone: '{{ old('phone', $user->phone) }}',
        email: '{{ old('email', $user->email) }}',
        uploading: false,
        uploadError: '',
        sendingVerification: false,
        phoneValid: true,
        emailValid: true,
        
        get formValid() {
            return this.firstName.length > 0 && 
                   this.lastName.length > 0 && 
                   this.phoneValid && 
                   this.emailValid &&
                   this.phone.length > 0 &&
                   this.email.length > 0;
        },
        
        validatePhone() {
            // Basic phone validation - adjust regex as needed
            const phoneRegex = /^[\+]?[1-9][\d]{0,15}$/;
            this.phoneValid = phoneRegex.test(this.phone.replace(/\s+/g, ''));
        },
        
        validateEmail() {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            this.emailValid = emailRegex.test(this.email);
        },
        
        updateInitials() {
            const initialsElement = document.getElementById('profile-initials');
            if (initialsElement) {
                const firstInitial = this.firstName.charAt(0).toUpperCase();
                const lastInitial = this.lastName.charAt(0).toUpperCase();
                initialsElement.textContent = firstInitial + lastInitial;
            }
        },
        
        handleFileUpload(event) {
            const file = event.target.files[0];
            if (!file) return;
            
            // Validate file type
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
            if (!allowedTypes.includes(file.type)) {
                this.uploadError = '{{ __('Please select a valid image file (JPEG, PNG, GIF)') }}';
                return;
            }
            
            // Validate file size (2MB)
            if (file.size > 2 * 1024 * 1024) {
                this.uploadError = '{{ __('File size must be less than 2MB') }}';
                return;
            }
            
            this.uploadError = '';
            
            // Preview the image
            const reader = new FileReader();
            reader.onload = (e) => {
                const preview = document.getElementById('profile-preview');
                const initials = document.getElementById('profile-initials');
                
                if (preview) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                } else {
                    // Create new img element if it doesn't exist
                    const container = initials.parentElement;
                    const img = document.createElement('img');
                    img.id = 'profile-preview';
                    img.src = e.target.result;
                    img.className = 'w-full h-full object-cover';
                    img.alt = 'Profile preview';
                    container.appendChild(img);
                }
                
                if (initials) {
                    initials.style.display = 'none';
                }
            };
            reader.readAsDataURL(file);
        },
        
        removePhoto() {
            // Add hidden input to indicate photo removal
            const form = document.querySelector('form[action*="profile.update"]');
            let removeInput = form.querySelector('input[name="remove_photo"]');
            
            if (!removeInput) {
                removeInput = document.createElement('input');
                removeInput.type = 'hidden';
                removeInput.name = 'remove_photo';
                form.appendChild(removeInput);
            }
            
            removeInput.value = '1';
            
            // Reset preview
            const preview = document.getElementById('profile-preview');
            const initials = document.getElementById('profile-initials');
            
            if (preview) {
                preview.style.display = 'none';
            }
            if (initials) {
                initials.style.display = 'block';
            }
            
            // Clear file input
            document.getElementById('profile_photo').value = '';
        },
        
        resetForm() {
            // Reset form values
            this.firstName = '{{ $user->first_name }}';
            this.lastName = '{{ $user->last_name }}';
            this.phone = '{{ $user->phone }}';
            this.email = '{{ $user->email }}';
            
            // Reset validation states
            this.phoneValid = true;
            this.emailValid = true;
            this.uploadError = '';
            
            // Reset file input
            document.getElementById('profile_photo').value = '';
            
            // Remove any remove_photo input
            const removeInput = document.querySelector('input[name="remove_photo"]');
            if (removeInput) {
                removeInput.remove();
            }
            
            // Reset preview
            const preview = document.getElementById('profile-preview');
            const initials = document.getElementById('profile-initials');
            
            @if($user->profile_photo_url)
                if (preview) {
                    preview.src = '{{ $user->profile_photo_url }}';
                    preview.style.display = 'block';
                }
                if (initials) {
                    initials.style.display = 'none';
                }
            @else
                if (preview) {
                    preview.style.display = 'none';
                }
                if (initials) {
                    initials.style.display = 'block';
                    this.updateInitials();
                }
            @endif
        }
    }
}
</script>
