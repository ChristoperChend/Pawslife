<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    integrity="sha512-pDheP7X0tVm+v3WgN5+WLoNN54J9USsPOXxUdr5q2TqQ9V/wXxqmYwEoZgO2rJ5gvF+uGtt2oU5oYzQX8a9Drw=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Pawslife</title>
</head>

<body>
    {{-- <div class="position-relative min-vh-100"> --}}
    <div class="d-flex flex-column min-vh-100">
        @include('layout.navbar')

        <div class="position-relative" style="background-color: #EFEEF1">
            @yield('content')
        </div>
        <div class="mt-auto">
            @include('layout.footer')
        </div>
        
    </div>
</body>

</html>
