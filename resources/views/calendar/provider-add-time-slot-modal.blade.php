                <!-- Trigger button -->

                {{-- <button id="openModalBtn"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Add Time Slots
                </button> --}}

                <!-- Modal Overlay -->
                <div id="modalOverlay"
                    class="fixed inset-0 bg-black bg-opacity-50 z-40 flex items-center justify-center opacity-0 invisible transition-all duration-300 ease-in-out">
                    <!-- Modal Container -->
                    <div id="modalContainer"
                        class="bg-white rounded-lg shadow-xl w-full max-w-2xl mx-4 transform scale-95 transition-all duration-300 ease-in-out">
                        <!-- Modal Header -->
                        <div class="flex items-center justify-between p-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Add Time Slot</h3>
                            <button id="closeModalBtn"
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
                            <form action="{{ route('time-slot') }}" method="POST" id="timeSlotForm">
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
                                                <input type="hidden" id="provider_id" name="provider_id"
                                                    value="{{ auth()->user()->id }}" />
                                            </div>
                                            @error('provider_id')
                                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Service Selection -->
                                        <div class="sm:col-span-6">
                                            <label for="service_id" class="block text-sm font-medium text-gray-700">
                                                Service
                                            </label>
                                            <div class="mt-1">
                                                <select id="service_id" name="service_id"
                                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('service_id') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror">
                                                    <option value="">Select Service</option>
                                                    @foreach ($providerServices as $providerService)
                                                        <option value="{{ $providerService->id }}"
                                                            data-duration="{{ $providerService->service_duration }}"
                                                            {{ old('service_id') == $providerService->id ? 'selected' : '' }}>
                                                            {{ $providerService->service_name }}
                                                            ({{ $providerService->service_duration }} hours)
                                                        </option>
                                                    @endforeach

                                                </select>
                                            </div>
                                            @error('service_id')
                                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Date -->
                                        <div class="sm:col-span-2">
                                            <label for="date" class="block text-sm font-medium text-gray-700">
                                                Date
                                            </label>
                                            <div class="mt-1">
                                                <input type="date" name="date" id="date"
                                                    value="{{ old('date') }}"
                                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('date') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror">
                                            </div>
                                            @error('date')
                                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Start Time -->
                                        <div class="sm:col-span-2">
                                            <label for="start_time" class="block text-sm font-medium text-gray-700">
                                                Start Time
                                            </label>
                                            <div class="mt-1">
                                                <input type="time" name="start_time" id="start_time"
                                                    value="{{ old('start_time') }}"
                                                    class="shadow-sm focus:ring-indigo-500  block w-full sm:text-sm border-gray-300 rounded-md 
                                                    @error('start_time') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror">
                                            </div>
                                            @error('start_time')
                                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Duration -->
                                        <div class="sm:col-span-2">
                                            <label for="duration" class="block text-sm font-medium text-gray-700">
                                                Duration (hours)
                                            </label>
                                            <div class="mt-1">
                                                <input type="number" name="duration" id="duration"
                                                    value="{{ old('duration', 2) }}" min="1" max="8"
                                                    step="0.5"
                                                    class="shadow-sm  focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md 
                                                    @error('duration') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror">
                                            </div>
                                            @error('duration')
                                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- End Time (calculated) -->
                                        <div class="sm:col-span-2">
                                            <label for="end_time" class="block text-sm font-medium text-gray-700">
                                                End Time (calculated)
                                            </label>
                                            <div class="mt-1">
                                                <input type="time" name="end_time" id="end_time"
                                                    value="{{ old('end_time') }}" readonly
                                                    class="bg-gray-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                            </div>
                                        </div>

                                        <!-- Is Booked -->
                                        <div class="sm:col-span-6">
                                            <div class="flex items-start">
                                                <div class="flex items-center h-5">
                                                    <input id="is_booked" name="is_booked" type="checkbox"
                                                        value="1" {{ old('is_booked') ? 'checked' : '' }}
                                                        class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                                </div>
                                                <div class="ml-3 text-sm">
                                                    <label for="is_booked" class="font-medium text-gray-700">Already
                                                        Booked</label>
                                                    <p class="text-gray-500">Check this if the time slot is already
                                                        reserved or
                                                        booked.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                        </div>

                        <!-- Modal Footer -->
                        <div class="flex justify-end gap-3 p-4 border-t border-gray-200 bg-gray-50 rounded-b-lg">
                            <button id="cancelBtn"
                                class="px-4 py-2 bg-white border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Cancel
                            </button>
                            <button type="submit" id="confirmBtn"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Create Time Slot
                            </button>

                            </form>
                        </div>
                    </div>
                </div>

                <!-- Make sure SweetAlert2 is included -->
                <script>
                    // Get DOM elements
                    const openModalBtn = document.getElementById('openModalBtn');
                    const modalOverlay = document.getElementById('modalOverlay');
                    const modalContainer = document.getElementById('modalContainer');
                    const closeModalBtn = document.getElementById('closeModalBtn');
                    const cancelBtn = document.getElementById('cancelBtn');
                    const confirmBtn = document.getElementById('confirmBtn');

                    // Function to open the modal
                    function openModal() {
                        modalOverlay.classList.remove('invisible', 'opacity-0');
                        modalOverlay.classList.add('opacity-100');
                        modalContainer.classList.remove('scale-95');
                        modalContainer.classList.add('scale-100');
                        document.body.classList.add('overflow-hidden');
                    }

                    // Function to close the modal
                    function closeModal() {
                        modalOverlay.classList.remove('opacity-100');
                        modalOverlay.classList.add('opacity-0');
                        modalContainer.classList.remove('scale-100');
                        modalContainer.classList.add('scale-95');
                        setTimeout(() => {
                            modalOverlay.classList.add('invisible');
                            document.body.classList.remove('overflow-hidden');
                        }, 300);
                    }

                    // Open/close modal listeners
                    openModalBtn?.addEventListener('click', openModal);
                    closeModalBtn?.addEventListener('click', closeModal);
                    cancelBtn?.addEventListener('click', closeModal);


                    // Click outside modal to close
                    modalOverlay?.addEventListener('click', (e) => {
                        if (e.target === modalOverlay) {
                            closeModal();
                        }
                    });

                    // ESC key to close modal
                    document.addEventListener('keydown', (e) => {
                        if (e.key === 'Escape' && !modalOverlay.classList.contains('invisible')) {
                            closeModal();
                        }
                    });
                </script>

                {{-- form script --}}
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const serviceSelect = document.getElementById('service_id');
                        const durationInput = document.getElementById('duration');
                        const startTimeInput = document.getElementById('start_time');
                        const endTimeInput = document.getElementById('end_time');

                        // Update duration when service changes
                        serviceSelect.addEventListener('change', function() {
                            const selectedOption = this.options[this.selectedIndex];
                            if (selectedOption && selectedOption.dataset.duration) {
                                durationInput.value = selectedOption.dataset.duration;
                                calculateEndTime();
                            }
                        });

                        // Calculate end time when start time or duration changes
                        startTimeInput.addEventListener('change', calculateEndTime);
                        durationInput.addEventListener('change', calculateEndTime);
                        durationInput.addEventListener('input', calculateEndTime);

                        function calculateEndTime() {
                            const startTime = startTimeInput.value;
                            const duration = parseFloat(durationInput.value);

                            if (startTime && !isNaN(duration)) {
                                const [hours, minutes] = startTime.split(':').map(Number);

                                // Calculate total minutes
                                let totalMinutes = hours * 60 + minutes;
                                totalMinutes += duration * 60;

                                // Convert back to hours and minutes
                                const endHours = Math.floor(totalMinutes / 60) % 24;
                                const endMinutes = totalMinutes % 60;

                                // Format as HH:MM
                                endTimeInput.value =
                                    `${endHours.toString().padStart(2, '0')}:${endMinutes.toString().padStart(2, '0')}`;
                            }
                        }

                        // Initial calculation if values are present
                        if (startTimeInput.value && durationInput.value) {
                            calculateEndTime();
                        }
                    });
                </script>
