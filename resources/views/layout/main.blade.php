<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $judul }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/pavicon.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/pavicon.png') }}">
<link rel="icon" type="image/png" sizes="48x48" href="{{ asset('img/pavicon.png') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/pavicon.png') }}">


</head>
<body>
    @yield('content')
</body>
</html>
