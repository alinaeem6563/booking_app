fetch('/calendar/slots', {
    method: "POST",
    headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content"),
    },
    body: JSON.stringify({
        /* your payload */
    }),
})
    .then((response) => {
        if (!response.ok) {
            return response.json().then((err) => {
                throw err;
            });
        }
        return response.json();
    })
    .then((data) => {
        // handle success
    })
    .catch((error) => {
        Swal.fire({
            icon: "error",
            title: error.error || "Error occurred",
            text:
                error.message ||
                "Something went wrong. Please try again later.",
            confirmButtonColor: "#d33",
        });
    });
