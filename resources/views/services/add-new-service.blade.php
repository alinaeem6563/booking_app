<!-- Add New Service Form -->
<!-- Modal Structure -->
<div id="serviceModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden overflow-y-auto">
    <!-- Form Errors -->
    @if ($errors->any())
        <div class="mx-6 mt-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">
                        There were {{ $errors->count() }} errors with your submission
                    </h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div class="bg-white rounded-2xl overflow-hidden shadow-2xl transform transition-all sm:max-w-6xl sm:w-full">
            <!-- Modern Modal Header -->
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-8 py-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-2xl font-bold text-white flex items-center">
                            Create New Service
                        </h3>
                        <p class="text-indigo-100 mt-1">Add a comprehensive service offering for your clients</p>
                    </div>
                    <button id="closeServiceModal"
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
                <form id="addServiceForm" action="{{ route('providers.store') }}" method="POST"
                    enctype="multipart/form-data" class="space-y-8">
                    @csrf

                    <!-- Basic Information Section -->
                    <div class="bg-gradient-to-r from-indigo-50 to-indigo-50 rounded-xl p-6 border border-indigo-100">
                        <h4 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                            <span class="ml-2">Basic Information</span>
                        </h4>

                        <!-- Two Column Layout for Form -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Left Column -->
                            <div class="space-y-6">
                                <!-- Service Name -->
                                <div>
                                    <label for="service_name"
                                        class="text-left block text-sm font-semibold text-gray-700 mb-2">Service Name
                                        <span class="text-red-600">*</span></label>
                                    <input type="text" name="service_name" id="service_name" required
                                        value="{{ old('service_name') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200"
                                        placeholder="Enter service name">
                                </div>

                                <!-- Service Description -->
                                <div>
                                    <label for="service_description"
                                        class="text-left block text-sm font-semibold text-gray-700 mb-2">Service
                                        Description <span class="text-red-600">*</span></label>
                                    <textarea name="service_description" id="service_description" rows="4" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200"
                                        placeholder="Describe your service in detail...">{{ old('service_description') }}</textarea>
                                </div>

                                <!-- Qualifications & Certifications -->
                                <div>
                                    <label for="qualifications_certifications"
                                        class="text-left block text-sm font-semibold text-gray-700 mb-2">Qualifications
                                        & Certifications</label>
                                    <p class="text-left text-gray-500 text-xs mb-2">Add comma "," for separation.</p>
                                    <textarea name="qualifications_certifications" id="qualifications_certifications" rows="3"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200"
                                        placeholder="List your qualifications and certifications...">{{ old('qualifications_certifications') }}</textarea>
                                </div>

                                <!-- Service Category -->
                                <div>
                                    <label for="category_id"
                                        class="text-left block text-sm font-semibold text-gray-700 mb-2">Service
                                        Category<span class="text-red-600">*</span></label>
                                    <select name="category_id" id="category_id" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                                        <option value="">Select a category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-6">
                                <!-- Service Price -->
                                <div>
                                    <label for="service_price"
                                        class="text-left block text-sm font-semibold text-gray-700 mb-2">Service Price
                                        <span class="text-red-600">*</span></label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 text-sm">$</span>
                                        </div>
                                        <input type="number" name="service_price" id="service_price" min="0"
                                            step="0.01" required
                                            class="w-full pl-8 pr-12 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200"
                                            placeholder="0.00" value="{{ old('service_price') }}">
                                        <div
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 text-sm">/hr</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Service Duration -->
                                <div>
                                    <label for="service_duration"
                                        class="text-left block text-sm font-semibold text-gray-700 mb-2">Service
                                        Duration</label>
                                    <select name="service_duration" id="service_duration"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                                        <option value="1" {{ old('duration') == 1 ? 'selected' : '' }}>1 hour
                                        </option>
                                        <option value="2" {{ old('duration') == 2 ? 'selected' : '' }}>2 hours
                                        </option>
                                        <option value="3" {{ old('duration') == 3 ? 'selected' : '' }}>3 hours
                                        </option>
                                        <option value="4" {{ old('duration') == 4 ? 'selected' : '' }}>4 hours
                                        </option>
                                        <option value="5" {{ old('duration') == 5 ? 'selected' : '' }}>5 hours
                                        </option>
                                        <option value="6" {{ old('duration') == 6 ? 'selected' : '' }}>6 hours
                                        </option>
                                        <option value="7" {{ old('duration') == 7 ? 'selected' : '' }}>7 hours
                                        </option>
                                        <option value="8" {{ old('duration') == 8 ? 'selected' : '' }}>8 hours
                                        </option>
                                    </select>
                                </div>

                                <!-- Service Location -->
                                <div>
                                    <label for="service_location"
                                        class="text-left block text-sm font-semibold text-gray-700 mb-2">Service
                                        Location</label>
                                    <input type="text" name="service_location" id="service_location"
                                        value="{{ old('service_location') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200"
                                        placeholder="eg: Santa Cruz, CA">
                                </div>

                                <!-- Service Active -->
                                <div
                                    class="flex items-center justify-between p-4 bg-white rounded-lg border border-gray-200">
                                    <div>
                                        <h4 class="text-sm font-semibold text-gray-900">Service Status</h4>
                                        <p class="text-sm text-gray-600">Make this service visible to customers</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input id="service_status" name="service_status" type="checkbox" checked
                                            class="sr-only peer">
                                        <div
                                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600">
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Media Upload Section -->
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-6 border border-green-100">
                        <h4 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                            <span class="ml-2">Media & Gallery</span>
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Service Image -->
                            <div>
                                <label for="service_image"
                                    class="text-left block text-sm font-semibold text-gray-700 mb-2">Service
                                    Image</label>
                                <div
                                    class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-indigo-400 transition-colors duration-200">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor"
                                            fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path
                                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="service_image"
                                                class="text-left relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                <span>Upload a file</span>
                                                <input id="service_image" name="service_image" type="file"
                                                    class="sr-only" accept="image/*">
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Work Gallery -->
                            <div>
                                <label for="work_gallery"
                                    class="text-left block text-sm font-semibold text-gray-700 mb-2">Work
                                    Gallery</label>
                                <div
                                    class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-indigo-400 transition-colors duration-200">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor"
                                            fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path
                                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="work_gallery"
                                                class="text-left relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                <span>Upload multiple files</span>
                                                <input id="work_gallery" name="work_gallery[]" type="file"
                                                    class="sr-only" multiple accept="image/*">
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
                    <div class="bg-gradient-to-r from-yellow-50 to-orange-50 rounded-xl p-6 border border-yellow-100">
                        <h4 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                            <span class="ml-2">Pricing Details</span>
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Service Fee -->
                            <div>
                                <label for="service_fee"
                                    class="text-left block text-sm font-semibold text-gray-700 mb-2">Service Fee
                                    <span class="text-red-600">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 text-sm">$</span>
                                    </div>
                                    <input type="number" name="service_fee" id="service_fee"
                                        value="{{ old('service_fee') }}" min="0" step="0.01" required
                                        class="w-full pl-8 pr-16 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200"
                                        placeholder="0.00">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 text-sm">/service</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Tax -->
                            <div>
                                <label for="tax"
                                    class="text-left block text-sm font-semibold text-gray-700 mb-2">Tax
                                    <span class="text-red-600">*</span></label>
                                <div class="relative">
                                    <input type="number" name="tax" id="tax" min="0"
                                        step="0.01" required value="{{ old('tax') }}"
                                        class="w-full pr-8 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200"
                                        placeholder="0.00">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 text-sm">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Service Offered Section -->
                    <div class="bg-gradient-to-r from-purple-50 to-indigo-50 rounded-xl p-6 border border-purple-100">
                        <div class="flex items-center justify-between mb-6">
                            <h4 class="text-lg font-semibold text-gray-900 flex items-center">
                                <span class="ml-2">Other Service Offerings</span>
                            </h4>
                            <button type="button" id="add-offering-btn"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg bg-indigo-600   text-white  hover:bg-purple-200 focus:outline-none focus:ring-2 focus:ring-purple-500 transition-colors duration-200">
                                <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Add Another Offering
                            </button>
                        </div>

                        <div id="offerings-container">
                            <div class="space-y-4">
                                <div class="bg-white border border-gray-200 rounded-lg p-4 offering-item">
                                    <div class="flex justify-between items-center mb-2">
                                        <h5 class="text-sm font-medium text-gray-700">Service #2</h5>
                                        <button type="button"
                                            class="text-red-500 hover:text-red-700 delete-offering hidden transition-colors duration-200">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <input type="hidden" name="service_id[]"
                                            value="{{ old('service_id[0]', $service->id ?? '') }}">

                                        <div>
                                            <label for="Service_Offered_0"
                                                class="text-left block text-sm font-medium text-gray-700 mb-1">Service
                                                Name</label>
                                            <input name="Service_Offered[0]" id="Service_Offered_0" type="text"
                                                value="{{ old('Service_Offered[0]', $service->service_name ?? '') }}"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                                        </div>

                                        <div>
                                            <label for="Service_Offered_description_0"
                                                class="text-left block text-sm font-medium text-gray-700 mb-1">Description</label>
                                            <input name="Service_Offered_description[0]"
                                                id="Service_Offered_description_0" type="text"
                                                value="{{ old('Service_Offered_description[0]', $service->description ?? '') }}"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                                        </div>

                                        <div>
                                            <label for="Service_Offered_price_0"
                                                class="text-left block text-sm font-medium text-gray-700 mb-1">Price</label>
                                            <div class="relative">
                                                <div
                                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <span class="text-gray-500 text-sm">$</span>
                                                </div>
                                                <input name="Service_Offered_price[0]" id="Service_Offered_price_0"
                                                    type="number" min="0" step="0.01"
                                                    value="{{ old('Service_Offered_price[0]', $service->price ?? '') }}"
                                                    class="w-full pl-8 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200"
                                                    placeholder="0.00">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Services -->
                    <div class="bg-gradient-to-r from-cyan-50 to-indigo-50 rounded-xl p-6 border border-cyan-100">
                        <div class="flex items-center justify-between mb-6">
                            <h4 class="text-lg font-semibold text-gray-900 flex items-center">
                                <span class="ml-2">Additional Services</span>
                            </h4>
                            <button type="button" id="add-service-btn"
                                class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded-md text-white bg-indigo-600  hover:bg-cyan-200 focus:outline-none focus:ring-2 focus:ring-cyan-500 transition-colors duration-200">
                                <svg class="-ml-0.5 mr-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Add Service
                            </button>
                        </div>

                        <div id="additional-services-container">
                            <div class="additional-service-item bg-white p-4 rounded-lg border border-gray-200 mb-3">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                    <div class="md:col-span-2">
                                        <label for="service_name_0"
                                            class="block text-xs font-medium text-gray-500 mb-1">Service
                                            Description</label>
                                        <input type="text" name="additional_services[0][name]" id="service_name_0"
                                            value="{{ old('additional_services.0.name') }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200"
                                            placeholder="e.g., Express Delivery">
                                    </div>
                                    <div>
                                        <label for="service_price_0"
                                            class="block text-xs font-medium text-gray-500 mb-1">Price</label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 text-sm">$</span>
                                            </div>
                                            <input type="text" name="additional_services[0][price]"
                                                id="service_price_0" value="{{ old('additional_services.0.price') }}"
                                                class="w-full pl-7 pr-12 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200"
                                                placeholder="0.00" aria-describedby="price-currency">
                                            <div
                                                class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 text-sm" id="price-currency">USD</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <p class="text-xs text-gray-500 italic mt-2">Add any additional services you offer with their
                            respective prices.</p>
                    </div>

                    <!-- FAQ Section -->
                    <div class="bg-gradient-to-r from-purple-50 to-indigo-50 rounded-xl p-6 border border-purple-100">
                        <div class="flex items-center justify-between mb-6">
                            <h4 class="text-lg font-semibold text-gray-900 flex items-center">
                                <span class="ml-2">Frequently Asked Questions</span>
                            </h4>
                            <button type="button" id="add-faq-btn"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:from-indigo-600 hover:to-purple-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-200">
                                <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Add Another Question
                            </button>
                        </div>

                        <div id="faq-container">
                            <div
                                class="faq-item mb-6 p-5 bg-white border border-gray-200 rounded-lg transition-all duration-200 hover:shadow-md">
                                <div class="flex flex-col md:flex-row md:items-center justify-between mb-4">
                                    <h3 class="text-lg font-medium text-gray-700 mb-2 md:mb-0">Question #1</h3>
                                    <button type="button"
                                        class="remove-faq text-sm text-red-500 hover:text-red-700 hidden transition-colors duration-200">
                                        Remove
                                    </button>
                                </div>

                                <div class="space-y-4">
                                    <div>
                                        <label for="questions[0]"
                                            class="text-left block text-sm font-medium text-gray-700 mb-1">Question</label>
                                        <input type="text" name="questions[]" id="questions[0]"
                                            value="{{ old('questions.0') }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200"
                                            placeholder="Enter your question here" required>
                                    </div>

                                    <div>
                                        <label for="answers[0]"
                                            class="text-left block text-sm font-medium text-gray-700 mb-1">Answer</label>
                                        <textarea name="answers[]" id="answers[0]" rows="3"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200"
                                            placeholder="Enter your answer here" required>{{ old('answers.0') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div
                        class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-3 pt-6 border-t border-gray-200">
                        <button type="button" id="cancel-service-btn"
                            class="w-full sm:w-auto px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors duration-200">
                            Cancel
                        </button>
                        <button type="submit"
                            class="w-full sm:w-auto px-6 py-3 bg-indigo-600   text-white font-medium rounded-lg hover:from-indigo-600 hover:to-purple-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 shadow-lg transition-all duration-200">
                            Save Service
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@vite(['resources/js/add-new-service.js'])
