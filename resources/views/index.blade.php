@extends('layouts.app')

@section('content')
  <div class="container mx-auto p-8 max-w-2xl bg-white shadow-xl rounded-xl mt-20">
    <h1 class="text-4xl font-bold text-gray-800 mb-8 text-center">Student List</h1>

    <div class="space-y-6">
      @if (isset($students) && count($students) > 0)
        @foreach ($students as $student)
          <div
            class="flex flex-col sm:flex-row items-center justify-between p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
            <div class="text-xl font-medium text-gray-700 mb-4 sm:mb-0 sm:mr-4">
              {{ $student->first_name }} {{ $student->last_name }}
            </div>

            <div class="qr-code-container">
              {{-- This div will be populated with the converted PNG --}}
            </div>
          </div>
        @endforeach
      @else
        <div class="text-center text-gray-500 py-10">
          <p>No students to display.</p>
        </div>
      @endif
    </div>
  </div>

  <script>
    // Function to convert an SVG string to a PNG image element
    function convertSvgStringToPng(svgString, containerElement) {
      const svgBlob = new Blob([svgString], {
        type: 'image/svg+xml;charset=utf-8'
      });
      const url = URL.createObjectURL(svgBlob);

      const img = new Image();
      img.onload = () => {
        const canvas = document.createElement('canvas');
        canvas.width = img.width;
        canvas.height = img.height;

        const ctx = canvas.getContext('2d');
        ctx.drawImage(img, 0, 0);

        const pngDataUrl = canvas.toDataURL('image/png');
        const pngImage = document.createElement('img');
        pngImage.src = pngDataUrl;

        // Append the converted PNG image to the designated container
        containerElement.appendChild(pngImage);

        URL.revokeObjectURL(url);
      };
      img.src = url;
    }

    // Get all the QR code containers on the page
    const qrCodeContainers = document.querySelectorAll('.qr-code-container');
    const students = @json($students);

    // Loop through each container and convert the corresponding QR code
    qrCodeContainers.forEach((container, index) => {
      const student = students[index];
      if (student && student.qr_code) {
        convertSvgStringToPng(student.qr_code.qr_code, container);
      }
    });
  </script>
@endsection
