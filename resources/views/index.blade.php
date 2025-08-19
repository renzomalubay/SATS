<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Laravel</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

  <!-- Styles -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

  <body class="bg-gray-100">

    <div class="container mx-auto p-8 max-w-2xl bg-white shadow-xl rounded-xl mt-10">
      <!-- Page Title -->
      <h1 class="text-4xl font-bold text-gray-800 mb-8 text-center">Student List</h1>

      <!-- Student List Container -->
      <div class="space-y-6">
        @if (isset($students) && count($students) > 0)
          @foreach ($students as $student)
            <!-- Individual Student Item -->
            <div
              class="flex flex-col sm:flex-row items-center justify-between p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
              <!-- Student Name -->
              <div class="text-xl font-medium text-gray-700 mb-4 sm:mb-0 sm:mr-4">
                {{ $student->first_name }} {{ $student->last_name }}
              </div>

              <!-- QR Code Image -->
              <div class="flex-shrink-0">
                <!--
                            This is a placeholder for the QR code image.
                            In a real application, you would replace this with a dynamically
                            generated QR code image URL based on student data.
                        -->
                <img src="https://placehold.co/150x150/000/fff?text=QR+Code"
                  alt="QR code for {{ $student->first_name }}" class="w-32 h-32 md:w-40 md:h-40 object-cover rounded">
              </div>
            </div>
          @endforeach
        @else
          <!-- Message to display if no students are found -->
          <div class="text-center text-gray-500 py-10">
            <p>No students to display.</p>
          </div>
        @endif
      </div>
    </div>
  </body>

</html>
