<section class="space-y-6" x-data="deleteAccountForm()">
    <!-- Danger Zone Header -->
    <div class="p-6 bg-gradient-to-r from-red-50 to-rose-50 rounded-2xl border border-red-200">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-rose-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">{{ __('Danger Zone') }}</h3>
                <p class="text-sm text-gray-600">{{ __('Irreversible and destructive actions') }}</p>
            </div>
        </div>
    </div>

    <!-- Account Deletion Warning -->
    <div class="bg-white rounded-2xl border border-gray-200 p-6">
        <div class="flex items-start space-x-4 mb-6">
            <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </div>
            <div class="flex-1">
                <h4 class="text-lg font-semibold text-gray-900 mb-2">{{ __('Delete Account') }}</h4>
                <p class="text-gray-600 text-sm leading-relaxed mb-4">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
                </p>
            </div>
        </div>

        <!-- What will be deleted -->
        <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
            <h5 class="font-medium text-red-800 mb-3 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ __('The following data will be permanently deleted:') }}
            </h5>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm text-red-700">
                <div class="flex items-center space-x-2">
                    <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <circle cx="10" cy="10" r="2"/>
                    </svg>
                    <span>{{ __('Profile information') }}</span>
                </div>
                <div class="flex items-center space-x-2">
                    <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <circle cx="10" cy="10" r="2"/>
                    </svg>
                    <span>{{ __('Account settings') }}</span>
                </div>
                <div class="flex items-center space-x-2">
                    <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <circle cx="10" cy="10" r="2"/>
                    </svg>
                    <span>{{ __('Booking history') }}</span>
                </div>
                <div class="flex items-center space-x-2">
                    <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <circle cx="10" cy="10" r="2"/>
                    </svg>
                    <span>{{ __('Messages and communications') }}</span>
                </div>
                <div class="flex items-center space-x-2">
                    <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <circle cx="10" cy="10" r="2"/>
                    </svg>
                    <span>{{ __('Payment information') }}</span>
                </div>
                <div class="flex items-center space-x-2">
                    <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <circle cx="10" cy="10" r="2"/>
                    </svg>
                    <span>{{ __('All associated files') }}</span>
                </div>
            </div>
        </div>

        <!-- Data Export Option -->
        <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-4 mb-6">
            <div class="flex items-start space-x-3">
                <svg class="w-5 h-5 text-indigo-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <div class="flex-1">
                    <h5 class="font-medium text-indigo-800 mb-2">{{ __('Download Your Data') }}</h5>
                    <p class="text-sm text-indigo-700 mb-3">
                        {{ __('Before deleting your account, you can download a copy of your data for your records.') }}
                    </p>
                    <button 
                        type="button"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        {{ __('Download Data') }}
                    </button>
                </div>
            </div>
        </div>

        <!-- Delete Account Button -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex-1">
                <p class="text-sm text-gray-600">
                    {{ __('This action cannot be undone. Please be certain before proceeding.') }}
                </p>
            </div>
            <button
                @click="showDeleteModal = true"
                class="inline-flex items-center px-6 py-3 bg-red-600 border border-transparent rounded-xl font-medium text-sm text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200 shadow-sm"
            >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                {{ __('Delete Account') }}
            </button>
        </div>
    </div>

    <!-- Enhanced Delete Confirmation Modal -->
    <div 
        x-show="showDeleteModal" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 overflow-y-auto"
        style="display: none;"
    >
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div 
                class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                @click="showDeleteModal = false"
            ></div>

            <!-- Modal panel -->
            <div 
                x-show="showDeleteModal"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="inline-block align-bottom bg-white rounded-2xl px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6"
            >
                <form method="post" action="{{ route('profile.destroy') }}" @submit="handleSubmit">
                    @csrf
                    @method('delete')

                    <!-- Modal Header -->
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left flex-1">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                {{ __('Delete Account Confirmation') }}
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    {{ __('This action is permanent and cannot be undone. All your data will be permanently deleted from our servers.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Confirmation Steps -->
                    <div class="mt-6 space-y-4">
                        <!-- Step 1: Type DELETE -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">
                                {{ __('Type "DELETE" to confirm') }}
                                <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                x-model="confirmText"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500 text-sm"
                                placeholder="{{ __('Type DELETE here') }}"
                                required
                            />
                            <p class="text-xs text-gray-500">
                                {{ __('This helps prevent accidental deletions') }}
                            </p>
                        </div>

                        <!-- Step 2: Password Confirmation -->
                        <div class="space-y-2">
                            <label for="password" class="block text-sm font-medium text-gray-700">
                                {{ __('Enter your password to confirm') }}
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input 
                                    id="password"
                                    name="password"
                                    :type="showPassword ? 'text' : 'password'"
                                    x-model="password"
                                    class="block w-full px-3 py-2 pr-10 border border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500 text-sm @error('password', 'userDeletion') border-red-300 @enderror"
                                    placeholder="{{ __('Your current password') }}"
                                    required
                                />
                                <button 
                                    type="button" 
                                    @click="showPassword = !showPassword"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                >
                                    <svg x-show="!showPassword" class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg x-show="showPassword" class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                                    </svg>
                                </button>
                            </div>
                            @error('password', 'userDeletion')
                                <p class="text-sm text-red-600 flex items-center mt-1">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Final Warning -->
                        <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                            <div class="flex items-center">
                                <input 
                                    id="final-confirmation" 
                                    type="checkbox" 
                                    x-model="finalConfirmation"
                                    class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded"
                                />
                                <label for="final-confirmation" class="ml-2 block text-sm text-red-800">
                                    {{ __('I understand that this action is permanent and irreversible') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Actions -->
                    <div class="mt-6 flex flex-col-reverse sm:flex-row sm:justify-end gap-3">
                        <button 
                            type="button" 
                            @click="showDeleteModal = false"
                            class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200"
                        >
                            {{ __('Cancel') }}
                        </button>
                        <button 
                            type="submit"
                            :disabled="!canDelete"
                            :class="canDelete ? 'bg-red-600 hover:bg-red-700 focus:ring-red-500' : 'bg-gray-300 cursor-not-allowed'"
                            class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors duration-200 disabled:opacity-50"
                        >
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            {{ __('Delete Account Permanently') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
function deleteAccountForm() {
    return {
        showDeleteModal: @json($errors->userDeletion->isNotEmpty()),
        showPassword: false,
        confirmText: '',
        password: '',
        finalConfirmation: false,
        
        get canDelete() {
            return this.confirmText.toUpperCase() === 'DELETE' && 
                   this.password.length > 0 && 
                   this.finalConfirmation;
        },
        
        handleSubmit(event) {
            if (!this.canDelete) {
                event.preventDefault();
                return false;
            }
            
            // Additional confirmation
            if (!confirm('{{ __("Are you absolutely sure? This cannot be undone.") }}')) {
                event.preventDefault();
                return false;
            }
            
            return true;
        }
    }
}
</script>
