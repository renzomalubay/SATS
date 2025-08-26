@extends('layouts.app')

@section('content')
  <div class="container mx-auto p-8 max-w-2xl bg-white shadow-xl rounded-xl mt-20">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Scan Student QR Code</h1>

    <!-- QR Code Reader Container -->
    <div id="reader" class="rounded-xl overflow-hidden mb-6"></div>

    <!-- Status Message Display -->
    <div id="status-message" class="p-4 rounded-lg font-medium">
      <p>Ready to scan...</p>
    </div>

    <button id="stop-scan"
      class="mt-4 px-6 py-3 bg-red-600 text-white rounded-lg shadow-lg hover:bg-red-700 transition-colors duration-300">
      Stop Scanning
    </button>
  </div>
  {{-- <script>
    // Use a unique ID for the QR reader element
    const qrCodeRegionId = "reader";
    let html5QrcodeScanner;

    // Function to update the status message on the screen
    function updateStatus(message, type = 'info') {
      const statusDiv = document.getElementById('status-message');
      statusDiv.textContent = message;
      statusDiv.className = 'p-4 rounded-lg font-medium mt-4'; // Reset classes
      if (type === 'success') {
        statusDiv.classList.add('bg-green-100', 'text-green-800');
      } else if (type === 'error') {
        statusDiv.classList.add('bg-red-100', 'text-red-800');
      } else {
        statusDiv.classList.add('bg-gray-100', 'text-gray-600');
      }
    }

    // This function is called when a QR code is successfully scanned
    const onScanSuccess = (decodedText, decodedResult) => {
      // Stop the scanner immediately after a successful scan
      if (html5QrcodeScanner.getState() === Html5Qrcode.QrcodeScannerState.SCANNING) {
        html5QrcodeScanner.pause();
      }

      updateStatus(`Scanning...`);

      // Make an API call to the backend to check in/out the student
      fetch('http://127.0.0.1:8000/api/check-in-out', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
          },
          body: JSON.stringify({
            student_id: decodedText
          })
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            updateStatus(data.message, 'success');
          } else {
            updateStatus(data.message, 'error');
          }

          // Resume scanning after a short delay
          setTimeout(() => {
            if (html5QrcodeScanner.getState() === Html5Qrcode.QrcodeScannerState.PAUSED) {
              html5QrcodeScanner.resume();
            }
          }, 2000); // Wait 2 seconds before resuming scan
        })
        .catch(error => {
          console.error('API Error:', error);
          updateStatus('An error occurred. Please try again.', 'error');
        });
    };

    // This function is called if the scan fails
    const onScanFailure = (error) => {
      // You can log the error if you need to debug
      // console.warn(`Code scan error = ${error}`);
    };

    // Initialize the QR code scanner when the window loads
    window.onload = function() {
      html5QrcodeScanner = new Html5QrcodeScanner(
        qrCodeRegionId, {
          fps: 10,
          qrbox: {
            width: 250,
            height: 250
          }
        },
        false
      );

      // Render the scanner and set up the callbacks
      html5QrcodeScanner.render(onScanSuccess, onScanFailure);

      // Add an event listener to the stop button
      document.getElementById('stop-scan').addEventListener('click', () => {
        html5QrcodeScanner.stop().then(() => {
          updateStatus('Scanning stopped.', 'info');
        }).catch(err => {
          console.error("Failed to stop scanning.", err);
        });
      });
    };
  </script> --}}
@endsection

@push('scripts')
  @vite('resources/views/scanner.ts')
@endpush
