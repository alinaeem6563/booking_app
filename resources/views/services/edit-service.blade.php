<!-- Complete Edit Service Modal with All Sections -->
<div id="editServiceModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div class="bg-white rounded-2xl overflow-hidden shadow-2xl transform transition-all sm:max-w-6xl sm:w-full">
            <!-- Modern Modal Header -->
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-8 py-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-2xl font-bold text-white flex items-center">
                             Edit Service
                        </h3>
                        <p class="text-indigo-100 mt-1">Update your service details and offerings</p>
                    </div>
                    <button id="closeEditServiceModal" 
                        class="text-white hover:text-indigo-200 transition-colors duration-200 p-2 rounded-lg hover:bg-white/10">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Modal Body - Form -->
            <div class="px-8 py-6 max-h-[80vh] overflow-y-auto">
                <form id="editServiceForm" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <!-- Basic Information Section -->
                    <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl p-6 border border-indigo-100">
                        <h4 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Basic Information ℹ
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Left Column -->
                            <div class="space-y-6">
                                <!-- Service Name -->
                                <div>
                                    <label for="edit_service_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Service Name <span class="text-red-600">*</span>
                                    </label>
                                    <input type="text" name="service_name" id="edit_service_name" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200"
                                        placeholder="Enter service name">
                                </div>

                                <!-- Service Description -->
                                <div>
                                    <label for="edit_service_description" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Service Description <span class="text-red-600">*</span>
                                    </label>
                                    <textarea name="service_description" id="edit_service_description" rows="4" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200"
                                        placeholder="Describe your service in detail..."></textarea>
                                </div>

                                <!-- Qualifications & Certifications -->
                                <div>
                                    <label for="edit_qualifications_certifications" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Qualifications & Certifications
                                    </label>
                                    <p class="text-left text-gray-500 text-xs mb-2">Add comma "," for separation.</p>
                                    <textarea name="qualifications_certifications" id="edit_qualifications_certifications" rows="3"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200"
                                        placeholder="List your qualifications and certifications..."></textarea>
                                </div>

                                <!-- Service Category -->
                                <div>
                                    <label for="edit_category_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Service Category <span class="text-red-600">*</span>
                                    </label>
                                    <select name="category_id" id="edit_category_id" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                                        <option value="">Select a category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-6">
                                <!-- Service Price -->
                                <div>
                                    <label for="edit_service_price" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Service Price <span class="text-red-600">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 text-sm">$</span>
                                        </div>
                                        <input type="number" name="service_price" id="edit_service_price" min="0" step="0.01" required
                                            class="w-full pl-8 pr-12 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200"
                                            placeholder="0.00">
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 text-sm">/hr</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Service Duration -->
                                <div>
                                    <label for="edit_service_duration" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Service Duration
                                    </label>
                                    <select name="service_duration" id="edit_service_duration"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                                        @for ($i = 1; $i <= 8; $i++)
                                            <option value="{{ $i }}">{{ $i }} hour{{ $i > 1 ? 's' : '' }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <!-- Service Location -->
                                <div>
                                    <label for="edit_service_location" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Service Location
                                    </label>
                                    <input type="text" name="service_location" id="edit_service_location"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200"
                                        placeholder="eg: Santa Cruz, CA">
                                </div>

                                <!-- Service Active -->
                                <div class="flex items-center justify-between p-4 bg-white rounded-lg border border-gray-200">
                                    <div>
                                        <h4 class="text-sm font-semibold text-gray-900">Service Status</h4>
                                        <p class="text-sm text-gray-600">Make this service visible to customers</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="hidden" name="service_status" value="0">
                                        <input value="1" id="edit_service_status" name="service_status" type="checkbox" class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Media Upload Section -->
                    <div class="bg-gradient-to-r from-emerald-50 to-teal-50 rounded-xl p-6 border border-emerald-100">
                        <h4 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Media & Gallery 
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Current Service Image -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Current Service Image</label>
                                <div id="current-service-image" class="mb-4">
                                    <!-- Current image will be populated here -->
                                </div>
                                
                                <label for="edit_service_image" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Update Service Image
                                </label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-indigo-400 transition-colors duration-200">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="edit_service_image" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                <span>Change image</span>
                                                <input id="edit_service_image" name="service_image" type="file" class="sr-only" accept="image/*">
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Current Work Gallery -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Current Work Gallery</label>
                                <div id="current-work-gallery" class="mb-4">
                                    <!-- Current gallery will be populated here -->
                                </div>
                                
                                <label for="edit_work_gallery" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Add More Gallery Images
                                </label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-indigo-400 transition-colors duration-200">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="edit_work_gallery" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                <span>Add more images</span>
                                                <input id="edit_work_gallery" name="work_gallery[]" type="file" class="sr-only" multiple accept="image/*">
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB each</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pricing Section -->
                    <div class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl p-6 border border-amber-100">
                        <h4 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                            Pricing Details 
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Service Fee -->
                            <div>
                                <label for="edit_service_fee" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Service Fee <span class="text-red-600">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 text-sm">$</span>
                                    </div>
                                    <input type="number" name="service_fee" id="edit_service_fee" min="0" step="0.01" required
                                        class="w-full pl-8 pr-16 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200"
                                        placeholder="0.00">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 text-sm">/service</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Tax -->
                            <div>
                                <label for="edit_tax" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Tax <span class="text-red-600">*</span>
                                </label>
                                <div class="relative">
                                    <input type="number" name="tax" id="edit_tax" min="0" step="0.01" required
                                        class="w-full pr-8 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200"
                                        placeholder="0.00">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 text-sm">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Service Offerings Section -->
                    <div class="bg-gradient-to-r from-violet-50 to-purple-50 rounded-xl p-6 border border-violet-100">
                        <div class="flex items-center justify-between mb-6">
                            <h4 class="text-lg font-semibold text-gray-900 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                Service Offerings 
                            </h4>
                            <button type="button" id="edit-add-offering-btn"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-violet-700 bg-violet-100 hover:bg-violet-200 focus:outline-none focus:ring-2 focus:ring-violet-500 transition-colors duration-200">
                                <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Add Another Offering
                            </button>
                        </div>

                        <div id="edit-offerings-container">
                            <!-- Existing offerings will be populated here -->
                        </div>
                    </div>

                    <!-- Additional Services Section -->
                    <div class="bg-gradient-to-r from-cyan-50 to-purple-50 rounded-xl p-6 border border-cyan-100">
                        <div class="flex items-center justify-between mb-6">
                            <h4 class="text-lg font-semibold text-gray-900 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Additional Services 
                            </h4>
                            <button type="button" id="edit-add-service-btn"
                                class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded-md bg-indigo-600   text-white  hover:bg-cyan-200 focus:outline-none focus:ring-2 focus:ring-cyan-500 transition-colors duration-200">
                                <svg class="-ml-0.5 mr-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Add Service
                            </button>
                        </div>

                        <div id="edit-additional-services-container">
                            <!-- Existing additional services will be populated here -->
                        </div>
                    </div>

                    <!-- FAQ Section -->
                    <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl p-6 border border-indigo-100">
                        <div class="flex items-center justify-between mb-6">
                            <h4 class="text-lg font-semibold text-gray-900 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Frequently Asked Questions 
                            </h4>
                            <button type="button" id="edit-add-faq-btn"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm bg-indigo-600   text-white  hover:from-indigo-600 hover:to-purple-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-200">
                                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Add Another Question
                            </button>
                        </div>

                        <div id="edit-faq-container">
                            <!-- Existing FAQs will be populated here -->
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-3 pt-6 border-t border-gray-200">
                        <button type="button" id="cancel-edit-service-btn"
                            class="w-full sm:w-auto px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors duration-200">
                            Cancel
                        </button>
                        <button type="submit"
                            class="w-full sm:w-auto px-6 py-3 bg-indigo-600   text-white  font-medium rounded-lg hover:from-indigo-600 hover:to-purple-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 shadow-lg transition-all duration-200">
                            Update Service
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@section('script')
    @vite(['resources/js/edit-service.js'])
@endsection