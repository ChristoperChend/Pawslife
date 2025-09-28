<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
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

        .form-column {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 15px;
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
            object-fit: cover;
        }

        @media (max-width: 991.98px) {
            .img-container {
                min-height: 0px;
                height: 0px;
            }
            .img-container img {
                display: none;
            }
            
            .form-column {
                width: 100%;
                position: static;
                transform: none;
                min-height: 100vh;
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid login-container d-flex flex-column flex-md-row">
        <div class="col-12 col-md-7 form-column">
            <div>
                <h1 class="fw-bold mb-1">Selamat Datang!</h1>
                <h6 class="fw-bold">Masukkan kredensial anda untuk mengakses akun anda</h6>
                <form method="POST" action="{{ route('login') }}" class="mt-4">
                    @csrf
                    <div class="mb-4">
                        <label for="email" class="form-label mb-0">Email</label>
                        <input type="text" name="email" value="{{ old('email') }}" class="form-control"
                            id="email" placeholder="Masukkan email anda">
                        @error('email')
                            <div class="text-danger mt-1 fs-7">{{ $message }}</div>
                        @enderror
                    </div>
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
                    <div class="form-check mb-4">
                        <input type="checkbox" name="remember" class="form-check-input" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Ingat selama 7 hari</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 fw-bold">Login</button>
                </form>
                <div class="d-flex align-items-center my-4">
                    <hr class="flex-grow-1">
                    <span class="mx-2">atau</span>
                    <hr class="flex-grow-1">
                </div>
                <div class="text-center">
                    <label>Belum punya akun?</label>
                    <a href="{{ route('register') }}" class="text-decoration-none pointer">Sign up</a>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-5 img-container d-none d-md-block">
            <img src="{{ asset('image/login.jpg') }}" alt="Login Image">
        </div>
    </div>

    @include('sweetalert::alert')
    @include('layout.loading')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.querySelector('form').addEventListener('submit', function() {
            document.getElementById('fullscreen-loading').classList.remove('d-none');
        });
    </script>
</body>

</html>