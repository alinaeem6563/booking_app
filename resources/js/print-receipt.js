
function downloadPDF() {
    // This would integrate with a PDF generation library
    alert('PDF download functionality would be implemented here using libraries like jsPDF or server-side PDF generation');
}

function emailReceipt() {
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full';
    modal.innerHTML = `
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Email Receipt</h3>
                <form id="email-form" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" value="jennifer.wilson@email.com" class="w-full rounded-md border-gray-300 focus:ring-purple-500 focus:border-purple-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                        <input type="text" value="Receipt for Deep Cleaning Service - INV-2024-001" class="w-full rounded-md border-gray-300 focus:ring-purple-500 focus:border-purple-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Message (Optional)</label>
                        <textarea rows="3" class="w-full rounded-md border-gray-300 focus:ring-purple-500 focus:border-purple-500" placeholder="Add a personal message..."></textarea>
                    </div>
                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" onclick="this.closest('.fixed').remove()" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-md text-sm font-medium hover:bg-purple-700">
                            Send Email
                        </button>
                    </div>
                </form>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    
    modal.querySelector('#email-form').addEventListener('submit', function(e) {
        e.preventDefault();
        alert('Receipt emailed successfully!');
        modal.remove();
    });
}

// Auto-focus print dialog when page loads if print parameter is present
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('print') === 'true') {
        setTimeout(() => {
            window.print();
        }, 500);
    }
});
