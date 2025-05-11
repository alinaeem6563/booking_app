<!-- Edit Service Modal Structure -->
<div id="editServiceModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-5xl sm:w-full">
            <!-- Modal Header -->
            <div class="bg-gray-50 px-6 py-4 flex justify-between items-center border-b">
                <h3 class="text-lg font-medium text-gray-900">Edit Service</h3>
                <button id="closeEditServiceModal" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body - Form -->
            <div class="px-6 py-4 max-h-[80vh] overflow-y-auto">
                <form id="editServiceForm" action="{{ route('providers.update', ':id') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_service_id" name="service_id">
                    
                    <!-- Two Column Layout for Form -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <!-- Service Name -->
                            <div>
                                <label for="edit_service_name" class="text-left block text-sm font-medium text-gray-700">Service Name <span class="text-red-600">*</span></label>
                                <input type="text" name="service_name" id="edit_service_name" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                            
                            <!-- Service Description -->
                            <div>
                                <label for="edit_service_description" class="text-left block text-sm font-medium text-gray-700">Service Description <span class="text-red-600">*</span></label>
                                <textarea name="service_description" id="edit_service_description" rows="4" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                            </div>
                            
                            <!-- Qualifications & Certifications -->
                            <div>
                                <label for="edit_qualifications_certifications" class="text-left block text-sm font-medium text-gray-700">Qualifications & Certifications</label>
                                <p class="text-left text-gray-400 text-[12px]">Add comma "," for separation.</p>
                                <textarea name="qualifications_certifications" id="edit_qualifications_certifications" rows="3" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                            </div>
                            
                            <!-- Service Category -->
                            <div>
                                <label for="edit_service_category" class="text-left block text-sm font-medium text-gray-700">Service Category<span class="text-red-600">*</span></label>
                                <select name="service_category" id="edit_service_category" required class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">Select a category</option>
                                    <option value="Home Cleaning">Home Cleaning</option>
                                    <option value="Plumbing">Plumbing</option>
                                    <option value="Electrical">Electrical</option>
                                    <option value="Personal Training">Personal Training</option>
                                    <option value="Massage Therapy">Massage Therapy</option>
                                    <option value="Home Renovation">Home Renovation</option>
                                </select>
                            </div>
                            
                            <!-- Service Price -->
                            <div>
                                <label for="edit_service_price" class="text-left block text-sm font-medium text-gray-700">Service Price <span class="text-red-600">*</span></label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">$</span>
                                    </div>
                                    <input type="number" name="service_price" id="edit_service_price" min="0" step="0.01" required class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" placeholder="0.00">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">/hr</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Service Duration -->
                            <div>
                                <label for="edit_service_duration" class="text-left block text-sm font-medium text-gray-700">Service Duration</label>
                                <select name="service_duration" id="edit_service_duration" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="1 hour">1 hour</option>
                                    <option value="2 hours">2 hours</option>
                                    <option value="3 hours">3 hours</option>
                                    <option value="4 hours">4 hours</option>
                                    <option value="Half day">Half day</option>
                                    <option value="Full day">Full day</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Right Column -->
                        <div class="space-y-6">
                            <!-- Service Location -->
                            <div>
                                <label for="edit_service_location" class="text-left block text-sm font-medium text-gray-700">Service Location</label>
                                <input type="text" name="service_location" id="edit_service_location" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="eg:Santa Cruz, CA">
                            </div>
                            
                            <!-- Current Service Image -->
                            <div id="current-image-container">
                                <label class="text-left block text-sm font-medium text-gray-700">Current Service Image</label>
                                <div class="mt-1 relative bg-gray-50 rounded-md p-2 border border-gray-200">
                                    <img id="current_service_image" src="/placeholder.svg" alt="Current service image" class="h-32 w-auto mx-auto rounded-md object-cover">
                                    <input type="hidden" name="current_image" id="current_image_path">
                                </div>
                            </div>
                            
                            <!-- Service Image -->
                            <div>
                                <label for="edit_service_image" class="text-left block text-sm font-medium text-gray-700">Update Service Image</label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="edit_service_image" class="text-left relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                <span>Upload a new image</span>
                                                <input id="edit_service_image" name="service_image" type="file" class="sr-only" accept="image/*">
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                    </div>
                                </div>
                                <div id="edit-service-image-preview" class="mt-3 hidden"></div>
                            </div>
                            
                            <!-- Current Gallery Images -->
                            <div id="current-gallery-container">
                                <label class="text-left block text-sm font-medium text-gray-700">Current Gallery Images</label>
                                <div id="current_gallery_images" class="mt-1 grid grid-cols-3 gap-2">
                                    <!-- Gallery images will be populated here -->
                                </div>
                            </div>
                            
                            <!-- Work Gallery -->
                            <div>
                                <label for="edit_work_gallery" class="text-left block text-sm font-medium text-gray-700">Add Gallery Images</label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="edit_work_gallery" class="text-left relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                <span>Upload multiple files</span>
                                                <input id="edit_work_gallery" name="work_gallery[]" type="file" class="sr-only" multiple accept="image/*">
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB each</p>
                                    </div>
                                </div>
                                <div id="edit-gallery-preview" class="mt-3 hidden"></div>
                            </div>
                            
                            <!-- Service Active -->
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="edit_service_status" name="service_status" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="edit_service_status" class="text-left font-medium text-gray-700">Service Active</label>
                                    <p class="text-gray-500">Make this service visible to customers</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Service Offered Section -->
                    <div class="pt-4 border-t border-gray-200">
                        <h4 class="text-lg font-medium text-gray-900 mb-4">Other Service Offerings</h4>
                        
                        <div id="edit-offerings-container">
                            <div class="space-y-4">
                                <!-- Offerings will be populated here -->
                            </div>
                            
                            <div class="mt-4">
                                <button type="button" id="edit-add-offering-btn" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Add Another Offering
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Additional Services -->
                    <div>
                        <label for="edit_additional_services" class="text-left block text-sm font-medium text-gray-700">Additional Services</label>
                        <textarea name="Additional_Services" id="edit_additional_services" rows="3" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="List any additional services you offer..."></textarea>
                    </div>
                    
                    <!-- Form Actions -->
                    <div class="flex justify-between border-t border-gray-200 pt-6">
                        <!-- Delete Button -->
                        <button type="button" id="delete-service-btn" class="inline-flex items-center px-3 py-2 border border-red-300 shadow-sm text-sm leading-4 font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            Delete Service
                        </button>
                        
                        <div class="flex space-x-3">
                            <button type="button" id="cancel-edit-service-btn" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cancel
                            </button>
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Update Service
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteServiceModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-md sm:w-full">
            <div class="p-6">
                <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full mb-6">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                
                <h3 class="text-lg font-medium text-center text-gray-900 mb-2">Delete Service</h3>
                <p class="text-center text-gray-500 mb-6">Are you sure you want to delete this service? This action cannot be undone.</p>
                
                <div class="flex justify-center space-x-4">
                    <button type="button" id="cancel-delete-btn" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400">
                        Cancel
                    </button>
                    <form id="delete-service-form" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                            Yes, Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Enhanced Modal and Form Functionality -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Edit Service Modal Elements
    const editModal = document.getElementById('editServiceModal');
    const editButtons = document.querySelectorAll('.edit-service-btn');
    const closeEditModalBtn = document.getElementById('closeEditServiceModal');
    const cancelEditBtn = document.getElementById('cancel-edit-service-btn');
    const editForm = document.getElementById('editServiceForm');
    const deleteServiceBtn = document.getElementById('delete-service-btn');
    
    // Delete Confirmation Modal Elements
    const deleteModal = document.getElementById('deleteServiceModal');
    const cancelDeleteBtn = document.getElementById('cancel-delete-btn');
    const deleteForm = document.getElementById('delete-service-form');
    
    // Open edit modal with animation and load service data
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const serviceId = this.getAttribute('data-service-id');
            loadServiceData(serviceId);
            
            editModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent scrolling
        });
    });
    
    // Close edit modal with animation
    function closeEditModal() {
        editModal.classList.add('hidden');
        document.body.style.overflow = ''; // Re-enable scrolling
    }
    
    closeEditModalBtn.addEventListener('click', closeEditModal);
    cancelEditBtn.addEventListener('click', closeEditModal);
    
    // Close edit modal when clicking outside
    editModal.addEventListener('click', function(e) {
        if (e.target === editModal) {
            closeEditModal();
        }
    });
    
    // Open delete confirmation modal
    deleteServiceBtn.addEventListener('click', function() {
        const serviceId = document.getElementById('edit_service_id').value;
        deleteForm.action = `/providers/${serviceId}`;
        
        deleteModal.classList.remove('hidden');
    });
    
    // Close delete modal with animation
    function closeDeleteModal() {
        deleteModal.classList.add('hidden');
    }
    
    cancelDeleteBtn.addEventListener('click', closeDeleteModal);
    
    // Close delete modal when clicking outside
    deleteModal.addEventListener('click', function(e) {
        if (e.target === deleteModal) {
            closeDeleteModal();
        }
    });
    
    // Load service data from the controller
    function loadServiceData(serviceId) {
        // Set the form action and service ID
        const formAction = editForm.action.replace(':id', serviceId);
        editForm.action = formAction;
        document.getElementById('edit_service_id').value = serviceId;
        
        // Fetch service data from the controller
        fetch(`/providers/${serviceId}/edit`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Populate form fields with service data
                document.getElementById('edit_service_name').value = data.service_name || '';
                document.getElementById('edit_service_description').value = data.service_description || '';
                document.getElementById('edit_qualifications_certifications').value = data.qualifications_certifications || '';
                document.getElementById('edit_service_category').value = data.service_category || '';
                document.getElementById('edit_service_price').value = data.service_price || '';
                document.getElementById('edit_service_duration').value = data.service_duration || '1 hour';
                document.getElementById('edit_service_location').value = data.service_location || '';
                document.getElementById('edit_service_status').checked = data.service_status ? true : false;
                document.getElementById('edit_additional_services').value = data.additional_services || '';
                
                // Display current service image if it exists
                if (data.service_image) {
                    document.getElementById('current_service_image').src = data.service_image;
                    document.getElementById('current_image_path').value = data.service_image;
                    document.getElementById('current-image-container').classList.remove('hidden');
                } else {
                    document.getElementById('current-image-container').classList.add('hidden');
                }
                
                // Display current gallery images if they exist
                const galleryContainer = document.getElementById('current_gallery_images');
                galleryContainer.innerHTML = '';
                
                if (data.gallery_images && data.gallery_images.length > 0) {
                    data.gallery_images.forEach((image, index) => {
                        const imageDiv = document.createElement('div');
                        imageDiv.className = 'relative';
                        imageDiv.innerHTML = `
                            <img src="${image.url}" alt="Gallery image ${index + 1}" class="h-20 w-full rounded-md object-cover">
                            <input type="hidden" name="existing_gallery[]" value="${image.id}">
                            <button type="button" class="absolute top-0 right-0 bg-red-500 text-white rounded-full p-1 transform translate-x-1/2 -translate-y-1/2" data-gallery-id="${image.id}">
                                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        `;
                        galleryContainer.appendChild(imageDiv);
                    });
                    
                    document.getElementById('current-gallery-container').classList.remove('hidden');
                    
                    // Add event listeners to gallery delete buttons
                    galleryContainer.querySelectorAll('button').forEach(button => {
                        button.addEventListener('click', function() {
                            const imageId = this.getAttribute('data-gallery-id');
                            const imageDiv = this.closest('.relative');
                            
                            // Add a hidden input to track deleted images
                            const deletedInput = document.createElement('input');
                            deletedInput.type = 'hidden';
                            deletedInput.name = 'deleted_gallery[]';
                            deletedInput.value = imageId;
                            editForm.appendChild(deletedInput);
                            
                            // Remove the image
                            imageDiv.remove();
                            if (galleryContainer.children.length === 0) {
                                document.getElementById('current-gallery-container').classList.add('hidden');
                            }
                        });
                    });
                } else {
                    document.getElementById('current-gallery-container').classList.add('hidden');
                }
                
                // Populate service offerings
                const offeringsContainer = document.querySelector('#edit-offerings-container .space-y-4');
                offeringsContainer.innerHTML = '';
                
                if (data.offerings && data.offerings.length > 0) {
                    data.offerings.forEach((offering, index) => {
                        addOfferingWithData(offering, index);
                    });
                } else {
                    // Add a default empty offering if none exist
                    addNewOffering(0);
                }
            })
            .catch(error => {
                console.error('Error loading service data:', error);
                alert('Failed to load service data. Please try again.');
                closeEditModal();
            });
    }
    
    // Add offering with existing data
    function addOfferingWithData(offering, index) {
        const offeringsContainer = document.querySelector('#edit-offerings-container .space-y-4');
        
        const offeringDiv = document.createElement('div');
        offeringDiv.className = 'border border-gray-200 rounded-md p-4 offering-item';
        offeringDiv.innerHTML = `
            <div class="flex justify-between items-center mb-2">
                <h5 class="text-sm font-medium text-gray-700">Offering #${index + 1}</h5>
                <input type="hidden" name="offering_id[${index}]" value="${offering.id || ''}">
                <button type="button" class="text-red-500 hover:text-red-700 delete-offering ${offeringsContainer.children.length === 0 && index === 0 ? 'hidden' : ''}">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Offering Name -->
                <div>
                    <label for="Service_Offered_${index}" class="text-left block text-sm font-medium text-gray-700">Offering Name</label>
                    <input name="Service_Offered[${index}]" id="Service_Offered_${index}" type="text" value="${offering.name || ''}" 
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                
                <!-- Offering Description -->
                <div>
                    <label for="Service_Offered_description_${index}" class="text-left block text-sm font-medium text-gray-700">Description</label>
                    <input name="Service_Offered_description[${index}]" id="Service_Offered_description_${index}" type="text" value="${offering.description || ''}" 
                  type="text" value="${offering.description || ''}" 
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                
                <!-- Offering Price -->
                <div>
                    <label for="Service_Offered_price_${index}" class="text-left block text-sm font-medium text-gray-700">Price</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">$</span>
                        </div>
                        <input name="Service_Offered_price[${index}]" id="Service_Offered_price_${index}" type="number" min="0" step="0.01" value="${offering.price || ''}" 
                            class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 sm:text-sm border-gray-300 rounded-md" placeholder="0.00">
                    </div>
                </div>
            </div>
        `;
        
        offeringsContainer.appendChild(offeringDiv);
        
        // Setup delete button
        const deleteBtn = offeringDiv.querySelector('.delete-offering');
        deleteBtn.addEventListener('click', function() {
            const offeringItem = this.closest('.offering-item');
            offeringItem.remove();
            
            // Update offering numbers
            offeringsContainer.querySelectorAll('.offering-item').forEach((item, idx) => {
                item.querySelector('h5').textContent = `Offering #${idx + 1}`;
            });
            
            // Hide delete button on first offering if it's the only one
            if (offeringsContainer.children.length === 1) {
                offeringsContainer.querySelector('.delete-offering').classList.add('hidden');
            }
        });
    }
    
    // Add new offering functionality
    const addOfferingBtn = document.getElementById('edit-add-offering-btn');
    
    function addNewOffering(index) {
        const offeringsContainer = document.querySelector('#edit-offerings-container .space-y-4');
        
        // Create new offering element
        const newOffering = document.createElement('div');
        newOffering.className = 'border border-gray-200 rounded-md p-4 offering-item';
        newOffering.innerHTML = `
            <div class="flex justify-between items-center mb-2">
                <h5 class="text-sm font-medium text-gray-700">Offering #${index + 1}</h5>
                <input type="hidden" name="offering_id[${index}]" value="">
                <button type="button" class="text-red-500 hover:text-red-700 delete-offering ${offeringsContainer.children.length === 0 ? 'hidden' : ''}">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Offering Name -->
                <div>
                    <label for="Service_Offered_${index}" class="text-left block text-sm font-medium text-gray-700">Offering Name</label>
                    <input name="Service_Offered[${index}]" id="Service_Offered_${index}" type="text" 
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                
                <!-- Offering Description -->
                <div>
                    <label for="Service_Offered_description_${index}" class="text-left block text-sm font-medium text-gray-700">Description</label>
                    <input name="Service_Offered_description[${index}]" id="Service_Offered_description_${index}" type="text" 
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                
                <!-- Offering Price -->
                <div>
                    <label for="Service_Offered_price_${index}" class="text-left block text-sm font-medium text-gray-700">Price</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">$</span>
                        </div>
                        <input name="Service_Offered_price[${index}]" id="Service_Offered_price_${index}" type="number" min="0" step="0.01" 
                            class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 sm:text-sm border-gray-300 rounded-md" placeholder="0.00">
                    </div>
                </div>
            </div>
        `;
        
        offeringsContainer.appendChild(newOffering);
        
        // Setup delete button
        const deleteBtn = newOffering.querySelector('.delete-offering');
        deleteBtn.addEventListener('click', function() {
            const offeringItem = this.closest('.offering-item');
            offeringItem.remove();
            
            // Update offering numbers
            offeringsContainer.querySelectorAll('.offering-item').forEach((item, idx) => {
                item.querySelector('h5').textContent = `Offering #${idx + 1}`;
            });
            
            // Hide delete button on first offering if it's the only one
            if (offeringsContainer.children.length === 1) {
                offeringsContainer.querySelector('.delete-offering').classList.add('hidden');
            }
        });
        
        return newOffering;
    }
    
    addOfferingBtn.addEventListener('click', function() {
        const offeringsContainer = document.querySelector('#edit-offerings-container .space-y-4');
        const offeringCount = offeringsContainer.children.length;
        
        addNewOffering(offeringCount);
        
        // Show delete button on all offerings if there are multiple
        if (offeringsContainer.children.length > 1) {
            offeringsContainer.querySelectorAll('.delete-offering').forEach(btn => {
                btn.classList.remove('hidden');
            });
        }
    });
    
    // File upload preview for service image
    const serviceImageInput = document.getElementById('edit_service_image');
    const serviceImagePreview = document.getElementById('edit-service-image-preview');
    
    if (serviceImageInput) {
        serviceImageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    serviceImagePreview.classList.remove('hidden');
                    serviceImagePreview.innerHTML = `
                        <div class="relative">
                            <img src="${e.target.result}" class="h-32 w-auto mx-auto rounded-md object-cover" />
                            <button type="button" class="absolute top-0 right-0 bg-red-500 text-white rounded-full p-1 transform translate-x-1/2 -translate-y-1/2" onclick="this.closest('.relative').remove(); document.getElementById('edit_service_image').value = ''; document.getElementById('edit-service-image-preview').classList.add('hidden');">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    `;
                };
                reader.readAsDataURL(file);
            }
        });
    }
    
    // File upload preview for work gallery
    const workGalleryInput = document.getElementById('edit_work_gallery');
    const galleryPreview = document.getElementById('edit-gallery-preview');
    
    if (workGalleryInput) {
        workGalleryInput.addEventListener('change', function(e) {
            const files = e.target.files;
            if (files.length) {
                galleryPreview.classList.remove('hidden');
                galleryPreview.innerHTML = `<div class="grid grid-cols-2 sm:grid-cols-3 gap-2"></div>`;
                const previewGrid = galleryPreview.querySelector('.grid');
                
                Array.from(files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const previewItem = document.createElement('div');
                        previewItem.className = 'relative';
                        previewItem.innerHTML = `
                            <img src="${e.target.result}" class="h-20 w-full rounded-md object-cover" />
                            <button type="button" class="absolute top-0 right-0 bg-red-500 text-white rounded-full p-1 transform translate-x-1/2 -translate-y-1/2" onclick="this.closest('.relative').remove(); checkEditGalleryEmpty();">
                                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        `;
                        previewGrid.appendChild(previewItem);
                    };
                    reader.readAsDataURL(file);
                });
                
                // Function to check if gallery is empty
                window.checkEditGalleryEmpty = function() {
                    if (previewGrid.children.length === 0) {
                        galleryPreview.classList.add('hidden');
                    }
                };
            }
        });
    }
});
</script>
