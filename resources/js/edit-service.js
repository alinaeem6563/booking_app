document.addEventListener("DOMContentLoaded", () => {
    // === Edit Modal Functionality ===
    const editModal = document.getElementById("editServiceModal");
    const closeEditModalBtn = document.getElementById("closeEditServiceModal");
    const cancelEditBtn = document.getElementById("cancel-edit-service-btn");
    let currentServiceData = {};

    function closeEditModal() {
        editModal.classList.add("hidden");
        document.body.style.overflow = "";
        currentServiceData = {};
    }

    // Global function to open edit modal
    window.openEditServiceModal = (serviceId) => {
        // Show SweetAlert2 loading
        Swal.fire({
            title: "Loading Service",
            text: "Please wait while we load service details...",
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            },
        });

        // Corrected route for providers
        fetch(`/providers/${serviceId}/edit`)
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json();
            })
            .then((data) => {
                Swal.close(); // Close loading modal
                currentServiceData = data.service;
                populateEditForm(data.service); // Your existing form-population logic
                editModal.classList.remove("hidden");
                document.body.style.overflow = "hidden";
            })
            .catch((error) => {
                console.error("Error fetching service:", error);
                Swal.fire({
                    icon: "error",
                    title: "Failed to Load",
                    text: "There was an error loading the service. Please try again later.",
                });
            });
    };

    closeEditModalBtn?.addEventListener("click", closeEditModal);
    cancelEditBtn?.addEventListener("click", closeEditModal);
    editModal?.addEventListener("click", (e) => {
        if (e.target === editModal) closeEditModal();
    });

    // === Populate Edit Form ===
    function populateEditForm(service) {
        // Basic Information
        document.getElementById("edit_service_name").value =
            service.service_name || "";
        document.getElementById("edit_service_description").value =
            service.service_description || "";
        document.getElementById("edit_qualifications_certifications").value =
            service.qualifications_certifications || "";
        document.getElementById("edit_category_id").value =
            service.category_id || "";
        document.getElementById("edit_service_price").value =
            service.service_price || "";
        document.getElementById("edit_service_duration").value =
            service.service_duration || "1";
        document.getElementById("edit_service_location").value =
            service.service_location || "";
            document.getElementById("edit_service_status").checked =
                !!service.service_status;


        // Pricing
        document.getElementById("edit_service_fee").value =
            service.service_fee || "";
        document.getElementById("edit_tax").value = service.tax || "";

        // Set form action
        document.getElementById(
            "editServiceForm"
        ).action = `/services/${service.id}`;

        // Populate current images
        populateCurrentImages(service);

        // Populate service offerings
        populateServiceOfferings(service.service_offerings || []);

        // Populate additional services
        populateAdditionalServices(service.additional_services || []);

        // Populate FAQs
        populateFAQs(service.faqs || []);
    }

    function populateCurrentImages(service) {
        // Current Service Image
        const currentImageContainer = document.getElementById(
            "current-service-image"
        );
        if (service.service_image) {
            currentImageContainer.innerHTML = `
                  <div class="relative inline-block">
                      <img src="/storage/${service.service_image}" class="h-32 w-auto rounded-lg object-cover border border-gray-200">
                      <div class="absolute top-2 right-2 bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded">
                          Current
                      </div>
                  </div>
              `;
        } else {
            currentImageContainer.innerHTML =
                '<p class="text-gray-500 text-sm">No current image</p>';
        }

        // Current Work Gallery
        const currentGalleryContainer = document.getElementById(
            "current-work-gallery"
        );
        if (service.work_gallery && service.work_gallery.length > 0) {
            const galleryHTML = service.work_gallery
                .map(
                    (image) => `
                  <div class="relative">
                      <img src="/storage/${image}" class="h-20 w-full rounded-md object-cover border border-gray-200">
                      <div class="absolute top-1 right-1 bg-black bg-opacity-50 text-white text-xs px-1 rounded">
                          Current
                      </div>
                  </div>
              `
                )
                .join("");
            currentGalleryContainer.innerHTML = `<div class="grid grid-cols-3 gap-2">${galleryHTML}</div>`;
        } else {
            currentGalleryContainer.innerHTML =
                '<p class="text-gray-500 text-sm">No current gallery images</p>';
        }
    }

    function populateServiceOfferings(offerings) {
        const container = document.getElementById("edit-offerings-container");
        container.innerHTML = "";

        if (offerings.length === 0) {
            // Add default empty offering
            offerings = [{ service_name: "", description: "", price: "" }];
        }

        offerings.forEach((offering, index) => {
            const offeringHTML = `
                  <div class="bg-white border border-gray-200 rounded-lg p-4 offering-item mb-4">
                      <div class="flex justify-between items-center mb-2">
                          <h5 class="text-sm font-medium text-gray-700">Offering #${
                              index + 1
                          }</h5>
                          <button type="button" class="text-red-500 hover:text-red-700 delete-offering ${
                              index === 0 ? "hidden" : ""
                          } transition-colors duration-200">
                              <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                              </svg>
                          </button>
                      </div>
                      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                          <div>
                              <label class="block text-sm font-medium text-gray-700 mb-1">Service Name</label>
                              <input name="Service_Offered[${index}]" type="text" value="${
                offering.service_name || ""
            }"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                          </div>
                          <div>
                              <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                              <input name="Service_Offered_description[${index}]" type="text" value="${
                offering.description || ""
            }"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                          </div>
                          <div>
                              <label class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                              <div class="relative">
                                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                      <span class="text-gray-500 text-sm">$</span>
                                  </div>
                                  <input name="Service_Offered_price[${index}]" type="number" min="0" step="0.01" value="${
                offering.price || ""
            }"
                                      class="w-full pl-8 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200"
                                      placeholder="0.00">
                              </div>
                          </div>
                      </div>
                  </div>
              `;
            container.insertAdjacentHTML("beforeend", offeringHTML);
        });

        // Add event listeners for delete buttons
        container.querySelectorAll(".delete-offering").forEach((btn) => {
            btn.addEventListener("click", function () {
                this.closest(".offering-item").remove();
                updateOfferingNumbers();
            });
        });
    }

    function populateAdditionalServices(services) {
        const container = document.getElementById(
            "edit-additional-services-container"
        );
        container.innerHTML = "";

        if (services.length === 0) {
            // Add default empty service
            services = [{ name: "", price: "" }];
        }

        services.forEach((service, index) => {
            const serviceHTML = `
                  <div class="additional-service-item bg-white p-4 rounded-lg border border-gray-200 mb-3">
                      <div class="flex justify-between items-center mb-2">
                          <span class="text-xs font-medium text-gray-700">Additional Service #${
                              index + 1
                          }</span>
                          <button type="button" class="remove-service text-xs text-red-500 hover:text-red-700 ${
                              index === 0 ? "hidden" : ""
                          }">Remove</button>
                      </div>
                      <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                          <div class="md:col-span-2">
                              <label class="block text-xs font-medium text-gray-500 mb-1">Service Description</label>
                              <input type="text" name="additional_services[${index}][name]" value="${
                service.name || ""
            }"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200"
                                  placeholder="e.g., Express Delivery">
                          </div>
                          <div>
                              <label class="block text-xs font-medium text-gray-500 mb-1">Price</label>
                              <div class="relative">
                                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                      <span class="text-gray-500 text-sm">$</span>
                                  </div>
                                  <input type="text" name="additional_services[${index}][price]" value="${
                service.price || ""
            }"
                                      class="w-full pl-7 pr-12 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200"
                                      placeholder="0.00">
                                  <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                      <span class="text-gray-500 text-sm">USD</span>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              `;
            container.insertAdjacentHTML("beforeend", serviceHTML);
        });

        // Add event listeners for remove buttons
        container.querySelectorAll(".remove-service").forEach((btn) => {
            btn.addEventListener("click", function () {
                this.closest(".additional-service-item").remove();
                updateAdditionalServiceNumbers();
            });
        });
    }

    function populateFAQs(faqs) {
        const container = document.getElementById("edit-faq-container");
        container.innerHTML = "";

        if (faqs.length === 0) {
            // Add default empty FAQ
            faqs = [{ questions: "", answers: "" }];
        }

        faqs.forEach((faq, index) => {
            const faqHTML = `
                  <div class="faq-item mb-6 p-5 bg-white border border-gray-200 rounded-lg transition-all duration-200 hover:shadow-md">
                      <div class="flex flex-col md:flex-row md:items-center justify-between mb-4">
                          <h3 class="text-lg font-medium text-gray-700 mb-2 md:mb-0">Question #${
                              index + 1
                          }</h3>
                          <button type="button" class="remove-faq text-sm text-red-500 hover:text-red-700 ${
                              index === 0 ? "hidden" : ""
                          } transition-colors duration-200">
                              Remove
                          </button>
                      </div>
                      <div class="space-y-4">
                          <div>
                              <label class="block text-sm font-medium text-gray-700 mb-1">Question</label>
                              <input type="text" name="questions[${index}]" value="${
                faq.questions || ""
            }"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200"
                                  placeholder="Enter your question here" required>
                          </div>
                          <div>
                              <label class="block text-sm font-medium text-gray-700 mb-1">Answer</label>
                              <textarea name="answers[${index}]" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200"
                                  placeholder="Enter your answer here" required>${
                                      faq.answers || ""
                                  }</textarea>
                          </div>
                      </div>
                  </div>
              `;
            container.insertAdjacentHTML("beforeend", faqHTML);
        });

        // Add event listeners for remove buttons
        container.querySelectorAll(".remove-faq").forEach((btn) => {
            btn.addEventListener("click", function () {
                this.closest(".faq-item").remove();
                updateFAQNumbers();
            });
        });
    }

    // === Add New Items Functionality ===
    document
        .getElementById("edit-add-offering-btn")
        ?.addEventListener("click", () => {
            const container = document.getElementById(
                "edit-offerings-container"
            );
            const count = container.querySelectorAll(".offering-item").length;

            const newOfferingHTML = `
              <div class="bg-white border border-gray-200 rounded-lg p-4 offering-item mb-4 animate-fade-in">
                  <div class="flex justify-between items-center mb-2">
                      <h5 class="text-sm font-medium text-gray-700">Offering #${
                          count + 1
                      }</h5>
                      <button type="button" class="text-red-500 hover:text-red-700 delete-offering transition-colors duration-200">
                          <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                          </svg>
                      </button>
                  </div>
                  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                      <div>
                          <label class="block text-sm font-medium text-gray-700 mb-1">Service Name</label>
                          <input name="Service_Offered[${count}]" type="text"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                      </div>
                      <div>
                          <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                          <input name="Service_Offered_description[${count}]" type="text"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                      </div>
                      <div>
                          <label class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                          <div class="relative">
                              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                  <span class="text-gray-500 text-sm">$</span>
                              </div>
                              <input name="Service_Offered_price[${count}]" type="number" min="0" step="0.01"
                                  class="w-full pl-8 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200"
                                  placeholder="0.00">
                          </div>
                      </div>
                  </div>
              </div>
          `;

            container.insertAdjacentHTML("beforeend", newOfferingHTML);

            // Add event listener to new delete button
            container
                .querySelector(".offering-item:last-child .delete-offering")
                .addEventListener("click", function () {
                    this.closest(".offering-item").remove();
                    updateOfferingNumbers();
                });
        });

    document
        .getElementById("edit-add-service-btn")
        ?.addEventListener("click", () => {
            const container = document.getElementById(
                "edit-additional-services-container"
            );
            const count = container.querySelectorAll(
                ".additional-service-item"
            ).length;

            const newServiceHTML = `
              <div class="additional-service-item bg-white p-4 rounded-lg border border-gray-200 mb-3 animate-fade-in">
                  <div class="flex justify-between items-center mb-2">
                      <span class="text-xs font-medium text-gray-700">Additional Service #${
                          count + 1
                      }</span>
                      <button type="button" class="remove-service text-xs text-red-500 hover:text-red-700">Remove</button>
                  </div>
                  <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                      <div class="md:col-span-2">
                          <label class="block text-xs font-medium text-gray-500 mb-1">Service Description</label>
                          <input type="text" name="additional_services[${count}][name]"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200"
                              placeholder="e.g., Express Delivery">
                      </div>
                      <div>
                          <label class="block text-xs font-medium text-gray-500 mb-1">Price</label>
                          <div class="relative">
                              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                  <span class="text-gray-500 text-sm">$</span>
                              </div>
                              <input type="text" name="additional_services[${count}][price]"
                                  class="w-full pl-7 pr-12 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200"
                                  placeholder="0.00">
                              <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                  <span class="text-gray-500 text-sm">USD</span>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          `;

            container.insertAdjacentHTML("beforeend", newServiceHTML);

            // Add event listener to new remove button
            container
                .querySelector(
                    ".additional-service-item:last-child .remove-service"
                )
                .addEventListener("click", function () {
                    this.closest(".additional-service-item").remove();
                    updateAdditionalServiceNumbers();
                });
        });

    document
        .getElementById("edit-add-faq-btn")
        ?.addEventListener("click", () => {
            const container = document.getElementById("edit-faq-container");
            const count = container.querySelectorAll(".faq-item").length;

            if (count >= 5) {
                Swal.fire({
                    icon: "info",
                    title: "Limit Reached",
                    text: "You can add a maximum of 5 questions.",
                    showConfirmButton: false,
                    timer: 2000,
                });
                
                return;
            }

            const newFaqHTML = `
              <div class="faq-item mb-6 p-5 bg-white border border-gray-200 rounded-lg transition-all duration-200 hover:shadow-md animate-fade-in">
                  <div class="flex flex-col md:flex-row md:items-center justify-between mb-4">
                      <h3 class="text-lg font-medium text-gray-700 mb-2 md:mb-0">Question #${
                          count + 1
                      }</h3>
                      <button type="button" class="remove-faq text-sm text-red-500 hover:text-red-700 transition-colors duration-200">
                          Remove
                      </button>
                  </div>
                  <div class="space-y-4">
                      <div>
                          <label class="block text-sm font-medium text-gray-700 mb-1">Question</label>
                          <input type="text" name="questions[${count}]"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200"
                              placeholder="Enter your question here" required>
                      </div>
                      <div>
                          <label class="block text-sm font-medium text-gray-700 mb-1">Answer</label>
                          <textarea name="answers[${count}]" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200"
                              placeholder="Enter your answer here" required></textarea>
                      </div>
                  </div>
              </div>
          `;

            container.insertAdjacentHTML("beforeend", newFaqHTML);

            // Add event listener to new remove button
            container
                .querySelector(".faq-item:last-child .remove-faq")
                .addEventListener("click", function () {
                    this.closest(".faq-item").remove();
                    updateFAQNumbers();
                });
        });

    // === Update numbering functions ===
    function updateOfferingNumbers() {
        const items = document.querySelectorAll(
            "#edit-offerings-container .offering-item"
        );
        items.forEach((item, index) => {
            item.querySelector("h5").textContent = `Offering #${index + 1}`;
            const inputs = item.querySelectorAll("input");
            inputs[0].name = `Service_Offered[${index}]`;
            inputs[1].name = `Service_Offered_description[${index}]`;
            inputs[2].name = `Service_Offered_price[${index}]`;
        });
    }

    function updateAdditionalServiceNumbers() {
        const items = document.querySelectorAll(
            "#edit-additional-services-container .additional-service-item"
        );
        items.forEach((item, index) => {
            item.querySelector("span").textContent = `Additional Service #${
                index + 1
            }`;
            const inputs = item.querySelectorAll("input");
            inputs[0].name = `additional_services[${index}][name]`;
            inputs[1].name = `additional_services[${index}][price]`;
        });
    }

    function updateFAQNumbers() {
        const items = document.querySelectorAll(
            "#edit-faq-container .faq-item"
        );
        items.forEach((item, index) => {
            item.querySelector("h3").textContent = `Question #${index + 1}`;
            const inputs = item.querySelectorAll("input, textarea");
            inputs[0].name = `questions[${index}]`;
            inputs[1].name = `answers[${index}]`;
        });
    }

    // === Image Preview Functionality ===
    document
        .getElementById("edit_service_image")
        ?.addEventListener("change", (e) => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const container = document
                        .getElementById("edit_service_image")
                        .closest("div.border-dashed");
                    container.querySelector(".image-preview")?.remove();
                    const preview = document.createElement("div");
                    preview.className = "image-preview mt-3";
                    preview.innerHTML = `
                      <div class="relative">
                          <img src="${e.target.result}" class="h-32 w-auto mx-auto rounded-md object-cover" />
                          <button type="button" class="absolute top-0 right-0 bg-red-500 text-white rounded-full p-1 transform translate-x-1/2 -translate-y-1/2" onclick="this.closest('.image-preview').remove(); document.getElementById('edit_service_image').value = '';">
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

    document
        .getElementById("edit_work_gallery")
        ?.addEventListener("change", (e) => {
            const files = e.target.files;
            if (files.length) {
                const container = document
                    .getElementById("edit_work_gallery")
                    .closest("div.border-dashed");
                container.querySelector(".gallery-preview")?.remove();
                const previewContainer = document.createElement("div");
                previewContainer.className =
                    "gallery-preview mt-3 grid grid-cols-2 sm:grid-cols-3 gap-2";
                container.appendChild(previewContainer);

                Array.from(files).forEach((file) => {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const previewItem = document.createElement("div");
                        previewItem.className = "relative";
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

    // === Form Submission ===
    document
        .getElementById("editServiceForm")
        ?.addEventListener("submit", function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;

            // Disable button and show loading spinner
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
          <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          Updating...
        `;

            formData.append("_method", "PUT"); // Simulate PUT request

            fetch(this.action, {
                method: "POST",
                body: formData,
                headers: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                    Accept: "application/json",
                },
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        Swal.fire({
                            icon: "success",
                            title: "Service Updated",
                            text: "The service was updated successfully.",
                            timer: 2000,
                            showConfirmButton: false,
                        }).then(() => {
                            closeEditModal();
                            window.location.reload();
                        });
                    } else {
                        throw new Error(
                            data.message || "Failed to update service"
                        );
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                    Swal.fire({
                        icon: "error",
                        title: "Update Failed",
                        text:
                            error.message ||
                            "There was an error updating the service.",
                    });
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                });
        });

    // === CSS Injection ===
    const style = document.createElement("style");
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
      `;
    document.head.appendChild(style);
});
