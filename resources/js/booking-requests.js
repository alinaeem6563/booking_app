document.addEventListener("DOMContentLoaded", () => {
    const requestsContainer = document.getElementById("requests-container");
    const emptyState = document.getElementById("empty-state");
    const statusFilter = document.getElementById("status-filter");
    const serviceFilter = document.getElementById("service-filter");
    const dateFilter = document.getElementById("date-filter");

    // Enhanced status badge styling with animations and better mobile support
    function getStatusBadge(status) {
        const badges = {
            pending:
                "bg-gradient-to-r from-amber-50 to-yellow-50 text-amber-800 border border-amber-200 shadow-sm",
            confirmed:
                "bg-gradient-to-r from-emerald-50 to-green-50 text-emerald-800 border border-emerald-200 shadow-sm",
            canceled:
                "bg-gradient-to-r from-rose-50 to-red-50 text-rose-800 border border-rose-200 shadow-sm",
            completed:
                "bg-gradient-to-r from-indigo-50 to-indigo-50 text-indigo-800 border border-indigo-200 shadow-sm",
        };
        return (
            badges[status] ||
            "bg-gradient-to-r from-gray-50 to-slate-50 text-gray-800 border border-gray-200 shadow-sm"
        );
    }

    // Enhanced date formatting with better readability
    function formatDate(dateString) {
        const options = {
            year: "numeric",
            month: "short",
            day: "numeric",
            hour: "2-digit",
            minute: "2-digit",
        };

        try {
            const date = new Date(dateString);
            return date.toLocaleDateString("en-US", options);
        } catch (e) {
            console.error("Date formatting error:", e);
            return dateString;
        }
    }

    // Get appropriate icon for service type with enhanced icons
    function getServiceIcon(service) {
        const serviceIcons = {
            cleaning: `<svg class="w-4 h-4 sm:w-5 sm:h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>`,
            repair: `<svg class="w-4 h-4 sm:w-5 sm:h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                      </svg>`,
            plumbing: `<svg class="w-4 h-4 sm:w-5 sm:h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                        </svg>`,
            electrical: `<svg class="w-4 h-4 sm:w-5 sm:h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                          </svg>`,
            default: `<svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                       </svg>`,
        };

        const normalizedService = (service || "")
            .toLowerCase()
            .replace(/\s+/g, "");

        for (const [key, icon] of Object.entries(serviceIcons)) {
            if (normalizedService.includes(key)) {
                return icon;
            }
        }

        return serviceIcons.default;
    }

    // Enhanced rendering with modern UI components and better mobile responsiveness
    function renderRequests(requests) {
        if (requests.length === 0) {
            requestsContainer.classList.add("hidden");
            emptyState.classList.remove("hidden");
            return;
        }

        requestsContainer.classList.remove("hidden");
        emptyState.classList.add("hidden");

        requestsContainer.innerHTML = requests
            .map(
                (request) => `
                  <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-4 sm:mb-6 transform transition-all duration-300 hover:shadow-xl hover:-translate-y-1 hover:border-gray-200">
                      <!-- Mobile-first header design -->
                      <div class="p-4 sm:p-6">
                          <!-- Client info section - optimized for mobile -->
                          <div class="flex flex-col space-y-4 sm:space-y-0 sm:flex-row sm:items-center sm:justify-between mb-4 sm:mb-6 pb-4 border-b border-gray-100">
                              <div class="flex items-center space-x-3 sm:space-x-4">
                                  <div class="relative flex-shrink-0">
                                      <img class="h-12 w-12 sm:h-14 sm:w-14 rounded-full object-cover border-2 border-white shadow-md" 
                                          src="${
                                              request.clientImage ||
                                              "/placeholder.svg?height=56&width=56"
                                          }" 
                                          alt="${request.clientName}"
                                          onerror="this.onerror=null; this.src='/placeholder.svg?height=56&width=56';">
                                      <div class="absolute -bottom-1 -right-1 h-4 w-4 sm:h-5 sm:w-5 rounded-full bg-emerald-500 border-2 border-white shadow-sm"></div>
                                  </div>
                                  <div class="min-w-0 flex-1">
                                      <h3 class="text-base sm:text-lg font-semibold text-gray-900 truncate">${
                                          request.clientName
                                      }</h3>
                                      <div class="flex items-center text-xs sm:text-sm text-gray-500 mt-1">
                                          <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                          </svg>
                                          <span class="truncate">Requested ${formatDate(
                                              request.requestDate || new Date()
                                          )}</span>
                                      </div>
                                  </div>
                              </div>
                              
                              <!-- Status badges - stacked on mobile, inline on desktop -->
                              <div class="flex flex-wrap gap-2 sm:gap-3">
                                  <span class="inline-flex items-center px-2.5 py-1 sm:px-3 sm:py-1.5 rounded-full text-xs font-medium ${getStatusBadge(
                                      request.status
                                  )} transition-all duration-200">
                                      <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full ${
                                          request.status === "pending"
                                              ? "bg-amber-500"
                                              : request.status === "confirmed"
                                              ? "bg-emerald-500"
                                              : request.status === "canceled"
                                              ? "bg-rose-500"
                                              : "bg-indigo-500"
                                      } mr-1.5 animate-pulse"></span>
                                      ${
                                          request.status
                                              .charAt(0)
                                              .toUpperCase() +
                                          request.status.slice(1)
                                      }
                                  </span>
                                 
                              </div>
                          </div>
                          
                          <!-- Service details grid - responsive layout -->
                          <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-3 sm:gap-4 mb-4 sm:mb-6">
                              <!-- Service -->
                              <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-xl p-3 sm:p-4 transition-all duration-200 hover:shadow-md hover:scale-105 border border-indigo-200">
                                  <div class="flex items-center mb-2">
                                      <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-white shadow-sm flex items-center justify-center mr-2 sm:mr-3 border border-indigo-200">
                                          ${getServiceIcon(request.service)}
                                      </div>
                                      <div class="min-w-0 flex-1">
                                          <p class="text-xs sm:text-sm font-medium text-indigo-700 mb-1">Service</p>
                                          <p class="text-sm sm:text-base font-semibold text-gray-900 truncate">${
                                              request.service
                                          }</p>
                                      </div>
                                  </div>
                              </div>
                              
                              <!-- Date & Time -->
                              <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-xl p-3 sm:p-4 transition-all duration-200 hover:shadow-md hover:scale-105 border border-indigo-200">
                                  <div class="flex items-center mb-2">
                                      <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-white shadow-sm flex items-center justify-center mr-2 sm:mr-3 border border-indigo-200">
                                          <svg class="w-4 h-4 sm:w-5 sm:h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                          </svg>
                                      </div>
                                      <div class="min-w-0 flex-1">
                                          <p class="text-xs sm:text-sm font-medium text-indigo-700 mb-1">Date & Time</p>
                                          <p class="text-sm sm:text-base font-semibold text-gray-900">
                                              <span class="block sm:inline">${
                                                  request.date
                                              }</span>
                                              <span class="text-gray-600 text-xs sm:text-sm block sm:inline"> at ${
                                                  request.time
                                              }</span>
                                          </p>
                                      </div>
                                  </div>
                              </div>
                              
                              <!-- Duration -->
                              <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl p-3 sm:p-4 transition-all duration-200 hover:shadow-md hover:scale-105 border border-amber-200">
                                  <div class="flex items-center mb-2">
                                      <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-white shadow-sm flex items-center justify-center mr-2 sm:mr-3 border border-amber-200">
                                          <svg class="w-4 h-4 sm:w-5 sm:h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                          </svg>
                                      </div>
                                      <div class="min-w-0 flex-1">
                                          <p class="text-xs sm:text-sm font-medium text-amber-700 mb-1">Duration</p>
                                          <p class="text-sm sm:text-base font-semibold text-gray-900 truncate">${
                                              request.duration
                                          }</p>
                                      </div>
                                  </div>
                              </div>
                              
                              <!-- Total Amount -->
                              <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-3 sm:p-4 transition-all duration-200 hover:shadow-md hover:scale-105 border border-emerald-200">
                                  <div class="flex items-center mb-2">
                                      <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-white shadow-sm flex items-center justify-center mr-2 sm:mr-3 border border-emerald-200">
                                          <svg class="w-4 h-4 sm:w-5 sm:h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                          </svg>
                                      </div>
                                      <div class="min-w-0 flex-1">
                                          <p class="text-xs sm:text-sm font-medium text-emerald-700 mb-1">Total Amount</p>
                                          <p class="text-sm sm:text-base font-bold text-emerald-600">$${
                                              request.total_amount
                                          }</p>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          
                          <!-- Address and Description - improved mobile layout -->
                          <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 mb-4 sm:mb-6">
                              <!-- Address -->
                              <div class="bg-gradient-to-br from-gray-50 to-gray-100 border border-gray-200 rounded-xl p-4 shadow-sm hover:shadow-md transition-all duration-200">
                                  <div class="flex items-start mb-3">
                                      <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center mr-3 flex-shrink-0 border border-red-200">
                                          <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                          </svg>
                                      </div>
                                      <div class="min-w-0 flex-1">
                                          <p class="text-sm font-semibold text-gray-800 mb-1">Service Location</p>
                                          <p class="text-sm text-gray-600 leading-relaxed break-words">${
                                              request.address
                                          }</p>
                                          <button onclick="viewOnMap('${
                                              request.address
                                          }')" class="mt-2 text-sm text-indigo-600 hover:text-indigo-800 transition-colors flex items-center group">
                                              <svg class="w-4 h-4 mr-1 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                              </svg>
                                              <span class="font-medium">View on map</span>
                                          </button>
                                      </div>
                                  </div>
                              </div>
                              
                              <!-- Description -->
                              <div class="bg-gradient-to-br from-gray-50 to-gray-100 border border-gray-200 rounded-xl p-4 shadow-sm hover:shadow-md transition-all duration-200">
                                  <div class="flex items-start mb-3">
                                      <div class="w-8 h-8 rounded-lg bg-indigo-100 flex items-center justify-center mr-3 flex-shrink-0 border border-indigo-200">
                                          <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                          </svg>
                                      </div>
                                      <div class="min-w-0 flex-1">
                                          <p class="text-sm font-semibold text-gray-800 mb-1">Special Instruction</p>
                                          <p class="text-sm text-gray-600 leading-relaxed break-words ${
                                              request.description &&
                                              request.description.length > 100
                                                  ? "line-clamp-3"
                                                  : ""
                                          }">${
                    request.description || "No Special Instruction provided."
                }</p>
                                          ${
                                              request.description &&
                                              request.description.length > 100
                                                  ? `<button onclick="expandDescription(this, '${request.id}')" class="mt-2 text-sm text-indigo-600 hover:text-indigo-800 transition-colors flex items-center group" data-full-text="${request.description}">
                                                  <svg class="w-4 h-4 mr-1 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                  </svg>
                                                  <span class="font-medium">Read more</span>
                                              </button>`
                                                  : ""
                                          }
                                      </div>
                                  </div>
                              </div>
                          </div>
                          
                          <!-- Action Buttons - enhanced mobile layout -->
                          <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 pt-4 border-t border-gray-100">
                              ${
                                  request.status === "pending"
                                      ? `
                                  <button data-id="${request.id}" data-action="accept" class="btn-respond flex-1 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white px-4 py-3 rounded-xl text-sm font-semibold hover:from-emerald-600 hover:to-emerald-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center group">
                                      <svg class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                      </svg>
                                      Accept Request
                                  </button>
                                  <button data-id="${request.id}" data-action="decline" class="btn-respond flex-1 bg-gradient-to-r from-rose-500 to-rose-600 text-white px-4 py-3 rounded-xl text-sm font-semibold hover:from-rose-600 hover:to-rose-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center group">
                                      <svg class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                      </svg>
                                      Decline Request
                                  </button>
                                  <button data-id="${request.id}" class="btn-view-details sm:flex-none bg-white border-2 border-gray-200 px-4 py-3 rounded-xl text-sm font-semibold text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-0.5 flex items-center justify-center group">
                                      <svg class="w-4 h-4 mr-2 text-gray-500 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                      </svg>
                                      View Details
                                  </button>
                              `
                                      : request.status === "confirmed"
                                      ? `
                                  <button data-id="${request.id}" class="btn-completed flex-1 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white px-4 py-3 rounded-xl text-sm font-semibold hover:from-indigo-600 hover:to-indigo-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center group">
                                      <svg class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                      </svg>
                                      Mark Completed
                                  </button>
                                  <button data-id="${request.id}" class="btn-view-details sm:flex-none bg-white border-2 border-gray-200 px-4 py-3 rounded-xl text-sm font-semibold text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-0.5 flex items-center justify-center group">
                                      <svg class="w-4 h-4 mr-2 text-gray-500 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                      </svg>
                                      View Details
                                  </button>
                              `
                                      : `
                                  <button data-id="${request.id}" class="btn-view-details w-full bg-white border-2 border-gray-200 px-4 py-3 rounded-xl text-sm font-semibold text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-0.5 flex items-center justify-center group">
                                      <svg class="w-4 h-4 mr-2 text-gray-500 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                      </svg>
                                      View Details
                                  </button>
                              `
                              }
                          </div>
                      </div>
                  </div>
              `
            )
            .join("");

        attachEventListeners();
    }

    // Enhanced expand description with better mobile support
    window.expandDescription = (button, requestId) => {
        const fullText = button.getAttribute("data-full-text");
        const parentElement = button.previousElementSibling;

        if (button.classList.contains("expanded")) {
            // Collapse
            parentElement.textContent = fullText.substring(0, 100) + "...";
            parentElement.classList.add("line-clamp-3");
            button.innerHTML = `
                  <svg class="w-4 h-4 mr-1 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                  </svg>
                  <span class="font-medium">Read more</span>
              `;
            button.classList.remove("expanded");
        } else {
            // Expand
            parentElement.textContent = fullText;
            parentElement.classList.remove("line-clamp-3");
            button.innerHTML = `
                  <svg class="w-4 h-4 mr-1 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                  </svg>
                  <span class="font-medium">Show less</span>
              `;
            button.classList.add("expanded");
        }
    };

    // Rest of the functions remain the same but with enhanced mobile responsiveness in modals
    function attachEventListeners() {
        document.querySelectorAll(".btn-respond").forEach((btn) => {
            btn.addEventListener("click", () => {
                const id = Number.parseInt(btn.dataset.id);
                const action = btn.dataset.action;
                respondToRequest(id, action);
            });
        });

        document.querySelectorAll(".btn-completed").forEach((btn) => {
            btn.addEventListener("click", () => {
                const id = Number.parseInt(btn.dataset.id);
                markCompleted(id);
            });
        });

        document.querySelectorAll(".btn-view-details").forEach((btn) => {
            btn.addEventListener("click", () => {
                const id = Number.parseInt(btn.dataset.id);
                viewDetails(id);
            });
        });
    }

    const bookingRequests = window.bookingRequests || [];

    // Enhanced modal functions with better mobile responsiveness
    function updateStatusOnServer(id, payload, successMessage) {
        const loadingToast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            },
        });

        loadingToast.fire({
            title: "Processing...",
            background: "#ffffff",
            customClass: {
                popup: "rounded-xl shadow-lg",
            },
        });

        fetch(`/bookings/${id}/update-status`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
            },
            body: JSON.stringify(payload),
        })
            .then(async (res) => {
                const text = await res.text();
                try {
                    const json = JSON.parse(text);
                    if (!res.ok)
                        throw new Error(json.message || "Server error");
                    return json;
                } catch {
                    console.error("Unexpected response:", text);
                    throw new Error("Invalid server response");
                }
            })
            .then(() => {
                Swal.fire({
                    toast: true,
                    position: "top-end",
                    icon: "success",
                    title: successMessage,
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    customClass: {
                        popup: "rounded-xl shadow-lg",
                        title: "text-sm font-medium",
                    },
                });
                const req = bookingRequests.find((r) => r.id === id);
                if (req) req.status = payload.status;
                document
                    .getElementById("status-filter")
                    .dispatchEvent(new Event("change"));
            })
            .catch((err) => {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: err.message,
                    customClass: {
                        popup: "rounded-2xl shadow-xl",
                        title: "text-red-600 font-bold",
                    },
                });
            });
    }

    // Enhanced modal functions with mobile-first design
    function respondToRequest(id, action) {
        const request = bookingRequests.find((r) => r.id === id);
        if (!request) return;

        const isMobile = window.innerWidth < 640;
        const modalWidth = isMobile ? "95%" : "600px";

        if (action === "accept") {
            Swal.fire({
                title: '<span class="text-xl sm:text-2xl font-bold text-gray-800">Accept Booking Request</span>',
                html: `
                      <div class="space-y-4 sm:space-y-6 text-left">
                          <!-- Client Info Card -->
                          <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-3 sm:p-4 border border-green-200">
                              <div class="flex items-center space-x-3 mb-3">
                                  <div class="w-8 h-8 sm:w-10 sm:h-10 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                                      <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                      </svg>
                                  </div>
                                  <div class="min-w-0 flex-1">
                                      <h3 class="font-semibold text-gray-800 text-sm sm:text-base">${request.clientName}</h3>
                                      <p class="text-xs sm:text-sm text-gray-600">Client</p>
                                  </div>
                              </div>
                              
                              <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-3 text-xs sm:text-sm">
                                  <div class="flex items-center space-x-2">
                                      <svg class="w-3 h-3 sm:w-4 sm:h-4 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                      </svg>
                                      <span class="text-gray-700 break-words"><strong>Service:</strong> ${request.service}</span>
                                  </div>
                                  <div class="flex items-center space-x-2">
                                      <svg class="w-3 h-3 sm:w-4 sm:h-4 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 8a4 4 0 11-8 0v-1a4 4 0 014-4h4a4 4 0 014 4v1a4 4 0 11-8 0z"></path>
                                      </svg>
                                      <span class="text-gray-700"><strong>Date:</strong> ${request.date}</span>
                                  </div>
                                  <div class="flex items-center space-x-2 sm:col-span-2">
                                      <svg class="w-3 h-3 sm:w-4 sm:h-4 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                      </svg>
                                      <span class="text-gray-700"><strong>Time:</strong> ${request.time}</span>
                                  </div>
                              </div>
                          </div>
                      </div>
                  `,
                width: modalWidth,
                padding: isMobile ? "1.5rem" : "2rem",
                background: "#ffffff",
                backdrop: "rgba(0, 0, 0, 0.4)",
                focusConfirm: false,
                customClass: {
                    popup: "rounded-2xl shadow-2xl",
                    title: "text-left mb-4",
                    confirmButton:
                        "bg-green-600 hover:bg-green-700 text-white font-medium py-2.5 sm:py-3 px-4 sm:px-6 rounded-lg transition-colors duration-200 mr-2 sm:mr-3 text-sm sm:text-base",
                    cancelButton:
                        "bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2.5 sm:py-3 px-4 sm:px-6 rounded-lg transition-colors duration-200 text-sm sm:text-base",
                },

                showCancelButton: true,
                confirmButtonText: "✓ Accept Request",
                cancelButtonText: "Cancel",
            }).then((result) => {
                if (result.isConfirmed) {
                    updateStatusOnServer(
                        id,
                        {
                            status: "confirmed",
                            rate: result.value.rate,
                            message: result.value.message,
                        },
                        "Request confirmed successfully!"
                    );
                }
            });
        } else if (action === "decline") {
            // Similar enhanced mobile-responsive decline modal
            Swal.fire({
                title: '<span class="text-xl sm:text-2xl font-bold text-gray-800">Decline Booking Request</span>',
                html: `
                      <div class="space-y-4 sm:space-y-6 text-left">
                          <!-- Client Info Card -->
                          <div class="bg-gradient-to-r from-red-50 to-rose-50 rounded-xl p-3 sm:p-4 border border-red-200">
                              <div class="flex items-center space-x-3 mb-3">
                                  <div class="w-8 h-8 sm:w-10 sm:h-10 bg-red-500 rounded-full flex items-center justify-center flex-shrink-0">
                                      <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                      </svg>
                                  </div>
                                  <div class="min-w-0 flex-1">
                                      <h3 class="font-semibold text-gray-800 text-sm sm:text-base">${request.clientName}</h3>
                                      <p class="text-xs sm:text-sm text-gray-600">Client</p>
                                  </div>
                              </div>
                              
                              <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-3 text-xs sm:text-sm">
                                  <div class="flex items-center space-x-2">
                                      <svg class="w-3 h-3 sm:w-4 sm:h-4 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                      </svg>
                                      <span class="text-gray-700 break-words"><strong>Service:</strong> ${request.service}</span>
                                  </div>
                                  <div class="flex items-center space-x-2">
                                      <svg class="w-3 h-3 sm:w-4 sm:h-4 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 8a4 4 0 11-8 0v-1a4 4 0 014-4h4a4 4 0 014 4v1a4 4 0 11-8 0z"></path>
                                      </svg>
                                      <span class="text-gray-700"><strong>Date:</strong> ${request.date}</span>
                                  </div>
                                  <div class="flex items-center space-x-2 sm:col-span-2">
                                      <svg class="w-3 h-3 sm:w-4 sm:h-4 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                      </svg>
                                      <span class="text-gray-700"><strong>Time:</strong> ${request.time}</span>
                                  </div>
                              </div>
                          </div>
  
                          <!-- Decline Reason -->
                          <div class="space-y-2">
                              <label class="block text-sm font-medium text-gray-700">Reason for Declining</label>
                              <select 
                                  id="decline-reason" 
                                  class="block w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm sm:text-base"
                              >
                                  <option value="">Select a reason</option>
                                  <option value="schedule">📅 Schedule conflict</option>
                                  <option value="location">📍 Location too far</option>
                                  <option value="service">🔧 Service not offered</option>
                                  <option value="pricing">💰 Pricing concerns</option>
                                  <option value="other">📝 Other</option>
                              </select>
                          </div>
  
                          <!-- Additional Message -->
                          <div class="space-y-2">
                              <label class="block text-sm font-medium text-gray-700">Additional Message (Optional)</label>
                              <textarea 
                                  id="decline-message" 
                                  class="block w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 resize-none text-sm sm:text-base" 
                                  rows="3"
                                  placeholder="I apologize, but I won't be able to take on this request due to..."
                              ></textarea>
                          </div>
                      </div>
                  `,
                width: modalWidth,
                padding: isMobile ? "1.5rem" : "2rem",
                background: "#ffffff",
                backdrop: "rgba(0, 0, 0, 0.4)",
                focusConfirm: false,
                customClass: {
                    popup: "rounded-2xl shadow-2xl",
                    title: "text-left mb-4",
                    confirmButton:
                        "bg-red-600 hover:bg-red-700 text-white font-medium py-2.5 sm:py-3 px-4 sm:px-6 rounded-lg transition-colors duration-200 mr-2 sm:mr-3 text-sm sm:text-base",
                    cancelButton:
                        "bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2.5 sm:py-3 px-4 sm:px-6 rounded-lg transition-colors duration-200 text-sm sm:text-base",
                },
                preConfirm: () => {
                    const reason =
                        Swal.getPopup().querySelector("#decline-reason").value;
                    const message =
                        Swal.getPopup().querySelector("#decline-message").value;
                    if (!reason) {
                        Swal.showValidationMessage(
                            "Please select a reason for declining"
                        );
                        return false;
                    }
                    return { reason, message };
                },
                showCancelButton: true,
                confirmButtonText: "✗ Decline Request",
                cancelButtonText: "Cancel",
            }).then((result) => {
                if (result.isConfirmed) {
                    updateStatusOnServer(
                        id,
                        {
                            status: "canceled",
                            reason: result.value.reason,
                            message: result.value.message,
                        },
                        "Request canceled successfully!"
                    );
                }
            });
        }
    }

    // Enhanced mark completed function with mobile responsiveness
    function markCompleted(id) {
        const request = bookingRequests.find((r) => r.id === id);
        if (!request) return;

        const isMobile = window.innerWidth < 640;
        const modalWidth = isMobile ? "95%" : "500px";

        Swal.fire({
            title: '<span class="text-xl sm:text-2xl font-bold text-gray-800">Mark as Completed</span>',
            html: `
                  <div class="space-y-4 sm:space-y-6 text-left">
                      <!-- Completion Info Card -->
                      <div class="bg-gradient-to-r from-indigo-50 to-indigo-50 rounded-xl p-3 sm:p-4 border border-indigo-200">
                          <div class="flex items-center space-x-3 mb-3">
                              <div class="w-10 h-10 sm:w-12 sm:h-12 bg-indigo-500 rounded-full flex items-center justify-center flex-shrink-0">
                                  <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                  </svg>
                              </div>
                              <div class="min-w-0 flex-1">
                                  <h3 class="font-semibold text-gray-800 text-sm sm:text-base">${request.clientName}</h3>
                                  <p class="text-xs sm:text-sm text-gray-600">Ready to mark as completed</p>
                              </div>
                          </div>
                          
                          <div class="bg-white rounded-lg p-3 space-y-2 text-xs sm:text-sm">
                              <div class="flex items-center justify-between">
                                  <span class="text-gray-600">Service:</span>
                                  <span class="font-medium text-gray-800 text-right break-words">${request.service}</span>
                              </div>
                              <div class="flex items-center justify-between">
                                  <span class="text-gray-600">Date:</span>
                                  <span class="font-medium text-gray-800">${request.date}</span>
                              </div>
                              <div class="flex items-center justify-between">
                                  <span class="text-gray-600">Time:</span>
                                  <span class="font-medium text-gray-800">${request.time}</span>
                              </div>
                          </div>
                      </div>
  
                      <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 sm:p-4">
                          <div class="flex items-start space-x-3">
                              <svg class="w-4 h-4 sm:w-5 sm:h-5 text-yellow-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                              </svg>
                              <div class="min-w-0 flex-1">
                                  <h4 class="font-medium text-yellow-800 text-sm sm:text-base">Confirm Completion</h4>
                                  <p class="text-xs sm:text-sm text-yellow-700 mt-1 leading-relaxed">
                                      This action will mark the service as completed and notify the client. 
                                      Make sure the work has been finished to their satisfaction.
                                  </p>
                              </div>
                          </div>
                      </div>
                  </div>
              `,
            width: modalWidth,
            padding: isMobile ? "1.5rem" : "2rem",
            background: "#ffffff",
            backdrop: "rgba(0, 0, 0, 0.4)",
            customClass: {
                popup: "rounded-2xl shadow-2xl",
                title: "text-left mb-4",
                confirmButton:
                    "bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 sm:py-3 px-4 sm:px-6 rounded-lg transition-colors duration-200 mr-2 sm:mr-3 text-sm sm:text-base",
                cancelButton:
                    "bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2.5 sm:py-3 px-4 sm:px-6 rounded-lg transition-colors duration-200 text-sm sm:text-base",
            },
            showCancelButton: true,
            confirmButtonText: "✓ Mark as Completed",
            cancelButtonText: "Cancel",
        }).then((result) => {
            if (result.isConfirmed) {
                updateStatusOnServer(
                    id,
                    { status: "completed" },
                    "Request marked as completed!"
                );
            }
        });
    }

    // Enhanced view details function with mobile-first design
    function viewDetails(id) {
        const request = bookingRequests.find((r) => r.id === id);
        if (!request) return;

        const isMobile = window.innerWidth < 640;
        const modalWidth = isMobile ? "95%" : "700px";

        const getStatusConfig = (status) => {
            const configs = {
                pending: {
                    bgClass: "from-yellow-50 to-amber-50",
                    borderClass: "border-yellow-200",
                    iconClass: "bg-yellow-500",
                    icon: `<svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                      </svg>`,
                    label: "Pending Review",
                },
                confirmed: {
                    bgClass: "from-green-50 to-emerald-50",
                    borderClass: "border-green-200",
                    iconClass: "bg-green-500",
                    icon: `<svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                      </svg>`,
                    label: "confirmed",
                },
                canceled: {
                    bgClass: "from-red-50 to-rose-50",
                    borderClass: "border-red-200",
                    iconClass: "bg-red-500",
                    icon: `<svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                      </svg>`,
                    label: "canceled",
                },
                completed: {
                    bgClass: "from-indigo-50 to-indigo-50",
                    borderClass: "border-indigo-200",
                    iconClass: "bg-indigo-500",
                    icon: `<svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                      </svg>`,
                    label: "Completed",
                },
            };
            return configs[status] || configs.pending;
        };

        const statusConfig = getStatusConfig(request.status);

        Swal.fire({
            title: '<span class="text-xl sm:text-2xl font-bold text-gray-800">Booking Request Details</span>',
            html: `
                  <div class="space-y-4 sm:space-y-6 text-left max-w-2xl mx-auto">
                      <!-- Header Card with Client Info -->
                      <div class="bg-gradient-to-r ${
                          statusConfig.bgClass
                      } rounded-xl p-4 sm:p-6 border ${
                statusConfig.borderClass
            }">
                          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4">
                              <div class="flex items-center space-x-3 sm:space-x-4">
                                  <div class="w-12 h-12 sm:w-16 sm:h-16 bg-gray-200 rounded-full flex items-center justify-center overflow-hidden flex-shrink-0">
                                      <svg class="w-6 h-6 sm:w-8 sm:h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                      </svg>
                                  </div>
                                  <div class="min-w-0 flex-1">
                                      <h2 class="text-lg sm:text-xl font-bold text-gray-800 break-words">${
                                          request.clientName
                                      }</h2>
                                      <p class="text-sm sm:text-base text-gray-600">Client</p>
                                  </div>
                              </div>
                              <div class="flex items-center space-x-2 self-start sm:self-center">
                                  <div class="w-6 h-6 sm:w-8 sm:h-8 ${
                                      statusConfig.iconClass
                                  } rounded-full flex items-center justify-center flex-shrink-0">
                                      ${statusConfig.icon}
                                  </div>
                                  <span class="text-xs sm:text-sm font-medium text-gray-700">${
                                      statusConfig.label
                                  }</span>
                              </div>
                          </div>
                      </div>
  
                      <!-- Service Details Grid -->
                      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                          <!-- Service Info -->
                          <div class="bg-white rounded-xl border border-gray-200 p-3 sm:p-4 hover:shadow-md transition-shadow">
                              <div class="flex items-center space-x-3 mb-3">
                                  <div class="w-8 h-8 sm:w-10 sm:h-10 bg-indigo-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                      <svg class="w-4 h-4 sm:w-5 sm:h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                      </svg>
                                  </div>
                                  <div class="min-w-0 flex-1">
                                      <h3 class="font-semibold text-gray-800 text-sm sm:text-base">Service</h3>
                                      <p class="text-gray-600 text-xs sm:text-sm">Type of service requested</p>
                                  </div>
                              </div>
                              <p class="text-base sm:text-lg font-medium text-gray-900 break-words">${
                                  request.service
                              }</p>
                          </div>
  
                          <!-- Duration Info -->
                          <div class="bg-white rounded-xl border border-gray-200 p-3 sm:p-4 hover:shadow-md transition-shadow">
                              <div class="flex items-center space-x-3 mb-3">
                                  <div class="w-8 h-8 sm:w-10 sm:h-10 bg-indigo-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                      <svg class="w-4 h-4 sm:w-5 sm:h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                      </svg>
                                  </div>
                                  <div class="min-w-0 flex-1">
                                      <h3 class="font-semibold text-gray-800 text-sm sm:text-base">Duration</h3>
                                      <p class="text-gray-600 text-xs sm:text-sm">Estimated time needed</p>
                                  </div>
                              </div>
                              <p class="text-base sm:text-lg font-medium text-gray-900">${
                                  request.duration
                              }</p>
                          </div>
                      </div>
  
                      <!-- Date & Time Card -->
                      <div class="bg-white rounded-xl border border-gray-200 p-3 sm:p-4 hover:shadow-md transition-shadow">
                          <div class="flex items-center space-x-3 mb-4">
                              <div class="w-8 h-8 sm:w-10 sm:h-10 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                  <svg class="w-4 h-4 sm:w-5 sm:h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 8a4 4 0 11-8 0v-1a4 4 0 014-4h4a4 4 0 014 4v1a4 4 0 11-8 0z"></path>
                                  </svg>
                              </div>
                              <div class="min-w-0 flex-1">
                                  <h3 class="font-semibold text-gray-800 text-sm sm:text-base">Scheduled Date & Time</h3>
                                  <p class="text-gray-600 text-xs sm:text-sm">When the service is requested</p>
                              </div>
                          </div>
                          <div class="bg-gray-50 rounded-lg p-3">
                              <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                                  <div class="flex items-center space-x-2">
                                      <svg class="w-3 h-3 sm:w-4 sm:h-4 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 8a4 4 0 11-8 0v-1a4 4 0 014-4h4a4 4 0 014 4v1a4 4 0 11-8 0z"></path>
                                      </svg>
                                      <span class="text-gray-700 font-medium text-sm sm:text-base">${
                                          request.date
                                      }</span>
                                  </div>
                                  <div class="flex items-center space-x-2">
                                      <svg class="w-3 h-3 sm:w-4 sm:h-4 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                      </svg>
                                      <span class="text-gray-700 font-medium text-sm sm:text-base">${
                                          request.time
                                      }</span>
                                  </div>
                              </div>
                          </div>
                      </div>
  
                      <!-- Location Card -->
                      <div class="bg-white rounded-xl border border-gray-200 p-3 sm:p-4 hover:shadow-md transition-shadow">
                          <div class="flex items-center space-x-3 mb-3">
                              <div class="w-8 h-8 sm:w-10 sm:h-10 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                  <svg class="w-4 h-4 sm:w-5 sm:h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                  </svg>
                              </div>
                              <div class="min-w-0 flex-1">
                                  <h3 class="font-semibold text-gray-800 text-sm sm:text-base">Service Location</h3>
                                  <p class="text-gray-600 text-xs sm:text-sm">Where the service will be performed</p>
                              </div>
                          </div>
                          <div class="bg-gray-50 rounded-lg p-3">
                              <p class="text-gray-800 leading-relaxed text-sm sm:text-base break-words">${
                                  request.address
                              }</p>
                              <button onclick="viewOnMap('${
                                  request.address
                              }')" class="mt-2 text-indigo-600 hover:text-indigo-800 text-xs sm:text-sm font-medium flex items-center space-x-1 transition-colors group">
                                  <svg class="w-3 h-3 sm:w-4 sm:h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                  </svg>
                                  <span>View on Map</span>
                              </button>
                          </div>
                      </div>
  
                      <!-- Description Card -->
                      <div class="bg-white rounded-xl border border-gray-200 p-3 sm:p-4 hover:shadow-md transition-shadow">
                          <div class="flex items-center space-x-3 mb-3">
                              <div class="w-8 h-8 sm:w-10 sm:h-10 bg-indigo-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                  <svg class="w-4 h-4 sm:w-5 sm:h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                  </svg>
                              </div>
                              <div class="min-w-0 flex-1">
                                  <h3 class="font-semibold text-gray-800 text-sm sm:text-base">Service Description</h3>
                                  <p class="text-gray-600 text-xs sm:text-sm">Additional details and requirements</p>
                              </div>
                          </div>
                          <div class="bg-gray-50 rounded-lg p-3">
                              <p class="text-gray-800 leading-relaxed text-sm sm:text-base break-words">${
                                  request.description ||
                                  "No additional description provided."
                              }</p>
                          </div>
                      </div>
  
                      <!-- Pricing Card -->
                      <div class="bg-gradient-to-r from-emerald-50 to-green-50 rounded-xl border border-emerald-200 p-4 sm:p-6">
                          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                              <div class="flex items-center space-x-3">
                                  <div class="w-10 h-10 sm:w-12 sm:h-12 bg-emerald-500 rounded-full flex items-center justify-center flex-shrink-0">
                                      <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                      </svg>
                                  </div>
                                  <div>
                                      <h3 class="text-base sm:text-lg font-semibold text-gray-800">Total Amount</h3>
                                      <p class="text-gray-600 text-xs sm:text-sm">Estimated service cost</p>
                                  </div>
                              </div>
                              <div class="text-center sm:text-right">
                                  <p class="text-2xl sm:text-3xl font-bold text-emerald-600">$${
                                      request.total_amount
                                  }</p>
                                  <p class="text-xs sm:text-sm text-gray-600">USD</p>
                              </div>
                          </div>
                      </div>
  
                 
                  </div>
              `,
            width: modalWidth,
            padding: isMobile ? "1.5rem" : "2rem",
            background: "#ffffff",
            backdrop: "rgba(0, 0, 0, 0.4)",
            showConfirmButton: true,
            confirmButtonText: "Close",
            customClass: {
                popup: "rounded-2xl shadow-2xl",
                title: "text-left mb-4 sm:mb-6",
                confirmButton:
                    "bg-gray-600 hover:bg-gray-700 text-white font-medium py-2.5 sm:py-3 px-4 sm:px-6 rounded-lg transition-colors duration-200 text-sm sm:text-base",
            },
        });
    }

    // Enhanced map viewing function
    window.viewOnMap = (address) => {
        const encodedAddress = encodeURIComponent(address);
        const mapUrl = `https://www.google.com/maps/search/?api=1&query=${encodedAddress}`;
        window.open(mapUrl, "_blank");
    };

    // Expose functions globally
    window.respondToRequest = respondToRequest;
    window.markCompleted = markCompleted;
    window.viewDetails = viewDetails;

    // Enhanced event listeners with better mobile support
    let filterTimeout;

    const searchInput = document.getElementById("search-input");
    if (searchInput) {
        searchInput.addEventListener("input", debounceFilter);
    }

    // Enhanced filter function with search capability
    function debounceFilter() {
        clearTimeout(filterTimeout);
        filterTimeout = setTimeout(filterRequests, 300);
    }

    if (statusFilter) statusFilter.addEventListener("change", filterRequests);
    if (serviceFilter) serviceFilter.addEventListener("change", filterRequests);
    if (dateFilter) dateFilter.addEventListener("change", filterRequests);

    function filterRequests() {
        let filtered = [...bookingRequests];

        const status = statusFilter?.value;
        const service = serviceFilter?.value;
        const date = dateFilter?.value;
        const searchTerm = searchInput?.value.toLowerCase();

        if (status) filtered = filtered.filter((r) => r.status === status);
        if (service) filtered = filtered.filter((r) => r.category === service);
        if (date) filtered = filtered.filter((r) => r.date === date);

        if (searchTerm) {
            filtered = filtered.filter(
                (r) =>
                    r.clientName.toLowerCase().includes(searchTerm) ||
                    r.service.toLowerCase().includes(searchTerm) ||
                    r.address.toLowerCase().includes(searchTerm) ||
                    (r.description &&
                        r.description.toLowerCase().includes(searchTerm))
            );
        }

        if (requestsContainer && requestsContainer.children.length > 0) {
            requestsContainer.style.transition =
                "opacity 0.3s ease, transform 0.3s ease";
            requestsContainer.style.opacity = "0";
            requestsContainer.style.transform = "translateY(10px)";
            setTimeout(() => {
                renderRequests(filtered);
                requestsContainer.style.opacity = "1";
                requestsContainer.style.transform = "translateY(0)";
            }, 300);
        } else {
            renderRequests(filtered);
        }
    }

    // Initialize everything
    function initialize() {
        renderRequests(bookingRequests);

        // Add loading states to buttons with enhanced mobile feedback
        document.addEventListener("click", (e) => {
            if (
                e.target.matches(
                    ".btn-respond, .btn-completed, .btn-view-details"
                )
            ) {
                e.target.style.opacity = "0.7";
                e.target.style.pointerEvents = "none";
                e.target.style.transform = "scale(0.98)";

                setTimeout(() => {
                    e.target.style.opacity = "1";
                    e.target.style.pointerEvents = "auto";
                    e.target.style.transform = "scale(1)";
                }, 2000);
            }
        });

        // Enhanced touch feedback for mobile
        if ("ontouchstart" in window) {
            document.addEventListener("touchstart", (e) => {
                if (
                    e.target.matches(
                        ".btn-respond, .btn-completed, .btn-view-details"
                    )
                ) {
                    e.target.style.transform = "scale(0.95)";
                }
            });

            document.addEventListener("touchend", (e) => {
                if (
                    e.target.matches(
                        ".btn-respond, .btn-completed, .btn-view-details"
                    )
                ) {
                    setTimeout(() => {
                        e.target.style.transform = "scale(1)";
                    }, 150);
                }
            });
        }
    }

    // Call initialize when DOM is ready
    initialize();

    // Export functions for external use
    window.BookingRequestManager = {
        renderRequests,
        filterRequests,
        respondToRequest,
        markCompleted,
        viewDetails,
    };
});
