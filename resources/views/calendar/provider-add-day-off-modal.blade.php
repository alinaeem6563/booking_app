           <!-- Trigger button -->
           {{-- <button id="openAddDayOffModalBtn"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Add Day Off
                </button> --}}

           <!-- Modal Overlay -->
           <div id="addDayOffModalOverlay"
               class="fixed inset-0 bg-black bg-opacity-50 z-40 flex items-center justify-center opacity-0 invisible transition-all duration-300 ease-in-out">
               <!-- Modal Container -->
               <div id="addDayOffModalContainer"
                   class="bg-white rounded-lg shadow-xl w-full max-w-xl mx-4 transform scale-95 transition-all duration-300 ease-in-out">
                   <!-- Modal Header -->
                   <div class="flex items-center justify-between p-4 border-b border-gray-200">
                       <h3 class="text-lg font-semibold text-gray-900">Add Day Off For Service</h3>
                       <button id="closeAddDayOffModalBtn"
                           class="text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-full p-1">
                           <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                               stroke="currentColor">
                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                   d="M6 18L18 6M6 6l12 12" />
                           </svg>
                       </button>
                   </div>

                   <!-- Modal Body -->
                   <div class="p-6 max-h-[60vh] overflow-y-auto">

                       <!-- You can add your day off form here -->
                       <form action="{{route('days-off')}}" method="POST" id="daysOffForm">
                           @csrf
                           <div class="px-4 py-5 sm:p-6">
                               @if ($errors->any())
                                   <div class="rounded-md bg-red-50 p-4 mb-6">
                                       <div class="flex">
                                           <div class="flex-shrink-0">
                                               <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg"
                                                   viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
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

                               <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                   <!-- Provider Selection -->
                                   <div class="">
                                       <div class="mt-1">
                                           <input type="hidden" id="provider_id" name="provider_id" value="{{auth()->user()->id}}"/>
                                       </div>
                                       @error('provider_id')
                                           <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                       @enderror
                                   </div>

                                   <!-- Type of Day Off -->
                                   <div class="sm:col-span-12">
                                       <label class="block text-sm font-medium text-gray-700">
                                           Type of Day Off
                                       </label>
                                       <div class="mt-2 space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                                           <div class="flex items-center">
                                               <input id="type_weekly" name="type" type="radio" value="weekly"
                                                   {{ old('type') == 'weekly' ? 'checked' : '' }}
                                                   class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                               <label for="type_weekly"
                                                   class="ml-3 block text-sm font-medium text-gray-700">
                                                   Weekly Day Off
                                               </label>
                                           </div>
                                           <div class="flex items-center">
                                               <input id="type_date" name="type" type="radio" value="date"
                                                   {{ old('type') == 'date' ? 'checked' : '' }}
                                                   class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                               <label for="type_date"
                                                   class="ml-3 block text-sm font-medium text-gray-700">
                                                   Specific Date
                                               </label>
                                           </div>
                                       </div>
                                       @error('type')
                                           <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                       @enderror
                                   </div>

                                   <!-- Day Name (for weekly type) -->
                                   <div id="day_name_container"
                                       class="sm:col-span-3 {{ old('type') == 'weekly' ? '' : 'hidden' }}">
                                       <label for="day_name" class="block text-sm font-medium text-gray-700">
                                           Day of Week
                                       </label>
                                       <div class="mt-1">
                                           <select id="day_name" name="day_name"
                                               class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('day_name') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror">
                                               <option value="">Select Day</option>
                                               <option value="Monday"
                                                   {{ old('day_name') == 'Monday' ? 'selected' : '' }}>Monday</option>
                                               <option value="Tuesday"
                                                   {{ old('day_name') == 'Tuesday' ? 'selected' : '' }}>Tuesday
                                               </option>
                                               <option value="Wednesday"
                                                   {{ old('day_name') == 'Wednesday' ? 'selected' : '' }}>Wednesday
                                               </option>
                                               <option value="Thursday"
                                                   {{ old('day_name') == 'Thursday' ? 'selected' : '' }}>Thursday
                                               </option>
                                               <option value="Friday"
                                                   {{ old('day_name') == 'Friday' ? 'selected' : '' }}>Friday</option>
                                               <option value="Saturday"
                                                   {{ old('day_name') == 'Saturday' ? 'selected' : '' }}>Saturday
                                               </option>
                                               <option value="Sunday"
                                                   {{ old('day_name') == 'Sunday' ? 'selected' : '' }}>Sunday</option>
                                           </select>
                                       </div>
                                       @error('day_name')
                                           <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                       @enderror
                                       <p class="mt-2 text-sm text-gray-500">The provider will be marked as unavailable
                                           on this day every week.</p>
                                   </div>

                                   <!-- Off Date (for date type) -->
                                   <div id="off_date_container"
                                       class="sm:col-span-3 {{ old('type') == 'date' ? '' : 'hidden' }}">
                                       <label for="off_date" class="block text-sm font-medium text-gray-700">
                                           Specific Date
                                       </label>
                                       <div class="mt-1">
                                           <input type="date" name="off_date" id="off_date"
                                               value="{{ old('off_date') }}"
                                               class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('off_date') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror">
                                       </div>
                                       @error('off_date')
                                           <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                       @enderror
                                       <p class="mt-2 text-sm text-gray-500">The provider will be marked as unavailable
                                           on this specific date.</p>
                                   </div>
                               </div>
                           </div>

                   </div>

                   <!-- Modal Footer -->
                   <div class="flex justify-end gap-3 p-4 border-t border-gray-200 bg-gray-50 rounded-b-lg">
                       <button id="cancelAddDayOffBtn"
                           class="px-4 py-2 bg-white border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                           Cancel
                       </button>

                       <button id="confirmAddDayOffBtn"
                           class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                           Save Day Off
                       </button>

                       </form>
                   </div>
               </div>
           </div>
           <script>
               // Get DOM elements
               const openAddDayOffModalBtn = document.getElementById('openAddDayOffModalBtn');
               const addDayOffModalOverlay = document.getElementById('addDayOffModalOverlay');
               const addDayOffModalContainer = document.getElementById('addDayOffModalContainer');
               const closeAddDayOffModalBtn = document.getElementById('closeAddDayOffModalBtn');
               const cancelAddDayOffBtn = document.getElementById('cancelAddDayOffBtn');
               const confirmAddDayOffBtn = document.getElementById('confirmAddDayOffBtn');

               // Function to open the modal
               function openAddDayOffModal() {
                   // Make modal visible
                   addDayOffModalOverlay.classList.remove('invisible', 'opacity-0');
                   addDayOffModalOverlay.classList.add('opacity-100');

                   // Scale up the modal
                   addDayOffModalContainer.classList.remove('scale-95');
                   addDayOffModalContainer.classList.add('scale-100');

                   // Prevent scrolling on the body
                   document.body.classList.add('overflow-hidden');
               }

               // Function to close the modal
               function closeAddDayOffModal() {
                   // Fade out the modal
                   addDayOffModalOverlay.classList.remove('opacity-100');
                   addDayOffModalOverlay.classList.add('opacity-0');

                   // Scale down the modal
                   addDayOffModalContainer.classList.remove('scale-100');
                   addDayOffModalContainer.classList.add('scale-95');

                   // Hide the modal after animation completes
                   setTimeout(() => {
                       addDayOffModalOverlay.classList.add('invisible');
                       // Re-enable scrolling on the body
                       document.body.classList.remove('overflow-hidden');
                   }, 300);
               }

               // Event listeners
               openAddDayOffModalBtn.addEventListener('click', openAddDayOffModal);
               closeAddDayOffModalBtn.addEventListener('click', closeAddDayOffModal);
               cancelAddDayOffBtn.addEventListener('click', closeAddDayOffModal);

               // Example action for confirm button
               confirmAddDayOffBtn.addEventListener('click', () => {
                   const date = document.getElementById('dayOffDate').value;
                   const reason = document.getElementById('dayOffReason').value;

                   if (!date || !reason) {
                       alert('Please fill in all required fields');
                       return;
                   }

                   alert(`Day off request submitted for ${date}`);
                   closeAddDayOffModal();
               });

               // Close modal when clicking outside
               addDayOffModalOverlay.addEventListener('click', (e) => {
                   if (e.target === addDayOffModalOverlay) {
                       closeAddDayOffModal();
                   }
               });

               // Close modal with Escape key
               document.addEventListener('keydown', (e) => {
                   if (e.key === 'Escape' && !addDayOffModalOverlay.classList.contains('invisible')) {
                       closeAddDayOffModal();
                   }
               });
           </script>
           {{-- form script --}}
           <script>
               document.addEventListener('DOMContentLoaded', function() {
                   const typeWeekly = document.getElementById('type_weekly');
                   const typeDate = document.getElementById('type_date');
                   const dayNameContainer = document.getElementById('day_name_container');
                   const offDateContainer = document.getElementById('off_date_container');
                   const dayNameInput = document.getElementById('day_name');
                   const offDateInput = document.getElementById('off_date');

                   // Function to toggle visibility based on selected type
                   function toggleFields() {
                       if (typeWeekly.checked) {
                           dayNameContainer.classList.remove('hidden');
                           offDateContainer.classList.add('hidden');
                           offDateInput.value = ''; // Clear date value
                       } else if (typeDate.checked) {
                           dayNameContainer.classList.add('hidden');
                           offDateContainer.classList.remove('hidden');
                           dayNameInput.value = ''; // Clear day name value
                       }
                   }

                   // Add event listeners
                   typeWeekly.addEventListener('change', toggleFields);
                   typeDate.addEventListener('change', toggleFields);

                   // Initialize form state
                   toggleFields();

                   // Form validation before submit
                   document.getElementById('daysOffForm').addEventListener('submit', function(event) {
                       let isValid = true;

                       // Check if provider is selected
                    //    if (!document.getElementById('provider_id').value) {
                    //        isValid = false;
                    //        alert('Please select a provider');
                    //    }

                       // Check if type is selected
                       if (!typeWeekly.checked && !typeDate.checked) {
                           isValid = false;
                           alert('Please select a type of day off');
                       }

                       // Check if day name is selected for weekly type
                       if (typeWeekly.checked && !dayNameInput.value) {
                           isValid = false;
                           alert('Please select a day of the week');
                       }

                       // Check if date is selected for date type
                       if (typeDate.checked && !offDateInput.value) {
                           isValid = false;
                           alert('Please select a specific date');
                       }

                       if (!isValid) {
                           event.preventDefault();
                       }
                   });
               });
           </script>
