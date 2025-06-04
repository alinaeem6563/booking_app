
    // Sample invoice data - in real app, this would come from the server
    const invoiceData = {
        id: 1,
        invoiceNumber: "INV-2024-001",
        issueDate: "2024-01-15",
        dueDate: "2024-01-30",
        paymentDate: "2024-01-15",
        status: "paid",
        provider: {
            name: "Sarah Johnson",
            title: "Professional Cleaner",
            email: "sarah.johnson@email.com",
            phone: "(555) 987-6543",
            avatar: "https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150"
        },
        client: {
            name: "Jennifer Wilson",
            email: "jennifer.wilson@email.com",
            phone: "(555) 123-4567",
            address: "123 Main Street\nDowntown, City 12345"
        },
        service: {
            type: "Deep Cleaning Service",
            date: "2024-01-15",
            duration: "3 hours",
            description: "Complete deep cleaning of 2-bedroom apartment including kitchen and bathrooms. Focus on detailed cleaning of all surfaces, appliances, and fixtures."
        },
        items: [{
                description: "Deep Cleaning Service",
                quantity: 3,
                rate: 50.00,
                amount: 150.00
            },
            {
                description: "Cleaning Supplies",
                quantity: 1,
                rate: 15.00,
                amount: 15.00
            },
            {
                description: "Travel Fee",
                quantity: 1,
                rate: 10.00,
                amount: 10.00
            }
        ],
        subtotal: 175.00,
        platformFee: 8.75,
        tax: 14.88,
        total: 198.63,
        payment: {
            method: "Visa ****1234",
            transactionId: "txn_1234567890",
            authCode: "AUTH123456"
        },
        notes: "Service completed successfully. Client was very satisfied with the quality of work. All areas were cleaned thoroughly as requested. Thank you for choosing our services!"
    };

    document.addEventListener('DOMContentLoaded', function() {
        loadInvoiceData();
    });

    function loadInvoiceData() {
        // Update invoice header
        document.getElementById('invoice-number').textContent = invoiceData.invoiceNumber;
        document.getElementById('invoice-num').textContent = invoiceData.invoiceNumber;
        document.getElementById('issue-date').textContent = formatDate(invoiceData.issueDate);
        document.getElementById('due-date').textContent = formatDate(invoiceData.dueDate);

        // Update status badge
        const statusBadge = document.getElementById('invoice-status-badge');
        statusBadge.textContent = invoiceData.status.charAt(0).toUpperCase() + invoiceData.status.slice(1);
        statusBadge.className = `inline-flex items-center px-3 py-1 rounded-full text-sm font-medium ${getStatusBadge(invoiceData.status)}`;

        // Update payment date if paid
        if (invoiceData.paymentDate && invoiceData.status === 'paid') {
            document.getElementById('payment-date-row').classList.remove('hidden');
            document.getElementById('payment-date').textContent = formatDate(invoiceData.paymentDate);
        }

        // Update provider info
        document.getElementById('provider-name').textContent = invoiceData.provider.name;
        document.getElementById('provider-title').textContent = invoiceData.provider.title;
        document.getElementById('provider-email').textContent = invoiceData.provider.email;
        document.getElementById('provider-phone').textContent = invoiceData.provider.phone;
        document.getElementById('provider-avatar').src = invoiceData.provider.avatar;

        // Update client info
        document.getElementById('client-name').textContent = invoiceData.client.name;
        document.getElementById('client-email').textContent = invoiceData.client.email;
        document.getElementById('client-phone').textContent = invoiceData.client.phone;
        document.getElementById('client-address').innerHTML = invoiceData.client.address.replace(/\n/g, '<br>');

        // Update service info
        document.getElementById('service-type').textContent = invoiceData.service.type;
        document.getElementById('service-date').textContent = formatDate(invoiceData.service.date);
        document.getElementById('service-duration').textContent = invoiceData.service.duration;
        document.getElementById('service-description').textContent = invoiceData.service.description;

        // Update invoice items
        const itemsContainer = document.getElementById('invoice-items');
        itemsContainer.innerHTML = invoiceData.items.map(item => `
        <tr class="border-b border-gray-100">
            <td class="py-4 text-sm text-gray-900">
                <div class="font-medium">${item.description}</div>
            </td>
            <td class="py-4 text-sm text-gray-900 text-center">${item.quantity}</td>
            <td class="py-4 text-sm text-gray-900 text-right">${formatCurrency(item.rate)}</td>
            <td class="py-4 text-sm text-gray-900 text-right font-medium">${formatCurrency(item.amount)}</td>
        </tr>
    `).join('');

        // Update totals
        document.getElementById('subtotal').textContent = formatCurrency(invoiceData.subtotal);
        document.getElementById('platform-fee').textContent = formatCurrency(invoiceData.platformFee);
        document.getElementById('tax').textContent = formatCurrency(invoiceData.tax);
        document.getElementById('total').textContent = formatCurrency(invoiceData.total);

        // Update payment status
        if (invoiceData.status === 'paid') {
            document.getElementById('amount-paid').textContent = formatCurrency(invoiceData.total);
            document.getElementById('amount-paid-row').classList.remove('hidden');
            document.getElementById('amount-due-row').classList.add('hidden');
        } else {
            document.getElementById('amount-due').textContent = formatCurrency(invoiceData.total);
            document.getElementById('amount-due-row').classList.remove('hidden');
            document.getElementById('amount-paid-row').classList.add('hidden');
        }

        // Update payment info
        if (invoiceData.status === 'paid') {
            document.getElementById('payment-method').textContent = invoiceData.payment.method;
            document.getElementById('transaction-id').textContent = invoiceData.payment.transactionId;
            document.getElementById('auth-code').textContent = invoiceData.payment.authCode;
        } else {
            document.getElementById('payment-info').innerHTML = '<p class="text-gray-500 italic">Payment pending</p>';
        }

        // Update notes
        document.getElementById('notes').textContent = invoiceData.notes;
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

    function formatDate(dateString) {
        return new Date(dateString).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
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

    function sendInvoice() {
        document.getElementById('send-modal').classList.remove('hidden');
    }

    function closeSendModal() {
        document.getElementById('send-modal').classList.add('hidden');
    }

    function duplicateInvoice() {
        if (confirm('Create a duplicate of this invoice?')) {
            alert('Duplicate invoice functionality would be implemented here');
        }
    }

    function editInvoice() {
        window.location.href = `/provider/invoices/${invoiceData.id}/edit`;
    }

    function downloadPDF() {
        // This would integrate with a PDF generation service
        alert('PDF download functionality would be implemented here');
    }

    // Send form submission
    document.getElementById('send-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const email = document.getElementById('send-email').value;
        const subject = document.getElementById('send-subject').value;
        const message = document.getElementById('send-message').value;

        // Here you would send the invoice via email
        alert(`Invoice sent successfully to ${email}!`);
        closeSendModal();
    });

    // Auto-focus print dialog when page loads if print parameter is present
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('print') === 'true') {
        setTimeout(() => {
            window.print();
        }, 500);
    }
