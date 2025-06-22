// Enhanced invoice data with clean structure

document.addEventListener("DOMContentLoaded", () => {
    const invoicesTbody = document.getElementById("invoices-tbody");
    const mobileInvoices = document.getElementById("mobile-invoices");
    const searchInput = document.getElementById("search-invoices");
    const statusFilter = document.getElementById("status-filter");
    const dateFilter = document.getElementById("date-filter");
    const clientFilter = document.getElementById("client-filter");
    const sortFilter = document.getElementById("sort-filter");

    function getStatusBadge(status) {
        const badges = {
            confirmed: "bg-indigo-100 text-indigo-800",
            pending: "bg-amber-100 text-amber-800",
        };
        return badges[status] || "bg-gray-100 text-gray-800";
    }

    function getPriorityBadge(priority) {
        const badges = {
            urgent: "bg-red-100 text-red-800",
            high: "bg-orange-100 text-orange-800",
            normal: "bg-blue-100 text-blue-800",
        };
        return badges[priority] || "bg-gray-100 text-gray-800";
    }

    function formatDate(dateString) {
        if (!dateString) return "N/A";
        return new Date(dateString).toLocaleDateString("en-US", {
            month: "short",
            day: "numeric",
            year: "numeric",
        });
    }

    function formatCurrency(amount) {
        return new Intl.NumberFormat("en-US", {
            style: "currency",
            currency: "USD",
            minimumFractionDigits: 2,
        }).format(amount);
    }

    function renderMobileCards(invoices) {
        if (invoices.length === 0) {
            mobileInvoices.innerHTML = `
          <div class="p-8 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
              <div class="w-8 h-8 bg-gray-300 rounded"></div>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No invoices found</h3>
            <p class="text-gray-500">Try adjusting your search or filter criteria</p>
          </div>
        `;
            return;
        }

        mobileInvoices.innerHTML = invoices
            .map(
                (invoice) => `
          <div class="p-4 border-b border-gray-100 hover:bg-gray-50 transition-colors duration-200 cursor-pointer" onclick="window.viewInvoice(${
              invoice.id
          })">
            <div class="flex items-start space-x-4">
              <img src="${invoice.clientAvatar}" alt="${invoice.clientName}" 
                   class="w-12 h-12 rounded-lg object-cover">
              
              <div class="flex-1 min-w-0">
                <div class="flex justify-between items-start mb-2">
                  <div>
                    <h3 class="font-medium text-gray-900 text-sm">${
                        invoice.invoiceNumber
                    }</h3>
                    <p class="text-xs text-gray-600 mt-1">${invoice.service}</p>
                  </div>
                  <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium ${getStatusBadge(
                      invoice.status
                  )}">
                    ${
                        invoice.status.charAt(0).toUpperCase() +
                        invoice.status.slice(1)
                    }
                  </span>
                </div>
                
                <div class="flex justify-between items-center">
                  <div>
                    <p class="text-sm font-medium text-gray-900">${
                        invoice.clientName
                    }</p>
                    <p class="text-xs text-gray-500">${formatDate(
                        invoice.issueDate
                    )}</p>
                  </div>
                  <div class="text-right">
                    <p class="text-lg font-semibold text-gray-900">${formatCurrency(
                        invoice.amount
                    )}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        `
            )
            .join("");
    }

    function renderDesktopTable(invoices) {
        if (invoices.length === 0) {
            invoicesTbody.innerHTML = `
          <tr>
            <td colspan="6" class="px-6 py-12 text-center">
              <div class="flex flex-col items-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                  <div class="w-8 h-8 bg-gray-300 rounded"></div>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No invoices found</h3>
                <p class="text-gray-500">Try adjusting your search or filter criteria</p>
              </div>
            </td>
          </tr>
        `;
            return;
        }

        invoicesTbody.innerHTML = invoices
            .map(
                (invoice) => `
          <tr class="hover:bg-gray-50 transition-colors duration-200 cursor-pointer" onclick="window.viewInvoice(${
              invoice.id
          })">
            <td class="px-6 py-4">
              <div>
                <div class="text-sm font-medium text-gray-900">${
                    invoice.invoiceNumber
                }</div>
                <div class="text-xs text-gray-500">${invoice.service}</div>
              </div>
            </td>
            <td class="px-6 py-4">
              <div class="flex items-center space-x-3">
                <img src="${invoice.clientAvatar}" alt="${invoice.clientName}" 
                     class="w-8 h-8 rounded-lg object-cover">
                <div>
                  <div class="text-sm font-medium text-gray-900">${
                      invoice.clientName
                  }</div>
                  <div class="text-xs text-gray-500">${
                      invoice.clientEmail
                  }</div>
                </div>
              </div>
            </td>
            <td class="px-6 py-4">
              <div class="text-sm text-gray-900">${formatDate(
                  invoice.issueDate
              )}</div>
            </td>
            <td class="px-6 py-4">
              <div class="text-sm font-semibold text-gray-900">${formatCurrency(
                  invoice.amount
              )}</div>
            </td>
            <td class="px-6 py-4">
              <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium ${getStatusBadge(
                  invoice.status
              )}">
                ${
                    invoice.status.charAt(0).toUpperCase() +
                    invoice.status.slice(1)
                }
              </span>
            </td>
            <td class="px-6 py-4 text-right">
              <button class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                View
              </button>
            </td>
          </tr>
        `
            )
            .join("");
    }

    function filterInvoices() {
        setTimeout(() => {
            let filtered = [...invoices];

            const searchTerm = searchInput?.value.toLowerCase() || "";
            const status = statusFilter?.value || "";
            const date = dateFilter?.value || "";
            const client = clientFilter?.value || "";
            const sort = sortFilter?.value || "date-desc";

            // Search filter
            if (searchTerm) {
                filtered = filtered.filter(
                    (invoice) =>
                        invoice.invoiceNumber
                            .toLowerCase()
                            .includes(searchTerm) ||
                        invoice.clientName.toLowerCase().includes(searchTerm) ||
                        invoice.service.toLowerCase().includes(searchTerm)
                );
            }

            // Status filter
            if (status) {
                filtered = filtered.filter(
                    (invoice) => invoice.status === status
                );
            }

            // Date filter
            if (date) {
                const now = new Date();
                const startOfMonth = new Date(
                    now.getFullYear(),
                    now.getMonth(),
                    1
                );
                const startOfLastMonth = new Date(
                    now.getFullYear(),
                    now.getMonth() - 1,
                    1
                );
                const startOfQuarter = new Date(
                    now.getFullYear(),
                    Math.floor(now.getMonth() / 3) * 3,
                    1
                );

                filtered = filtered.filter((invoice) => {
                    const invoiceDate = new Date(invoice.issueDate);
                    switch (date) {
                        case "this-month":
                            return invoiceDate >= startOfMonth;
                        case "last-month":
                            return (
                                invoiceDate >= startOfLastMonth &&
                                invoiceDate < startOfMonth
                            );
                        case "this-quarter":
                            return invoiceDate >= startOfQuarter;
                        default:
                            return true;
                    }
                });
            }

            // Client filter
            if (client) {
                filtered = filtered.filter(
                    (invoice) => invoice.clientId.toString() === client
                );
            }

            // Sort
            switch (sort) {
                case "date-desc":
                    filtered.sort(
                        (a, b) => new Date(b.issueDate) - new Date(a.issueDate)
                    );
                    break;
                case "date-asc":
                    filtered.sort(
                        (a, b) => new Date(a.issueDate) - new Date(b.issueDate)
                    );
                    break;
                case "amount-desc":
                    filtered.sort((a, b) => b.amount - a.amount);
                    break;
                case "amount-asc":
                    filtered.sort((a, b) => a.amount - b.amount);
                    break;
                default:
                    filtered.sort(
                        (a, b) => new Date(b.issueDate) - new Date(a.issueDate)
                    );
                    break;
            }

            renderMobileCards(filtered);
            renderDesktopTable(filtered);
            updateSummaryStats(filtered);
        }, 300);
    }

    function updateSummaryStats(filteredInvoices) {
        const confirmedAmount = filteredInvoices
            .filter((inv) => inv.status === "confirmed")
            .reduce((sum, invoice) => sum + invoice.amount, 0);
        const pendingAmount = filteredInvoices
            .filter((inv) => inv.status === "pending")
            .reduce((sum, invoice) => sum + invoice.amount, 0);

        const confirmedAmountEl = document.getElementById("confirmed-amount");
        const pendingAmountEl = document.getElementById("pending-amount");

        if (confirmedAmountEl) {
            animateValue(
                confirmedAmountEl,
                0,
                confirmedAmount,
                1000,
                formatCurrency
            );
        }
        if (pendingAmountEl) {
            animateValue(
                pendingAmountEl,
                0,
                pendingAmount,
                1000,
                formatCurrency
            );
        }
    }

    function animateValue(element, start, end, duration, formatter) {
        const startTime = performance.now();

        function update(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const current = start + (end - start) * progress;

            element.textContent = formatter
                ? formatter(current)
                : Math.round(current);

            if (progress < 1) {
                requestAnimationFrame(update);
            }
        }

        requestAnimationFrame(update);
    }

    // Event listeners with debouncing
    let searchTimeout;
    if (searchInput) {
        searchInput.addEventListener("input", () => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(filterInvoices, 300);
        });
    }

    if (statusFilter) statusFilter.addEventListener("change", filterInvoices);
    if (dateFilter) dateFilter.addEventListener("change", filterInvoices);
    if (clientFilter) clientFilter.addEventListener("change", filterInvoices);
    if (sortFilter) sortFilter.addEventListener("change", filterInvoices);

    // Initial render
    filterInvoices();
});

// Clean viewInvoice function
window.viewInvoice = (id) => {
    const invoice = invoices.find((inv) => inv.id === id);
    if (!invoice) return;

    const modal = document.getElementById("invoice-modal");
    const modalTitle = document.getElementById("modal-title");
    const modalContent = document.getElementById("modal-content");

    if (!modal || !modalTitle || !modalContent) return;

    modalTitle.innerHTML = `
        <div>
            <h3 class="text-xl font-semibold text-gray-900">${
                invoice.invoiceNumber
            }</h3>
            <p class="text-sm text-gray-600">${formatDate(
                invoice.issueDate
            )} • ${invoice.service}</p>
        </div>
    `;

    modalContent.innerHTML = `
        <div class="space-y-6">
            <!-- Status Banner -->
            <div class="bg-${
                invoice.status === "confirmed" ? "indigo" : "amber"
            }-50 border border-${
        invoice.status === "confirmed" ? "indigo" : "amber"
    }-200 rounded-lg p-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h4 class="text-lg font-medium text-gray-900">Payment ${
                            invoice.status === "confirmed"
                                ? "Confirmed"
                                : "Pending Payment"
                        }</h4>
                        <p class="text-sm text-gray-600">${
                            invoice.status === "confirmed"
                                ? `confirmed on ${formatDate(
                                      invoice.paymentDate
                                  )}`
                                : `Pending`
                        }</p>
                    </div>
                    <div class="text-left sm:text-right">
                        <p class="text-2xl font-semibold text-gray-900">${formatCurrency(
                            invoice.amount
                        )}</p>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium ${getStatusBadge(
                            invoice.status
                        )}">
                            ${
                                invoice.status.charAt(0).toUpperCase() +
                                invoice.status.slice(1)
                            }
                        </span>
                    </div>
                </div>
            </div>

            <!-- Client & Service Info -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-gray-50 rounded-lg p-6">
                    <div class="flex items-center space-x-4 mb-4">
                        <img src="${invoice.clientAvatar}" alt="${
        invoice.clientName
    }" 
                             class="w-12 h-12 rounded-lg object-cover">
                        <div>
                            <h4 class="text-lg font-medium text-gray-900">Client Information</h4>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm font-medium text-gray-700">Name</p>
                            <p class="text-base text-gray-900">${
                                invoice.clientName
                            }</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Email</p>
                            <p class="text-sm text-gray-900">${
                                invoice.clientEmail
                            }</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-lg p-6">
                    <div class="mb-4">
                        <h4 class="text-lg font-medium text-gray-900">Service Details</h4>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm font-medium text-gray-700">Service Type</p>
                            <p class="text-base text-gray-900">${
                                invoice.service
                            }</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Special Instruction</p>
                            <p class="text-sm text-gray-900">${
                                invoice.description
                            }</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Items -->
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                <div class="bg-gray-50 px-6 py-3 border-b border-gray-200">
                    <h4 class="text-lg font-medium text-gray-900">Invoice Items</h4>
                </div>
                <div class="divide-y divide-gray-100">
                    ${invoice.items
                        .map(
                            (item) => `
                        <div class="px-6 py-4">
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">${
                                        item.name
                                    }</p>
                                    <p class="text-xs text-gray-500 mt-1">Additional Services Price: ${
                                        item.price
                                    }</p>
                                </div>
                                <div class="text-left sm:text-right">
                                    <p class="text-base font-medium text-gray-900">${formatCurrency(
                                        item.totalAmount
                                    )}</p>
                                </div>
                            </div>
                        </div>
                    `
                        )
                        .join("")}
                </div>
            </div>

            <!-- Totals -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h4 class="text-lg font-medium text-gray-900 mb-4">Invoice Summary</h4>
                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Subtotal:</span>
                        <span class="font-medium text-gray-900">${formatCurrency(
                            invoice.subtotal
                        )}</span>
                    </div>
                    ${
                        invoice.serviceFee
                            ? `
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Service Fee:</span>
                            <span class="font-medium text-gray-900">${formatCurrency(
                                invoice.serviceFee
                            )}</span>
                        </div>
                    `
                            : ""
                    }
                    ${
                        invoice.tax
                            ? `
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Tax:</span>
                            <span class="font-medium text-gray-900">${formatCurrency(
                                invoice.tax
                            )}</span>
                        </div>
                    `
                            : ""
                    }
                    <div class="border-t border-gray-300 pt-3">
                        <div class="flex justify-between">
                            <span class="text-lg font-medium text-gray-900">Total:</span>
                            <span class="text-xl font-semibold text-indigo-600">${formatCurrency(
                                invoice.amount
                            )}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="pt-6 border-t border-gray-200 flex flex-col sm:flex-row gap-3">
                <button 
                    onclick="printInvoice(${invoice.id})"
                    class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors duration-200"
                >
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Print Invoice
                </button>
            </div>
        </div>
    `;

    modal.classList.remove("hidden");
    document.body.style.overflow = "hidden";
};

// Enhanced print function
window.printInvoice = function (id) {
    const invoice = invoices.find((inv) => inv.id === id);
    if (!invoice) {
        showToast("Invoice not found", "error");
        return;
    }

    // Create printable content
    const printableContent = `
        <div class="print-header">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 20px;">
                <div>
                    <h1 style="font-size: 24px; font-weight: bold; color: #1f2937; margin: 0;">INVOICE</h1>
                    <p style="font-size: 18px; font-weight: 600; color: #4f46e5; margin: 5px 0;">${
                        invoice.invoiceNumber
                    }</p>
                    <p style="font-size: 14px; color: #6b7280; margin: 0;">Date: ${formatDate(
                        invoice.issueDate
                    )}</p>
                </div>
                <div style="text-align: right;">
                    <div style="background: ${
                        invoice.status === "confirmed" ? "#dbeafe" : "#fef3c7"
                    }; 
                                border: 1px solid ${
                                    invoice.status === "confirmed"
                                        ? "#93c5fd"
                                        : "#fcd34d"
                                }; 
                                padding: 8px 16px; border-radius: 8px; display: inline-block;">
                        <span style="font-size: 12px; font-weight: 600; 
                                     color: ${
                                         invoice.status === "confirmed"
                                             ? "#1e40af"
                                             : "#92400e"
                                     };">
                            ${invoice.status.toUpperCase()}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="print-section">
            <h3 style="font-size: 16px; font-weight: 600; margin-bottom: 15px; color: #1f2937;">Client Information</h3>
            <div style="background: #f9fafb; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <p style="margin: 0 0 8px 0;"><strong>Name:</strong> ${
                    invoice.clientName
                }</p>
                <p style="margin: 0 0 8px 0;"><strong>Email:</strong> ${
                    invoice.clientEmail
                }</p>
                <p style="margin: 0;"><strong>Service:</strong> ${
                    invoice.service
                }</p>
            </div>
        </div>

        <div class="print-section">
            <h3 style="font-size: 16px; font-weight: 600; margin-bottom: 15px; color: #1f2937;">Special Instruction</h3>
            <p style="margin-bottom: 15px; color: #4b5563;">${
                invoice.description
            }</p>
        </div>

        <div class="print-section">
            <h3 style="font-size: 16px; font-weight: 600; margin-bottom: 15px; color: #1f2937;">Invoice Items</h3>
            <table class="print-table">
                <thead>
                    <tr>
                        <th style="width: 60%;">Description</th>
                        <th style="width: 20%; text-align: center;">Time</th>
                        <th style="width: 10%; text-align: center;">Price</th>
                        <th style="width: 10%; text-align: right;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    ${invoice.items
                        .map(
                            (item) => `
                        <tr>
                            <td>
                                <strong>${invoice.service} $(${
                                invoice.servicePrice
                            })</strong><br>
                                <small style="color: #6b7280;">Additional Services Price: ${
                                    item.price
                                }</small>
                            </td>
                            <td style="text-align: center;">${
                                invoice.time
                            } Hours</td>
                            <td style="text-center text-sm text-gray-800">${
                                invoice.servicePrice *invoice.time
                            } + ${item.price}</td>
                            <td style="text-align: right; font-weight: 600;">${formatCurrency(
                                invoice.subtotal
                            )}</td>
                        </tr>
                    `
                        )
                        .join("")}
                </tbody>
            </table>
        </div>

        <div class="print-section">
            <div style="margin-left: auto; width: 300px;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 8px 0; border-bottom: 1px solid #e5e7eb;">Subtotal:</td>
                        <td style="padding: 8px 0; border-bottom: 1px solid #e5e7eb; text-align: right; font-weight: 600;">
                            ${formatCurrency(invoice.subtotal)}
                        </td>
                    </tr>
                    ${
                        invoice.serviceFee
                            ? `
                        <tr>
                            <td style="padding: 8px 0; border-bottom: 1px solid #e5e7eb;">Service Fee:</td>
                            <td style="padding: 8px 0; border-bottom: 1px solid #e5e7eb; text-align: right; font-weight: 600;">
                                ${formatCurrency(invoice.serviceFee)}
                            </td>
                        </tr>
                    `
                            : ""
                    }
                    ${
                        invoice.tax
                            ? `
                        <tr>
                            <td style="padding: 8px 0; border-bottom: 1px solid #e5e7eb;">Tax:</td>
                            <td style="padding: 8px 0; border-bottom: 1px solid #e5e7eb; text-align: right; font-weight: 600;">
                                ${formatCurrency(invoice.tax)}
                            </td>
                        </tr>
                    `
                            : ""
                    }
                    <tr class="print-total">
                        <td style="padding: 15px; font-size: 18px; font-weight: bold;">Total:</td>
                        <td style="padding: 15px; font-size: 20px; font-weight: bold; text-align: right; color: #4f46e5;">
                            ${formatCurrency(invoice.amount)}
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="print-section" style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
            <p style="text-align: center; color: #6b7280; font-size: 12px; margin: 0;">
                Thank you for your business! This invoice was generated on ${formatDate(
                    new Date()
                )}.
            </p>
        </div>
    `;

    // Insert content into printable div
    const printableDiv = document.getElementById("printable-invoice");
    if (printableDiv) {
        printableDiv.innerHTML = printableContent;
    }

    // Trigger print
    setTimeout(() => {
        window.print();
        showToast("Printing invoice...", "success");
    }, 100);
};

// Close modal function
window.closeInvoiceModal = function () {
    const modal = document.getElementById("invoice-modal");
    if (modal) {
        modal.classList.add("hidden");
        document.body.style.overflow = "";
    }
};
// Helper function for toast notifications

function showToast(message, type = "info") {
    const toast = document.createElement("div");
    const bgColor =
        type === "success"
            ? "bg-indigo-600"
            : type === "error"
            ? "bg-red-600"
            : "bg-blue-600";

    toast.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg text-white text-sm font-medium transition-all duration-300 transform translate-x-full ${bgColor}`;
    toast.textContent = message;

    document.body.appendChild(toast);

    setTimeout(() => toast.classList.remove("translate-x-full"), 100);
    setTimeout(() => {
        toast.classList.add("translate-x-full");
        setTimeout(
            () =>
                document.body.contains(toast) &&
                document.body.removeChild(toast),
            300
        );
    }, 3000);
}

function formatDate(dateString) {
    if (!dateString) return "N/A";
    return new Date(dateString).toLocaleDateString("en-US", {
        year: "numeric",
        month: "short",
        day: "numeric",
    });
}

function formatCurrency(amount) {
    return new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "USD",
        minimumFractionDigits: 2,
    }).format(amount);
}

function getPriorityBadge(priority) {
    const badges = {
        urgent: "bg-red-100 text-red-800",
        high: "bg-orange-100 text-orange-800",
        normal: "bg-blue-100 text-blue-800",
    };
    return badges[priority] || "bg-gray-100 text-gray-800";
}

function getStatusBadge(status) {
    const badges = {
        confirmed: "bg-indigo-100 text-indigo-800",
        pending: "bg-amber-100 text-amber-800",
    };
    return badges[status] || "bg-gray-100 text-gray-800";
}
