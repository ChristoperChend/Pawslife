<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        .container-fluid {
            --bs-gutter-x: 0;
        }

        .fs-7 {
            font-size: 0.8rem;
        }

        .pointer {
            cursor: pointer;
        }

        .login-container {
            height: 100vh;
        }

        .img-container {
            top: 0;
            right: 0;
            min-height: 100vh;
        }

        .img-container img {
            width: 100%;
            height: 100%;
            float: right;
            display: block;
        }
    </style>
</head>

<body>
    <div class="container-fluid login-container d-flex position-relative">
        <div class="col-7 d-flex min-vh-100 justify-content-center align-items-center position-absolute">
            <div>
                <h1 class="fw-bold mb-1">Selamat Datang!</h1>
                <h6 class="fw-bold">Masukkan kredensial anda untuk mengakses akun anda</h6>
                <!-- Form -->
                <form method="POST" action="{{ route('login') }}" class="mt-4">
                    @csrf
                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="form-label mb-0">Email</label>
                        <input type="text" name="email" value="{{ old('email') }}" class="form-control"
                            id="email" placeholder="Masukkan email anda">
                        @error('email')
                            <div class="text-danger mt-1 fs-7">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Password -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between">
                            <label for="password" class="form-label mb-0">Kata Sandi</label>
                            <a href="{{ route('lupaKataSandi') }}" class="text-decoration-none pointer fs-7">Lupa Kata Sandi</a>
                        </div>
                        <input type="password" name="password" class="form-control" id="password"
                            placeholder="Masukkan kata sandi anda">
                        @error('password')
                            <div class="text-danger mt-1 fs-7">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Remember Me -->
                    <div class="form-check mb-4">
                        <input type="checkbox" name="remember" class="form-check-input" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Ingat selama 7 hari</label>
                    </div>
                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary w-100 fw-bold">Login</button>
                </form>
                <!-- Divider -->
                <div class="d-flex align-items-center my-4">
                    <hr class="flex-grow-1">
                    <span class="mx-2">atau</span>
                    <hr class="flex-grow-1">
                </div>
                <!-- Register -->
                <div class="text-center">
                    <label>Belum punya akun?</label>
                    <a href="{{ route('register') }}" class="text-decoration-none pointer">Sign up</a>
                </div>
            </div>
        </div>
        <!-- Image -->
        <div class="col-5 img-container p-0 position-fixed">
            <img src="{{ asset('image/login.jpg') }}" alt="Login Image">
        </div>
    </div>

    @include('sweetalert::alert')
    @include('layout.loading')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.querySelector('form').addEventListener('submit', function() {
            document.getElementById('fullscreen-loading').classList.remove('d-none');
        });
    </script>
</body>

</html>
