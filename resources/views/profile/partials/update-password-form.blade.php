<section class="space-y-6">
    <!-- Password Security Header -->
    <div class="p-6 bg-gradient-to-r from-indigo-50 to-indigo-50 rounded-2xl border border-indigo-200">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">{{ __('Password Security') }}</h3>
                <p class="text-sm text-gray-600">{{ __('Keep your account secure with a strong password') }}</p>
            </div>
        </div>
    </div>

    <!-- Password Requirements -->
    <div class="bg-white rounded-2xl border border-gray-200 p-6">
        <h4 class="text-sm font-medium text-gray-900 mb-3">{{ __('Password Requirements') }}</h4>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
            <div class="flex items-center space-x-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span class="text-gray-600">{{ __('At least 8 characters') }}</span>
            </div>
            <div class="flex items-center space-x-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span class="text-gray-600">{{ __('Include uppercase letters') }}</span>
            </div>
            <div class="flex items-center space-x-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span class="text-gray-600">{{ __('Include lowercase letters') }}</span>
            </div>
            <div class="flex items-center space-x-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span class="text-gray-600">{{ __('Include numbers') }}</span>
            </div>
            <div class="flex items-center space-x-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span class="text-gray-600">{{ __('Include special characters') }}</span>
            </div>
            <div class="flex items-center space-x-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span class="text-gray-600">{{ __('Avoid common passwords') }}</span>
            </div>
        </div>
    </div>

    <!-- Password Update Form -->
    <form method="post" action="{{ route('password.update') }}" class="space-y-6" x-data="passwordForm()">
        @csrf
        @method('put')

        <div class="bg-white rounded-2xl border border-gray-200 p-6 space-y-6">
            <!-- Current Password -->
            <div class="space-y-2">
                <label for="update_password_current_password" class="block text-sm font-medium text-gray-700">
                    {{ __('Current Password') }}
                    <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input 
                        id="update_password_current_password" 
                        name="current_password" 
                        :type="showCurrentPassword ? 'text' : 'password'"
                        class="block w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 @error('current_password', 'updatePassword') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror" 
                        autocomplete="current-password"
                        placeholder="{{ __('Enter your current password') }}"
                        required
                    />
                    <button 
                        type="button" 
                        @click="showCurrentPassword = !showCurrentPassword"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center focus:outline-none"
                    >
                        <svg x-show="!showCurrentPassword" class="w-5 h-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg x-show="showCurrentPassword" class="w-5 h-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                        </svg>
                    </button>
                </div>
                @error('current_password', 'updatePassword')
                    <p class="text-sm text-red-600 flex items-center mt-1">
                        <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- New Password -->
            <div class="space-y-2">
                <label for="update_password_password" class="block text-sm font-medium text-gray-700">
                    {{ __('New Password') }}
                    <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input 
                        id="update_password_password" 
                        name="password" 
                        :type="showNewPassword ? 'text' : 'password'"
                        class="block w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 @error('password', 'updatePassword') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror" 
                        autocomplete="new-password"
                        placeholder="{{ __('Enter your new password') }}"
                        x-model="newPassword"
                        @input="checkPasswordStrength"
                        required
                    />
                    <button 
                        type="button" 
                        @click="showNewPassword = !showNewPassword"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center focus:outline-none"
                    >
                        <svg x-show="!showNewPassword" class="w-5 h-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg x-show="showNewPassword" class="w-5 h-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                        </svg>
                    </button>
                </div>

                <!-- Password Strength Indicator -->
                <div x-show="newPassword.length > 0" class="mt-3">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700">{{ __('Password Strength') }}</span>
                        <span class="text-sm" :class="strengthColor" x-text="strengthText"></span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div 
                            class="h-2 rounded-full transition-all duration-300" 
                            :class="strengthBarColor"
                            :style="`width: ${strengthPercentage}%`"
                        ></div>
                    </div>
                </div>

                <!-- Password Requirements Checklist -->
                <div x-show="newPassword.length > 0" class="mt-3 space-y-2">
                    <div class="flex items-center space-x-2">
                        <svg :class="newPassword.length >= 8 ? 'text-emerald-500' : 'text-gray-300'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-xs" :class="newPassword.length >= 8 ? 'text-emerald-600' : 'text-gray-500'">{{ __('At least 8 characters') }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <svg :class="/[A-Z]/.test(newPassword) ? 'text-emerald-500' : 'text-gray-300'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-xs" :class="/[A-Z]/.test(newPassword) ? 'text-emerald-600' : 'text-gray-500'">{{ __('Uppercase letter') }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <svg :class="/[a-z]/.test(newPassword) ? 'text-emerald-500' : 'text-gray-300'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-xs" :class="/[a-z]/.test(newPassword) ? 'text-emerald-600' : 'text-gray-500'">{{ __('Lowercase letter') }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <svg :class="/[0-9]/.test(newPassword) ? 'text-emerald-500' : 'text-gray-300'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-xs" :class="/[0-9]/.test(newPassword) ? 'text-emerald-600' : 'text-gray-500'">{{ __('Number') }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <svg :class="/[^A-Za-z0-9]/.test(newPassword) ? 'text-emerald-500' : 'text-gray-300'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-xs" :class="/[^A-Za-z0-9]/.test(newPassword) ? 'text-emerald-600' : 'text-gray-500'">{{ __('Special character') }}</span>
                    </div>
                </div>

                @error('password', 'updatePassword')
                    <p class="text-sm text-red-600 flex items-center mt-1">
                        <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="space-y-2">
                <label for="update_password_password_confirmation" class="block text-sm font-medium text-gray-700">
                    {{ __('Confirm New Password') }}
                    <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input 
                        id="update_password_password_confirmation" 
                        name="password_confirmation" 
                        :type="showConfirmPassword ? 'text' : 'password'"
                        class="block w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 @error('password_confirmation', 'updatePassword') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror" 
                        autocomplete="new-password"
                        placeholder="{{ __('Confirm your new password') }}"
                        x-model="confirmPassword"
                        required
                    />
                    <button 
                        type="button" 
                        @click="showConfirmPassword = !showConfirmPassword"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center focus:outline-none"
                    >
                        <svg x-show="!showConfirmPassword" class="w-5 h-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg x-show="showConfirmPassword" class="w-5 h-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                        </svg>
                    </button>
                </div>

                <!-- Password Match Indicator -->
                <div x-show="confirmPassword.length > 0" class="mt-2">
                    <div x-show="newPassword === confirmPassword && confirmPassword.length > 0" class="flex items-center space-x-2 text-emerald-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-sm">{{ __('Passwords match') }}</span>
                    </div>
                    <div x-show="newPassword !== confirmPassword && confirmPassword.length > 0" class="flex items-center space-x-2 text-red-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <span class="text-sm">{{ __('Passwords do not match') }}</span>
                    </div>
                </div>

                @error('password_confirmation', 'updatePassword')
                    <p class="text-sm text-red-600 flex items-center mt-1">
                        <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 p-6 bg-gray-50 rounded-2xl border border-gray-200">
            <div class="flex items-center space-x-4">
                <button 
                    type="submit"
                    class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-xl font-medium text-sm text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200 shadow-sm disabled:opacity-50 disabled:cursor-not-allowed"
                    :disabled="!isFormValid"
                >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    {{ __('Update Password') }}
                </button>

                <button 
                    type="button"
                    onclick="document.querySelector('form').reset(); window.location.reload()"
                    class="inline-flex items-center px-6 py-3 bg-white border border-gray-300 rounded-xl font-medium text-sm text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200 shadow-sm"
                >
                    {{ __('Cancel') }}
                </button>
            </div>

            <!-- Success Message -->
            @if (session('status') === 'password-updated')
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
                    <span class="text-sm font-medium text-emerald-800">{{ __('Password updated successfully!') }}</span>
                </div>
            @endif
        </div>
    </form>

    <!-- Security Tips -->
    <div class="bg-gradient-to-r from-amber-50 to-yellow-50 rounded-2xl border border-amber-200 p-6">
        <div class="flex items-start space-x-3">
            <svg class="w-6 h-6 text-amber-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
            </svg>
            <div>
                <h4 class="font-medium text-amber-800 mb-2">{{ __('Security Tips') }}</h4>
                <ul class="text-sm text-amber-700 space-y-1">
                    <li>• {{ __('Use a unique password that you don\'t use anywhere else') }}</li>
                    <li>• {{ __('Consider using a password manager to generate and store strong passwords') }}</li>
                    <li>• {{ __('Change your password immediately if you suspect it has been compromised') }}</li>
                    <li>• {{ __('Never share your password with anyone') }}</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<script>
function passwordForm() {
    return {
        showCurrentPassword: false,
        showNewPassword: false,
        showConfirmPassword: false,
        newPassword: '',
        confirmPassword: '',
        strengthScore: 0,
        
        get strengthPercentage() {
            return (this.strengthScore / 5) * 100;
        },
        
        get strengthText() {
            const scores = [ 'Very Weak','Weak', 'Fair', 'Good', 'Strong','Very Strong'];
            return scores[this.strengthScore] || 'Very Weak';
        },
        
        get strengthColor() {
            const colors = ['text-red-600', 'text-red-500', 'text-yellow-500', 'text-indigo-500', 'text-emerald-500'];
            return colors[this.strengthScore] || 'text-red-600';
        },
        
        get strengthBarColor() {
            const colors = ['bg-red-500', 'bg-red-400', 'bg-yellow-400', 'bg-indigo-500', 'bg-emerald-500'];
            return colors[this.strengthScore] || 'bg-red-500';
        },
        
        get isFormValid() {
            return this.newPassword.length >= 8 && 
                   this.newPassword === this.confirmPassword &&
                   this.strengthScore >= 3;
        },
        
        checkPasswordStrength() {
            let score = 0;
            
            // Length check
            if (this.newPassword.length >= 8) score++;
            
            // Uppercase check
            if (/[A-Z]/.test(this.newPassword)) score++;
            
            // Lowercase check
            if (/[a-z]/.test(this.newPassword)) score++;
            
            // Number check
            if (/[0-9]/.test(this.newPassword)) score++;
            
            // Special character check
            if (/[^A-Za-z0-9]/.test(this.newPassword)) score++;
            
            this.strengthScore = score;
        }
    }
}
</script>
