// To use Html5QrcodeScanner (more info below)
import { Html5QrcodeScanner } from "html5-qrcode";

// To use Html5Qrcode (more info below)
import { Html5Qrcode } from "html5-qrcode";

// This part is for getting the CSRF token from the Blade meta tag.
// We'll add this meta tag to your main layout file.
addEventListener("DOMContentLoaded", () => {
    const csrfToken = (
        document.head.querySelector(
            'meta[name="csrf-token"]'
        ) as HTMLMetaElement
    ).content;

    function onScanSuccess(decodedText, decodedResult) {
        // Stop the scanner to prevent multiple submissions
        html5QrcodeScanner.pause();

        console.log(`Scanned ID = ${decodedText}`, decodedResult);

        // Make the AJAX call to your Laravel backend
        fetch("/attendance/mark", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken, // Laravel's CSRF token for security
            },
            body: JSON.stringify({
                student_id: decodedText,
            }),
        })
            .then((response) => response.json())
            .then((data) => {
                console.log(data); // Log the response from the server

                // You can add logic here to display a success message to the user
                if (data.status === "success") {
                    alert(data.message); // Use a better UI than alert in a real app
                } else {
                    alert(data.message);
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                alert("An error occurred. Please try again.");
            })
            .finally(() => {
                // Resume the scanner after the request is complete
                html5QrcodeScanner.resume();
            });
    }

    function onScanFailure(error) {
        // handle scan failure, usually better to ignore and keep scanning.
        // for example:
        console.warn(`Code scan error = ${error}`);
    }

    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader",
        { fps: 10, qrbox: { width: 250, height: 250 } },
        /* verbose= */ false
    );
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
});
