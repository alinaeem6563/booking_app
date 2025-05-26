
document.addEventListener('DOMContentLoaded', function () {
    // === Modal Functionality ===
    const modal = document.getElementById('serviceModal');
    const openModalBtn = document.getElementById('openServiceModal');
    const closeModalBtn = document.getElementById('closeServiceModal');
    const cancelBtn = document.getElementById('cancel-service-btn');

    function closeModal() {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }

    openModalBtn?.addEventListener('click', () => {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    });

    closeModalBtn?.addEventListener('click', closeModal);
    cancelBtn?.addEventListener('click', closeModal);
    modal?.addEventListener('click', e => {
        if (e.target === modal) closeModal();
    });

    // === Service Offerings Functionality ===
    const addOfferingBtn = document.getElementById('add-offering-btn');
    const offeringsContainer = document.querySelector('#offerings-container .space-y-4');
    let offeringCount = document.querySelectorAll('.offering-item').length || 1;

    addOfferingBtn?.addEventListener('click', function () {
        offeringCount++;
        const newOffering = document.createElement('div');
        newOffering.className = 'border border-gray-200 rounded-md p-4 offering-item';
        newOffering.innerHTML = `
            <div class="flex justify-between items-center mb-2">
                <h5 class="text-sm font-medium text-gray-700">Offering #${offeringCount}</h5>
                <button type="button" class="text-red-500 hover:text-red-700 delete-offering">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Offering Name</label>
                    <input name="Service_Offered[]" type="text" class="input-class">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <input name="Service_Offered_description[]" type="text" class="input-class">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Price</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">$</span>
                        </div>
                        <input name="Service_Offered_price[]" type="number" min="0" step="0.01" class="input-class pl-7" placeholder="0.00">
                    </div>
                </div>
            </div>
        `;
        offeringsContainer?.appendChild(newOffering);

        const deleteBtn = newOffering.querySelector('.delete-offering');
        deleteBtn?.addEventListener('click', function () {
            newOffering.remove();
            offeringCount--;
            document.querySelectorAll('.offering-item').forEach((item, index) => {
                item.querySelector('h5').textContent = `Offering #${index + 1}`;
            });
        });
    });

    // === Image Preview - Service Image ===
    const serviceImageInput = document.getElementById('service_image');
    serviceImageInput?.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const container = serviceImageInput.closest('div.border-dashed');
                container.querySelector('.image-preview')?.remove();
                const preview = document.createElement('div');
                preview.className = 'image-preview mt-3';
                preview.innerHTML = `
                    <div class="relative">
                        <img src="${e.target.result}" class="h-32 w-auto mx-auto rounded-md object-cover" />
                        <button type="button" class="absolute top-0 right-0 bg-red-500 text-white rounded-full p-1 transform translate-x-1/2 -translate-y-1/2" onclick="this.closest('.image-preview').remove(); document.getElementById('service_image').value = '';">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                `;
                container.appendChild(preview);
            };
            reader.readAsDataURL(file);
        }
    });

    // === Image Preview - Work Gallery ===
    const workGalleryInput = document.getElementById('work_gallery');
    workGalleryInput?.addEventListener('change', function (e) {
        const files = e.target.files;
        if (files.length) {
            const container = workGalleryInput.closest('div.border-dashed');
            container.querySelector('.gallery-preview')?.remove();
            const previewContainer = document.createElement('div');
            previewContainer.className = 'gallery-preview mt-3 grid grid-cols-2 sm:grid-cols-3 gap-2';
            container.appendChild(previewContainer);

            Array.from(files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const previewItem = document.createElement('div');
                    previewItem.className = 'relative';
                    previewItem.innerHTML = `
                        <img src="${e.target.result}" class="h-20 w-full rounded-md object-cover" />
                        <button type="button" class="absolute top-0 right-0 bg-red-500 text-white rounded-full p-1 transform translate-x-1/2 -translate-y-1/2" onclick="this.closest('.relative').remove();">
                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    `;
                    previewContainer.appendChild(previewItem);
                };
                reader.readAsDataURL(file);
            });
        }
    });

    // === FAQ Functionality ===
    const faqContainer = document.getElementById('faq-container');
    const faqAddBtn = document.getElementById('add-faq-btn');
    let faqCount = faqContainer?.querySelectorAll('.faq-item').length || 1;
    const MAX_FAQS = 5;

    function removeFaqItem(e) {
        const item = e.target.closest('.faq-item');
        item.classList.add('opacity-0');
        setTimeout(() => {
            item.remove();
            faqCount--;
            if (faqCount < MAX_FAQS) {
                faqAddBtn.disabled = false;
                faqAddBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
            if (faqCount === 1) {
                const firstItemRemoveBtn = faqContainer.querySelector('.faq-item:first-child .remove-faq');
                firstItemRemoveBtn?.classList.add('hidden');
            }

            faqContainer.querySelectorAll('.faq-item').forEach((item, index) => {
                item.querySelector('h3').textContent = `Question #${index + 1}`;
                const questionInput = item.querySelector('input[name^="questions"]');
                const answerInput = item.querySelector('textarea[name^="answers"]');
                questionInput.name = `questions[${index}]`;
                questionInput.id = `questions[${index}]`;
                answerInput.name = `answers[${index}]`;
                answerInput.id = `answers[${index}]`;
            });
        }, 200);
    }

    faqAddBtn?.addEventListener('click', function () {
        if (faqCount >= MAX_FAQS) {
            alert('You can add a maximum of 5 questions.');
            return;
        }

        const newItem = document.createElement('div');
        newItem.className = 'faq-item mb-6 p-5 border border-gray-200 rounded-lg bg-gray-50 transition-all duration-200 hover:shadow-md animate-fade-in';
        newItem.innerHTML = `
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-700 mb-2 md:mb-0">Question #${faqCount + 1}</h3>
                <button type="button" class="remove-faq text-sm text-red-500 hover:text-red-700">Remove</button>
            </div>
            <div class="space-y-4">
                <div>
                    <label for="questions[${faqCount}]" class="block text-sm font-medium text-gray-700 mb-1">Question</label>
                    <input type="text" name="questions[${faqCount}]" id="questions[${faqCount}]" class="input-class" placeholder="Enter your question here" required>
                </div>
                <div>
                    <label for="answers[${faqCount}]" class="block text-sm font-medium text-gray-700 mb-1">Answer</label>
                    <textarea name="answers[${faqCount}]" id="answers[${faqCount}]" rows="3" class="input-class" placeholder="Enter your answer here" required></textarea>
                </div>
            </div>
        `;
        faqContainer.appendChild(newItem);
        faqCount++;

        if (faqCount >= MAX_FAQS) {
            faqAddBtn.disabled = true;
            faqAddBtn.classList.add('opacity-50', 'cursor-not-allowed');
        }

        const removeButtons = document.querySelectorAll('.remove-faq');
        removeButtons.forEach(btn => {
            btn.removeEventListener('click', removeFaqItem);
            btn.addEventListener('click', removeFaqItem);
        });
    });

    // === Additional Services Functionality ===
    const addServiceBtn = document.getElementById('add-service-btn');
    const additionalServicesContainer = document.getElementById('additional-services-container');
    let serviceCount = 1;

    addServiceBtn.addEventListener('click', function () {
        const newItem = document.createElement('div');
        newItem.className = 'additional-service-item bg-gray-50 p-3 rounded-md border border-gray-200 mb-3 animate-fade-in';
        newItem.innerHTML = `
            <div class="flex justify-between items-center mb-2">
                <span class="text-xs font-medium text-gray-700">Additional Service #${serviceCount + 1}</span>
                <button type="button" class="remove-service text-xs text-red-500 hover:text-red-700">Remove</button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <div class="md:col-span-2">
                    <label for="service_name_${serviceCount}" class="block text-xs font-medium text-gray-500 mb-1">Service Description</label>
                    <input type="text" name="additional_services[${serviceCount}][name]" id="service_name_${serviceCount}" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="e.g., Express Delivery">
                </div>
                <div>
                    <label for="service_price_${serviceCount}" class="block text-xs font-medium text-gray-500 mb-1">Price</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">$</span>
                        </div>
                        <input type="text" name="additional_services[${serviceCount}][price]" id="service_price_${serviceCount}" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" placeholder="0.00" aria-describedby="price-currency">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm" id="price-currency">USD</span>
                        </div>
                    </div>
                </div>
            </div>
        `;
        additionalServicesContainer.appendChild(newItem);
        serviceCount++;

        const removeBtn = newItem.querySelector('.remove-service');
        removeBtn.addEventListener('click', function () {
            newItem.classList.add('opacity-0');
            setTimeout(() => {
                newItem.remove();
                updateServiceNumbers();
            }, 200);
        });
    });

    function updateServiceNumbers() {
        const items = document.querySelectorAll('.additional-service-item');
        items.forEach((item, index) => {
            item.querySelector('span').textContent = `Additional Service #${index + 1}`;
            item.querySelector('input[type="text"]').name = `additional_services[${index}][name]`;
            item.querySelector('input[type="text"]').id = `service_name_${index}`;
            item.querySelector('input[type="text"]:nth-child(2)').name = `additional_services[${index}][price]`;
            item.querySelector('input[type="text"]:nth-child(2)').id = `service_price_${index}`;
        });
        serviceCount = items.length;
    }

    // === CSS Injection ===
    const style = document.createElement('style');
    style.textContent = `
        .animate-fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .faq-item {
            transition: opacity 0.2s ease-out, transform 0.2s ease-out;
        }
        .input-class {
            margin-top: 0.25rem; 
            width: 100%; 
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            padding: 0.5rem;
            font-size: 0.875rem;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }
    `;
    document.head.appendChild(style);
});
