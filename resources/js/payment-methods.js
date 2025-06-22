const paymentMethods = [
    {
        id: 1,
        type: "bank",
        name: "Chase Bank ****1234",
        isDefault: true,
        status: "verified",
        addedDate: "2024-01-10",
        lastUsed: "2024-01-15",
    },
    {
        id: 2,
        type: "paypal",
        name: "john.doe@email.com",
        isDefault: false,
        status: "verified",
        addedDate: "2024-01-05",
        lastUsed: "2024-01-12",
    },
    {
        id: 3,
        type: "stripe",
        name: "Stripe Connect",
        isDefault: false,
        status: "pending",
        addedDate: "2024-01-15",
        lastUsed: null,
    },
];

document.addEventListener("DOMContentLoaded", () => {
    const paymentMethodsList = document.getElementById("payment-methods-list");
    const paymentModal = document.getElementById("payment-modal");
    const paymentForm = document.getElementById("payment-form");
    const paymentTypeSelect = document.getElementById("payment-type");
    const bankFields = document.getElementById("bank-fields");
    const paypalFields = document.getElementById("paypal-fields");
    const stripeFields = document.getElementById("stripe-fields");
    const emptyState = document.getElementById("empty-state");

    function getPaymentIcon(type) {
        const icons = {
            bank: `<div class="p-3 bg-blue-100 rounded-xl">
                  <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                  </svg>
              </div>`,
            paypal: `<div class="p-3 bg-blue-100 rounded-xl">
                  <svg class="h-6 w-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M7.076 21.337H2.47a.641.641 0 0 1-.633-.74L4.944.901C5.026.382 5.474 0 5.998 0h7.46c2.57 0 4.578.543 5.69 1.81 1.01 1.15 1.304 2.42 1.012 4.287-.023.143-.047.288-.077.437-.983 5.05-4.349 6.797-8.647 6.797h-2.19c-.524 0-.968.382-1.05.9l-1.12 7.106zm14.146-14.42a3.35 3.35 0 0 0-.607-.541c-.013.076-.026.175-.041.26-.93 4.778-4.005 7.201-9.138 7.201h-2.19a.563.563 0 0 0-.556.479l-1.187 7.527h-.506l1.12-7.106c.082-.518.526-.9 1.05-.9h2.19c4.298 0 7.664-1.747 8.647-6.797.03-.149.054-.294.077-.437.291-1.867-.002-3.137-1.012-4.287z" />
                  </svg>
              </div>`,
            stripe: `<div class="p-3 bg-purple-100 rounded-xl">
                  <svg class="h-6 w-6 text-purple-600" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M13.976 9.15c-2.172-.806-3.356-1.426-3.356-2.409 0-.831.683-1.305 1.901-1.305 2.227 0 4.515.858 6.09 1.631l.89-5.494C18.252.975 15.697 0 12.165 0 9.667 0 7.589.654 6.104 1.872 4.56 3.147 3.757 4.992 3.757 7.218c0 4.039 2.467 5.76 6.476 7.219 1.664-1.305 2.525-3.236 2.525-5.732 0-4.128-2.524-5.851-6.591-7.305z" />
                  </svg>
              </div>`,
        };
        return icons[type] || "";
    }

    function getStatusBadge(status) {
        const badges = {
            verified: "bg-green-100 text-green-800 border-green-200",
            pending: "bg-yellow-100 text-yellow-800 border-yellow-200",
            failed: "bg-red-100 text-red-800 border-red-200",
        };
        return badges[status] || "bg-gray-100 text-gray-800 border-gray-200";
    }

    function updateStats() {
        const totalMethods = paymentMethods.length;
        const verifiedMethods = paymentMethods.filter(
            (m) => m.status === "verified"
        ).length;
        const hasDefault = paymentMethods.some((m) => m.isDefault);

        document.getElementById("total-methods").textContent = totalMethods;
        document.getElementById("verified-methods").textContent =
            verifiedMethods;
        document.getElementById("default-set").textContent = hasDefault
            ? "Yes"
            : "No";
    }

    function renderPaymentMethods() {
        if (paymentMethods.length === 0) {
            paymentMethodsList.classList.add("hidden");
            emptyState.classList.remove("hidden");
            updateStats();
            return;
        }

        paymentMethodsList.classList.remove("hidden");
        emptyState.classList.add("hidden");

        paymentMethodsList.innerHTML = paymentMethods
            .map(
                (method) => `
                  <div class="p-6 hover:bg-gray-50/50 transition-colors duration-200">
                      <div class="flex items-center justify-between">
                          <div class="flex items-center">
                              <div class="flex-shrink-0">
                                  ${getPaymentIcon(method.type)}
                              </div>
                              <div class="ml-4">
                                  <div class="flex items-center">
                                      <h4 class="text-base font-semibold text-gray-900">${
                                          method.name
                                      }</h4>
                                      ${
                                          method.isDefault
                                              ? '<span class="ml-3 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gradient-to-r from-indigo-100 to-purple-100 text-indigo-800 border border-indigo-200">Default</span>'
                                              : ""
                                      }
                                  </div>
                                  <div class="flex items-center mt-2 space-x-3">
                                      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border ${getStatusBadge(
                                          method.status
                                      )}">
                                          ${
                                              method.status === "verified"
                                                  ? '<svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>'
                                                  : method.status === "pending"
                                                  ? '<svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path></svg>'
                                                  : '<svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>'
                                          }
                          ${
                              method.status.charAt(0).toUpperCase() +
                              method.status.slice(1)
                          }
                      </span>
                      ${
                          method.lastUsed
                              ? `<span class="text-xs text-gray-500">Last used: ${new Date(
                                    method.lastUsed
                                ).toLocaleDateString()}</span>`
                              : '<span class="text-xs text-gray-500">Never used</span>'
                      }
                  </div>
                              </div>
                          </div>
                          <div class="flex items-center space-x-2">
                              ${
                                  !method.isDefault
                                      ? `<button onclick="setDefault(${method.id})" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium transition-colors">Set Default</button>`
                                      : ""
                              }
                              <button onclick="editPaymentMethod(${
                                  method.id
                              })" class="p-2 text-gray-400 hover:text-gray-600 transition-colors">
                                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 10-2.828 2.828L11.828 15H9v-2.828l8.586-8.586z" clip-rule="evenodd"></path>
                                  </svg>
                              </button>
                              <button onclick="removePaymentMethod(${
                                  method.id
                              })" class="p-2 text-red-400 hover:text-red-600 transition-colors">
                                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                  </svg>
                              </button>
                          </div>
                      </div>
                  </div>
              `
            )
            .join("");

        updateStats();
    }

    // Open Modal
    window.addPaymentMethod = () => {
        paymentForm.reset();
        paymentTypeSelect.value = "bank";
        toggleFields();
        paymentModal.classList.remove("hidden");
        document.body.style.overflow = "hidden";
    };

    // Close Modal
    window.closePaymentModal = () => {
        paymentModal.classList.add("hidden");
        document.body.style.overflow = "auto";
    };

    // Toggle form fields based on payment type
    function toggleFields() {
        const selected = paymentTypeSelect.value;
        bankFields.classList.toggle("hidden", selected !== "bank");
        paypalFields.classList.toggle("hidden", selected !== "paypal");
        stripeFields.classList.toggle("hidden", selected !== "stripe");
    }

    paymentTypeSelect.addEventListener("change", toggleFields);

    // Handle form submit
    paymentForm.addEventListener("submit", (e) => {
        e.preventDefault();
        const type = paymentTypeSelect.value;
        let name;

        if (type === "bank") {
            const accountHolder =
                bankFields.querySelector('input[placeholder="John Doe"]')
                    .value || "Account Holder";
            const bankName =
                bankFields.querySelector('input[placeholder="Chase Bank"]')
                    .value || "Bank";
            name = `${bankName} ****${Math.floor(1000 + Math.random() * 9000)}`;
        } else if (type === "paypal") {
            const email =
                paypalFields.querySelector('input[type="email"]').value ||
                "paypal@example.com";
            name = email;
        } else {
            name = "Stripe Connect";
        }

        const newMethod = {
            id: Date.now(),
            type,
            name,
            isDefault: paymentMethods.length === 0, // First method becomes default
            status: type === "stripe" ? "pending" : "verified",
            addedDate: new Date().toISOString().split("T")[0],
            lastUsed: null,
        };

        paymentMethods.push(newMethod);
        renderPaymentMethods();
        window.closePaymentModal();

        // Success notification
        window.Swal.fire({
            toast: true,
            position: "top-end",
            icon: "success",
            title: "Payment method added successfully!",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
    });

    // Set as Default
    window.setDefault = (id) => {
        paymentMethods.forEach((pm) => (pm.isDefault = pm.id === id));
        renderPaymentMethods();

        window.Swal.fire({
            toast: true,
            position: "top-end",
            icon: "success",
            title: "Default payment method updated",
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
        });
    };

    // Remove Payment Method
    window.removePaymentMethod = (id) => {
        const method = paymentMethods.find((pm) => pm.id === id);

        window.Swal.fire({
            title: "Remove Payment Method?",
            text: `Are you sure you want to remove ${method.name}?`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#ef4444",
            cancelButtonColor: "#6b7280",
            confirmButtonText: "Yes, remove it",
            cancelButtonText: "Cancel",
            customClass: {
                popup: "rounded-xl",
                confirmButton: "rounded-lg",
                cancelButton: "rounded-lg",
            },
        }).then((result) => {
            if (result.isConfirmed) {
                const index = paymentMethods.findIndex((pm) => pm.id === id);
                if (index !== -1) {
                    // If removing default method, set another as default
                    if (method.isDefault && paymentMethods.length > 1) {
                        const otherMethods = paymentMethods.filter(
                            (pm) => pm.id !== id
                        );
                        if (otherMethods.length > 0) {
                            otherMethods[0].isDefault = true;
                        }
                    }

                    paymentMethods.splice(index, 1);
                    renderPaymentMethods();

                    window.Swal.fire({
                        toast: true,
                        position: "top-end",
                        icon: "success",
                        title: "Payment method removed",
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true,
                    });
                }
            }
        });
    };

    // Edit Payment Method
    window.editPaymentMethod = (id) => {
        const method = paymentMethods.find((pm) => pm.id === id);

        window.Swal.fire({
            title: "Edit Payment Method",
            html: `
                  <div class="text-left">
                      <p class="text-gray-600 mb-4">Editing: <strong>${method.name}</strong></p>
                      <p class="text-sm text-gray-500">Full editing functionality will be available soon. For now, you can remove and re-add payment methods.</p>
                  </div>
              `,
            icon: "info",
            confirmButtonText: "Got it",
            customClass: {
                popup: "rounded-xl",
                confirmButton:
                    "rounded-lg bg-gradient-to-r from-indigo-500 to-purple-500",
            },
        });
    };

    // Close modal when clicking outside
    paymentModal.addEventListener("click", (e) => {
        if (e.target === paymentModal) {
            window.closePaymentModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape" && !paymentModal.classList.contains("hidden")) {
            window.closePaymentModal();
        }
    });

    // Initial render
    renderPaymentMethods();
});

// Declare Swal and closePaymentModal variables
window.Swal = window.Swal || {};
window.closePaymentModal = window.closePaymentModal || (() => {});
