<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $judul }}</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/logopabrik.png') }}">
    @stack('head')
</head>
<body>
    @yield('content')
    @stack('scripts')
     <script>
         <x-alert></x-alert>
     </script>
</body>
</html>
