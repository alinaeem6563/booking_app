
const paymentMethods = [
    {
        id: 1,
        type: 'bank',
        name: 'Chase Bank ****1234',
        isDefault: true,
        status: 'verified',
        addedDate: '2024-01-10'
    },
    {
        id: 2,
        type: 'paypal',
        name: 'john.doe@email.com',
        isDefault: false,
        status: 'verified',
        addedDate: '2024-01-05'
    },
    {
        id: 3,
        type: 'stripe',
        name: 'Stripe Connect',
        isDefault: false,
        status: 'pending',
        addedDate: '2024-01-15'
    }
];

document.addEventListener('DOMContentLoaded', function() {
    const paymentMethodsList = document.getElementById('payment-methods-list');
    const paymentTypeSelect = document.getElementById('payment-type');
    const bankFields = document.getElementById('bank-fields');
    const paypalFields = document.getElementById('paypal-fields');

    function getPaymentIcon(type) {
        const icons = {
            bank: `<svg class="h-6 w-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
            </svg>`,
            paypal: `<svg class="h-6 w-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                <path d="M7.076 21.337H2.47a.641.641 0 0 1-.633-.74L4.944.901C5.026.382 5.474 0 5.998 0h7.46c2.57 0 4.578.543 5.69 1.81 1.01 1.15 1.304 2.42 1.012 4.287-.023.143-.047.288-.077.437-.983 5.05-4.349 6.797-8.647 6.797h-2.19c-.524 0-.968.382-1.05.9l-1.12 7.106zm14.146-14.42a3.35 3.35 0 0 0-.607-.541c-.013.076-.026.175-.041.26-.93 4.778-4.005 7.201-9.138 7.201h-2.19a.563.563 0 0 0-.556.479l-1.187 7.527h-.506l1.12-7.106c.082-.518.526-.9 1.05-.9h2.19c4.298 0 7.664-1.747 8.647-6.797.03-.149.054-.294.077-.437.291-1.867-.002-3.137-1.012-4.287z"/>
            </svg>`,
            stripe: `<svg class="h-6 w-6 text-purple-500" fill="currentColor" viewBox="0 0 24 24">
                <path d="M13.976 9.15c-2.172-.806-3.356-1.426-3.356-2.409 0-.831.683-1.305 1.901-1.305 2.227 0 4.515.858 6.09 1.631l.89-5.494C18.252.975 15.697 0 12.165 0 9.667 0 7.589.654 6.104 1.872 4.56 3.147 3.757 4.992 3.757 7.218c0 4.039 2.467 5.76 6.476 7.219 2.585.92 3.445 1.574 3.445 2.583 0 .98-.84 1.545-2.354 1.545-1.875 0-4.965-.921-6.99-2.109l-.9 5.555C5.175 22.99 8.385 24 11.714 24c2.641 0 4.843-.624 6.328-1.813 1.664-1.305 2.525-3.236 2.525-5.732 0-4.128-2.524-5.851-6.591-7.305z"/>
            </svg>`
        };
        return icons[type] || '';
    }

    function getStatusBadge(status) {
        const badges = {
            verified: 'bg-green-100 text-green-800',
            pending: 'bg-yellow-100 text-yellow-800',
            failed: 'bg-red-100 text-red-800'
        };
        return badges[status] || 'bg-gray-100 text-gray-800';
    }

    function renderPaymentMethods() {
        paymentMethodsList.innerHTML = paymentMethods.map(method => `
            <div class="p-6 flex items-center justify-between">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        ${getPaymentIcon(method.type)}
                    </div>
                    <div class="ml-4">
                        <h4 class="text-sm font-medium text-gray-900">${method.name}</h4>
                        <div class="flex items-center mt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${getStatusBadge(method.status)}">
                                ${method.status.charAt(0).toUpperCase() + method.status.slice(1)}
                            </span>
                            ${method.isDefault ? '<span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Default</span>' : ''}
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    ${!method.isDefault ? `<button onclick="setDefault(${method.id})" class="text-sm text-purple-600 hover:text-purple-900">Set as Default</button>` : ''}
                    <button onclick="editPaymentMethod(${method.id})" class="text-sm text-gray-600 hover:text-gray-900">Edit</button>
                    <button onclick="removePaymentMethod(${method.id})" class="text-sm text-red-600 hover:text-red-900">Remove</button>
                </div>
            </div>
        `).join('');
    }

    // Payment type change handler
    paymentTypeSelect.addEventListener('change', function() {
        const selectedType = this.value;
        
        // Hide all fields first
        bankFields.classList.add('hidden');
        paypalFields.classList.add('hidden');
        
        // Show relevant fields
        if (selectedType === 'bank') {
            bankFields.classList.remove('hidden');
        } else if (selectedType === 'paypal') {
            paypalFields.classList.remove('hidden');
        }
    });

    // Initial render
    renderPaymentMethods();
});

function addPaymentMethod() {
    document.getElementById('payment-modal').classList.remove('hidden');
}

function closePaymentModal() {
    document.getElementById('payment-modal').classList.add('hidden');
    document.getElementById('payment-form').reset();
}

function setDefault(id) {
    // Update default status
    paymentMethods.forEach(method => {
        method.isDefault = method.id === id;
    });
    
    // Re-render
    document.getElementById('payment-methods-list').innerHTML = '';
    document.dispatchEvent(new Event('DOMContentLoaded'));
    
    alert('Default payment method updated successfully!');
}

function editPaymentMethod(id) {
    alert('Edit payment method functionality would be implemented here');
}

function removePaymentMethod(id) {
    if (confirm('Are you sure you want to remove this payment method?')) {
        const index = paymentMethods.findIndex(method => method.id === id);
        if (index > -1) {
            paymentMethods.splice(index, 1);
            document.getElementById('payment-methods-list').innerHTML = '';
            document.dispatchEvent(new Event('DOMContentLoaded'));
        }
    }
}

// Form submission
document.getElementById('payment-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Add new payment method logic here
    alert('Payment method added successfully!');
    closePaymentModal();
});
