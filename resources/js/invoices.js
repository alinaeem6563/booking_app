
const invoices = [
    {
        id: 1,
        invoiceNumber: "INV-2024-001",
        clientId: 1,
        clientName: "Jennifer Wilson",
        clientEmail: "jennifer.wilson@email.com",
        issueDate: "2024-01-15",
        dueDate: "2024-01-30",
        amount: 198.63,
        status: "paid",
        paymentDate: "2024-01-15",
        service: "Deep Cleaning Service",
        description: "Complete deep cleaning of 2-bedroom apartment including kitchen and bathrooms",
        items: [
            {
                description: "Deep Cleaning Service",
                quantity: 3,
                rate: 50,
                amount: 150
            },
            {
                description: "Cleaning Supplies",
                quantity: 1,
                rate: 15,
                amount: 15
            },
            {
                description: "Travel Fee",
                quantity: 1,
                rate: 10,
                amount: 10
            }
        ],
        subtotal: 175,
        platformFee: 8.75,
        tax: 14.88,
        total: 198.63
    },
    {
        id: 2,
        invoiceNumber: "INV-2024-002",
        clientId: 2,
        clientName: "Michael Roberts",
        clientEmail: "michael.roberts@email.com",
        issueDate: "2024-01-14",
        dueDate: "2024-01-28",
        amount: 216.00,
        status: "paid",
        paymentDate: "2024-01-14",
        service: "Pipe Repair",
        description: "Emergency repair of kitchen sink pipe leak",
        items: [
            {
                description: "Pipe Repair Service",
                quantity: 2,
                rate: 75,
                amount: 150
            },
            {
                description: "Replacement Parts",
                quantity: 1,
                rate: 35,
                amount: 35
            },
            {
                description: "Emergency Fee",
                quantity: 1,
                rate: 15,
                amount: 15
            }
        ],
        subtotal: 200,
        platformFee: 10,
        tax: 6,
        total: 216
    },
    {
        id: 3,
        invoiceNumber: "INV-2024-003",
        clientId: 3,
        clientName: "Sarah Davis",
        clientEmail: "sarah.davis@email.com",
        issueDate: "2024-01-13",
        dueDate: "2024-01-27",
        amount: 86.40,
        status: "pending",
        paymentDate: null,
        service: "Regular Cleaning",
        description: "Weekly cleaning service for small apartment",
        items: [
            {
                description: "Regular Cleaning Service",
                quantity: 2,
                rate: 40,
                amount: 80
            }
        ],
        subtotal: 80,
        platformFee: 4,
        tax: 2.40,
        total: 86.40
    },
    {
        id: 4,
        invoiceNumber: "INV-2024-004",
        clientId: 4,
        clientName: "David Johnson",
        clientEmail: "david.johnson@email.com",
        issueDate: "2024-01-12",
        dueDate: "2024-01-26",
        amount: 270.00,
        status: "paid",
        paymentDate: "2024-01-14",
        service: "Move-out Cleaning",
        description: "Complete move-out cleaning for 3-bedroom house",
        items: [
            {
                description: "Move-out Cleaning Service",
                quantity: 5,
                rate: 50,
                amount: 250
            }
        ],
        subtotal: 250,
        platformFee: 12.50,
        tax: 7.50,
        total: 270
    },
    {
        id: 5,
        invoiceNumber: "INV-2024-005",
        clientId: 1,
        clientName: "Jennifer Wilson",
        clientEmail: "jennifer.wilson@email.com",
        issueDate: "2024-01-11",
        dueDate: "2024-01-25",
        amount: 189.00,
        status: "overdue",
        paymentDate: null,
        service: "Deep Cleaning",
        description: "Deep cleaning of kitchen and bathrooms",
        items: [
            {
                description: "Deep Cleaning Service",
                quantity: 3.5,
                rate: 50,
                amount: 175
            }
        ],
        subtotal: 175,
        platformFee: 8.75,
        tax: 5.25,
        total: 189
    },
    {
        id: 6,
        invoiceNumber: "INV-2024-006",
        clientId: 2,
        clientName: "Michael Roberts",
        clientEmail: "michael.roberts@email.com",
        issueDate: "2024-01-10",
        dueDate: "2024-01-24",
        amount: 108.00,
        status: "overdue",
        paymentDate: null,
        service: "Faucet Installation",
        description: "Installation of new kitchen faucet",
        items: [
            {
                description: "Faucet Installation",
                quantity: 1,
                rate: 100,
                amount: 100
            }
        ],
        subtotal: 100,
        platformFee: 5,
        tax: 3,
        total: 108
    },
    {
        id: 7,
        invoiceNumber: "INV-2024-007",
        clientId: 3,
        clientName: "Sarah Davis",
        clientEmail: "sarah.davis@email.com",
        issueDate: "2024-01-09",
        dueDate: "2024-01-23",
        amount: 86.40,
        status: "paid",
        paymentDate: "2024-01-09",
        service: "Regular Cleaning",
        description: "Weekly cleaning service for small apartment",
        items: [
            {
                description: "Regular Cleaning Service",
                quantity: 2,
                rate: 40,
                amount: 80
            }
        ],
        subtotal: 80,
        platformFee: 4,
        tax: 2.40,
        total: 86.40
    },
    {
        id: 8,
        invoiceNumber: "INV-2024-008",
        clientId: 4,
        clientName: "David Johnson",
        clientEmail: "david.johnson@email.com",
        issueDate: "2024-01-08",
        dueDate: "2024-01-22",
        amount: 162.00,
        status: "paid",
        paymentDate: "2024-01-10",
        service: "Window Cleaning",
        description: "Cleaning of all windows in 2-story house",
        items: [
            {
                description: "Window Cleaning Service",
                quantity: 3,
                rate: 50,
                amount: 150
            }
        ],
        subtotal: 150,
        platformFee: 7.50,
        tax: 4.50,
        total: 162
    },
    {
        id: 9,
        invoiceNumber: "INV-2024-009",
        clientId: 1,
        clientName: "Jennifer Wilson",
        clientEmail: "jennifer.wilson@email.com",
        issueDate: "2024-01-07",
        dueDate: "2024-01-21",
        amount: 432.00,
        status: "pending",
        paymentDate: null,
        service: "Deep Cleaning + Carpet Cleaning",
        description: "Complete deep cleaning with carpet cleaning for entire house",
        items: [
            {
                description: "Deep Cleaning Service",
                quantity: 5,
                rate: 50,
                amount: 250
            },
            {
                description: "Carpet Cleaning",
                quantity: 3,
                rate: 60,
                amount: 180
            }
        ],
        subtotal: 430,
        platformFee: 21.50,
        tax: 12.90,
        total: 464.40
    },
    {
        id: 10,
        invoiceNumber: "INV-2024-010",
        clientId: 2,
        clientName: "Michael Roberts",
        clientEmail: "michael.roberts@email.com",
        issueDate: "2024-01-06",
        dueDate: "2024-01-20",
        amount: 918.00,
        status: "draft",
        paymentDate: null,
        service: "Bathroom Remodel",
        description: "Partial bathroom remodel including new sink and toilet installation",
        items: [
            {
                description: "Bathroom Remodel Labor",
                quantity: 8,
                rate: 85,
                amount: 680
            },
            {
                description: "Materials",
                quantity: 1,
                rate: 170,
                amount: 170
            }
        ],
        subtotal: 850,
        platformFee: 42.50,
        tax: 25.50,
        total: 918
    }
];

document.addEventListener('DOMContentLoaded', function() {
    const invoicesTbody = document.getElementById('invoices-tbody');
    const searchInput = document.getElementById('search-invoices');
    const statusFilter = document.getElementById('status-filter');
    const dateFilter = document.getElementById('date-filter');
    const clientFilter = document.getElementById('client-filter');
    const sortFilter = document.getElementById('sort-filter');

    function getStatusBadge(status) {
        const badges = {
            paid: 'bg-green-100 text-green-800',
            pending: 'bg-yellow-100 text-yellow-800',
            overdue: 'bg-red-100 text-red-800',
            draft: 'bg-blue-100 text-blue-800'
        };
        return badges[status] || 'bg-gray-100 text-gray-800';
    }

    function formatDate(dateString) {
        if (!dateString) return 'N/A';
        return new Date(dateString).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });
    }

    function formatCurrency(amount) {
        return new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
            minimumFractionDigits: 2
        }).format(amount);
    }

    function renderInvoices(invoices) {
        invoicesTbody.innerHTML = invoices.map(invoice => `
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="text-sm font-medium text-gray-900">
                            ${invoice.invoiceNumber}
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">${invoice.clientName}</div>
                    <div class="text-sm text-gray-500">${invoice.clientEmail}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">${formatDate(invoice.issueDate)}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">${formatDate(invoice.dueDate)}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">${formatCurrency(invoice.amount)}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${getStatusBadge(invoice.status)}">
                        ${invoice.status.charAt(0).toUpperCase() + invoice.status.slice(1)}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <div class="flex justify-end space-x-3">
                        <button onclick="viewInvoice(${invoice.id})" class="text-purple-600 hover:text-purple-900">
                            View
                        </button>
                        ${invoice.status !== 'paid' ? `
                            <button onclick="editInvoice(${invoice.id})" class="text-blue-600 hover:text-blue-900">
                                Edit
                            </button>
                        ` : ''}
                        <button onclick="duplicateInvoice(${invoice.id})" class="text-gray-600 hover:text-gray-900">
                            Duplicate
                        </button>
                    </div>
                </td>
            </tr>
        `).join('');
    }

    function filterInvoices() {
        let filtered = [...invoices];
        
        const searchTerm = searchInput.value.toLowerCase();
        const status = statusFilter.value;
        const date = dateFilter.value;
        const client = clientFilter.value;
        const sort = sortFilter.value;

        if (searchTerm) {
            filtered = filtered.filter(invoice => 
                invoice.invoiceNumber.toLowerCase().includes(searchTerm) ||
                invoice.clientName.toLowerCase().includes(searchTerm) ||
                invoice.service.toLowerCase().includes(searchTerm)
            );
        }

        if (status) {
            filtered = filtered.filter(invoice => invoice.status === status);
        }

        if (date) {
            const now = new Date();
            const startOfMonth = new Date(now.getFullYear(), now.getMonth(), 1);
            const startOfLastMonth = new Date(now.getFullYear(), now.getMonth() - 1, 1);
            const startOfQuarter = new Date(now.getFullYear(), Math.floor(now.getMonth() / 3) * 3, 1);
            const startOfYear = new Date(now.getFullYear(), 0, 1);
            
            filtered = filtered.filter(invoice => {
                const invoiceDate = new Date(invoice.issueDate);
                switch (date) {
                    case 'this-month':
                        return invoiceDate >= startOfMonth;
                    case 'last-month':
                        return invoiceDate >= startOfLastMonth && invoiceDate < startOfMonth;
                    case 'this-quarter':
                        return invoiceDate >= startOfQuarter;
                    case 'this-year':
                        return invoiceDate >= startOfYear;
                    default:
                        return true;
                }
            });
        }

        if (client) {
            filtered = filtered.filter(invoice => invoice.clientId.toString() === client);
        }

        // Sort
        switch (sort) {
            case 'date-desc':
                filtered.sort((a, b) => new Date(b.issueDate) - new Date(a.issueDate));
                break;
            case 'date-asc':
                filtered.sort((a, b) => new Date(a.issueDate) - new Date(b.issueDate));
                break;
            case 'amount-desc':
                filtered.sort((a, b) => b.amount - a.amount);
                break;
            case 'amount-asc':
                filtered.sort((a, b) => a.amount - b.amount);
                break;
            default:
                filtered.sort((a, b) => new Date(b.issueDate) - new Date(a.issueDate));
                break;
        }

        renderInvoices(filtered);
    }

    // Event listeners
    searchInput.addEventListener('input', filterInvoices);
    statusFilter.addEventListener('change', filterInvoices);
    dateFilter.addEventListener('change', filterInvoices);
    clientFilter.addEventListener('change', filterInvoices);
    sortFilter.addEventListener('change', filterInvoices);

    // Initial render
    renderInvoices(invoices);
});

function viewInvoice(id) {
    const invoice = invoices.find(inv => inv.id === id);
    if (!invoice) return;

    const modal = document.getElementById('invoice-modal');
    const modalTitle = document.getElementById('modal-title');
    const modalContent = document.getElementById('modal-content');

    modalTitle.textContent = `Invoice ${invoice.invoiceNumber}`;
    
    modalContent.innerHTML = `
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mb-3">Invoice Details</h4>
                <div class="text-sm">
                    <p><span class="font-medium text-gray-700">Issue Date:</span> ${formatDate(invoice.issueDate)}</p>
                    <p><span class="font-medium text-gray-700">Due Date:</span> ${formatDate(invoice.dueDate)}</p>
                    <p><span class="font-medium text-gray-700">Status:</span> 
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${getStatusBadge(invoice.status)}">
                            ${invoice.status.charAt(0).toUpperCase() + invoice.status.slice(1)}
                        </span>
                    </p>
                    ${invoice.paymentDate ? `<p><span class="font-medium text-gray-700">Payment Date:</span> ${formatDate(invoice.paymentDate)}</p>` : ''}
                </div>
            </div>
            <div>
                <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mb-3">Client Information</h4>
                <div class="text-sm">
                    <p class="font-medium text-gray-900">${invoice.clientName}</p>
                    <p>${invoice.clientEmail}</p>
                </div>
            </div>
        </div>

        <div class="mb-6">
            <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mb-3">Service Information</h4>
            <div class="text-sm">
                <p><span class="font-medium text-gray-700">Service:</span> ${invoice.service}</p>
                <p><span class="font-medium text-gray-700">Description:</span> ${invoice.description}</p>
            </div>
        </div>

        <div class="mb-6">
            <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mb-3">Invoice Items</h4>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="bg-gray-50">
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Rate</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        ${invoice.items.map(item => `
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${item.description}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">${item.quantity}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">${formatCurrency(item.rate)}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">${formatCurrency(item.amount)}</td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex justify-end">
            <div class="w-64">
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal:</span>
                        <span class="text-gray-900">${formatCurrency(invoice.subtotal)}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Platform Fee (5%):</span>
                        <span class="text-gray-900">${formatCurrency(invoice.platformFee)}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tax:</span>
                        <span class="text-gray-900">${formatCurrency(invoice.tax)}</span>
                    </div>
                    <div class="border-t border-gray-200 pt-2">
                        <div class="flex justify-between">
                            <span class="text-base font-semibold text-gray-900">Total:</span>
                            <span class="text-base font-semibold text-gray-900">${formatCurrency(invoice.total)}</span>
                        </div>
                    </div>
                    ${invoice.status === 'paid' ? `
                        <div class="flex justify-between text-green-600">
                            <span class="font-medium">Amount Paid:</span>
                            <span class="font-medium">${formatCurrency(invoice.total)}</span>
                        </div>
                    ` : ''}
                </div>
            </div>
        </div>
    `;

    modal.classList.remove('hidden');
}

function closeInvoiceModal() {
    document.getElementById('invoice-modal').classList.add('hidden');
}

function formatDate(dateString) {
    if (!dateString) return 'N/A';
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}

function formatCurrency(amount) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 2
    }).format(amount);
}

function getStatusBadge(status) {
    const badges = {
        paid: 'bg-green-100 text-green-800',
        pending: 'bg-yellow-100 text-yellow-800',
        overdue: 'bg-red-100 text-red-800',
        draft: 'bg-blue-100 text-blue-800'
    };
    return badges[status] || 'bg-gray-100 text-gray-800';
}

function editInvoice(id) {
    alert('Edit invoice functionality would be implemented here');
}

function duplicateInvoice(id) {
    alert('Duplicate invoice functionality would be implemented here');
}

function printInvoice() {
    window.open('/provider/print-receipt?print=true', '_blank');
}

function downloadInvoice() {
    alert('Download invoice functionality would be implemented here');
}
