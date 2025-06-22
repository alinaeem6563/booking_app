
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.save-provider-btn').forEach(button => {
            const serviceId = button.dataset.serviceId;
            const heartIcon = button.querySelector('.heart-icon');

            button.addEventListener('click', function() {
                fetch("/saved-providers", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                    },
                    body: JSON.stringify({
                        service_id: serviceId,
                    }),
                })
                    .then((res) => res.json())
                    .then((data) => {
                        if (data.success) {
                            // Toggle icon classes
                            if (data.status === "saved") {
                                heartIcon.classList.add(
                                    "text-red-500",
                                    "fill-red-500"
                                );
                                heartIcon.classList.remove(
                                    "text-gray-400",
                                    "fill-none"
                                );
                            } else {
                                heartIcon.classList.remove(
                                    "text-red-500",
                                    "fill-red-500"
                                );
                                heartIcon.classList.add(
                                    "text-gray-400",
                                    "fill-none"
                                );
                            }

                            // Optionally update the button's data-is-saved attribute
                            button.dataset.isSaved =
                                data.status === "saved" ? "1" : "0";
                        }
                    })
                    .catch((err) => {
                        console.error("Save provider toggle failed:", err);
                        Swal.fire({
                            icon: "error",
                            title: "Oops!",
                            text: "Something went wrong. Please try again.",
                            confirmButtonColor: "#d33",
                        });
                    });
                    
            });
        });
    });
