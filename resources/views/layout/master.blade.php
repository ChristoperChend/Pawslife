<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Pawslife</title>
</head>

<body>
    {{-- <div class="position-relative min-vh-100"> --}}
    <div class="d-flex flex-column min-vh-100">
        @include('layout.navbar')

        {{-- EFEEF1 --}}
        <div class="position-relative" style="background-color: rgb(250, 250, 250); margin-top: 80px;">
            @yield('content')
        </div>
        <div class="mt-auto">
            @include('layout.footer')
        </div>
        
    </div>
</body>

</html>
