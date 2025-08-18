<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Laravel</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
</head>

<body>
  <div>
    <h1>Student List</h1>
    <ul>
      @foreach ($students as $student)
        <li style="margin: 10px">{{ $student->first_name }} - {{ $student->last_name }} {!! $student->qrCode->qr_code !!}</li>
      @endforeach
    </ul>
  </div>
</body>

</html>
