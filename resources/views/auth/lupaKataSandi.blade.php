<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        #masukkan-otp {
            padding-right: 45px;
        }

        #masukkan-kata-sandi {
            padding-right: 74px;
        }
    </style>
</head>

<body>
    <div class="container-fluid login-container d-flex position-relative">
        <div class="col-12 col-md-7 d-flex min-vh-100 justify-content-center align-items-center position-absolute p-3">
            <div>
                <h1 id="title-masukkan-email" class="fw-bold mb-1">Lupa Kata Sandi?</h1>
                <h6 id="masukkan-email" class="fw-bold">Masukkan email anda untuk mengatur ulang kata sandi</h6>
                
                <h6 id="masukkan-otp" class="fw-bold d-none">Masukkan OTP yang sudah kami kirimkan ke email</h6>
                
                <h1 id="title-masukkan-kata-sandi" class="fw-bold mb-1 d-none">Ganti Kata Sandi!</h1>
                <h6 id="masukkan-kata-sandi" class="fw-bold d-none">Masukkan kata sandi yang susah untuk diretas</h6>
                <!-- Form -->
                <form id="form-email" method="POST" action="{{ route('login') }}" class="mt-4">
                    @csrf
                    <!-- Email -->
                    <div class="mb-5">
                        <label for="email" class="form-label mb-0">Email</label>
                        <input type="text" name="email" value="{{ old('email') }}" class="form-control"
                            id="email" placeholder="Masukkan email anda">
                        @error('email')
                            <div class="text-danger mt-1 fs-7">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="button" class="btn btn-primary w-100 fw-bold" onclick="validasiEmail()">Kirim OTP</button>
                    <div class="d-flex justify-content-between mt-2">
                        <a href="{{ route('login') }}" class=" text-decoration-none">Login</a>
                        <a href="{{ route('register') }}" class=" text-decoration-none">Sign up</a>
                    </div>
                </form>

                <form id="form-otp" method="POST" action="{{ route('login') }}" class="mt-4 d-none">
                    @csrf
                    <!-- OTP -->
                    <div class="mb-5">
                        <label for="OTP" class="form-label mb-0">OTP</label>
                        <input type="text" name="OTP" class="form-control" id="OTP" placeholder="Masukkan OTP">
                    </div>
                    <button type="button" class="btn btn-primary w-100 fw-bold" onclick="validasiOTP()">Verifikasi</button>
                </form>

                <form id="form-kata-sandi" method="POST" action="{{ route('login') }}" class="mt-4 d-none">
                    @csrf
                    <!-- kata sandi -->
                    <div class="mb-5">
                        <div class="mb-4">
                            <label for="kata_sandi" class="form-label">Kata sandi baru</label>
                            <input type="password" name="kata_sandi" class="form-control" id="kata_sandi" placeholder="Masukkan kata sandi baru">
                        </div>
                        <div class="">
                            <label for="konfirmasi_kata_sandi" class="form-label mb-0">Konfirmasi kata sandi baru</label>
                            <input type="password" name="konfirmasi_kata_sandi" class="form-control" id="konfirmasi_kata_sandi" placeholder="Masukkan konfirmasi kata sandi baru">
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary w-100 fw-bold" onclick="gantiKataSandi()">Konfirmasi</button>
                </form>
            </div>
        </div>
        <!-- Image -->
        <div class="col-5 img-container p-0 position-fixed d-none d-md-block">
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

        function validasiEmail() {
            document.getElementById('fullscreen-loading').classList.remove('d-none')
            const data = {
                email: document.getElementById('email').value,
                csrf_token: '{{ csrf_token() }}'
            }
            document.querySelectorAll('.error-validasi1').forEach(e => e.remove())
            fetch('{{ route('lupaKataSandi.validasiEmail') }}', {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "Application/json",
                    "X-CSRF-TOKEN": data.csrf_token
                },
                body: JSON.stringify(data)
            })
            .then(res => res.json())
            .then(res => {
                document.getElementById('fullscreen-loading').classList.add('d-none')
                if (res.errors) {
                    for (const key in res.errors) {
                        const input = document.getElementById(key)
                        if (input) {
                            const div = document.createElement('div')
                            div.className = 'text-danger mt-1 fs-7 error-validasi1'
                            div.innerText = res.errors[key][0]
                            input.parentNode.appendChild(div)
                        }
                    }
                } else if (res.success) {
                    Swal.fire({
                        icon: 'success',
                        title: res.title,
                        text: res.message,
                        customClass: {
                            actions: 'swal-actions-gap',
                            icon: 'swal-success-primary',
                            confirmButton: 'btn btn-primary-color',
                        },
                        buttonsStyling: false
                    });

                    document.getElementById('form-email').classList.add('d-none')
                    document.getElementById('form-otp').classList.remove('d-none')

                    document.getElementById('masukkan-email').classList.add('d-none')
                    document.getElementById('masukkan-otp').classList.remove('d-none')
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: res.title,
                        text: res.message,
                        customClass: {
                            actions: 'swal-actions-gap',
                            confirmButton: 'btn btn-primary-color',
                        },
                        buttonsStyling: false
                    });
                }
            })
        }

        function validasiOTP() {
            document.getElementById('fullscreen-loading').classList.remove('d-none')
            const data = {
                email: document.getElementById('email').value,
                otp: document.getElementById('OTP').value,
                csrf_token: '{{ csrf_token() }}'
            }
            document.querySelectorAll('.error-validasi1').forEach(e => e.remove())
            fetch('{{ route('lupaKataSandi.validasiOTP') }}', {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "Application/json",
                    "X-CSRF-TOKEN": data.csrf_token
                },
                body: JSON.stringify(data)
            })
            .then(res => res.json())
            .then(res => {
                document.getElementById('fullscreen-loading').classList.add('d-none')
                if (res.errors) {
                    for (const key in res.errors) {
                        const input = document.getElementById(key)
                        if (input) {
                            const div = document.createElement('div')
                            div.className = 'text-danger mt-1 fs-7 error-validasi1'
                            div.innerText = res.errors[key][0]
                            input.parentNode.appendChild(div)
                        }
                    }
                    Swal.fire({
                        icon: 'error',
                        title: res.errors.title,
                        text: res.errors.message,
                        customClass: {
                            actions: 'swal-actions-gap',
                            confirmButton: 'btn btn-primary-color',
                        },
                        buttonsStyling: false
                    });
                } else if (res.success) {
                    document.getElementById('title-masukkan-kata-sandi').classList.remove('d-none')
                    document.getElementById('masukkan-kata-sandi').classList.remove('d-none')

                    document.getElementById('title-masukkan-email').classList.add('d-none')
                    document.getElementById('masukkan-otp').classList.add('d-none')

                    document.getElementById('form-otp').classList.add('d-none')
                    document.getElementById('form-kata-sandi').classList.remove('d-none')
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: res.title,
                        text: res.message,
                        customClass: {
                            actions: 'swal-actions-gap',
                            confirmButton: 'btn btn-primary-color',
                        },
                        buttonsStyling: false
                    });
                }
            })
        }

        function gantiKataSandi() {
            document.getElementById('fullscreen-loading').classList.remove('d-none')
            const data = {
                email: document.getElementById('email').value,
                otp: document.getElementById('OTP').value,
                kata_sandi: document.getElementById('kata_sandi').value,
                konfirmasi_kata_sandi: document.getElementById('konfirmasi_kata_sandi').value,
                csrf_token: '{{ csrf_token() }}'
            }
            document.querySelectorAll('.error-validasi1').forEach(e => e.remove())
            fetch('{{ route('lupaKataSandi.gantiKataSandi') }}', {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "Application/json",
                    "X-CSRF-TOKEN": data.csrf_token
                },
                body: JSON.stringify(data)
            })
            .then(res => res.json())
            .then(res => {
                document.getElementById('fullscreen-loading').classList.add('d-none')
                if (res.errors) {
                    for (const key in res.errors) {
                        const input = document.getElementById(key)
                        if (input) {
                            const div = document.createElement('div')
                            div.className = 'text-danger mt-1 fs-7 error-validasi1'
                            div.innerText = res.errors[key][0]
                            input.parentNode.appendChild(div)
                        }
                    }
                    Swal.fire({
                        icon: 'error',
                        title: res.errors.title,
                        text: res.errors.message,
                        customClass: {
                            actions: 'swal-actions-gap',
                            confirmButton: 'btn btn-primary-color',
                        },
                        buttonsStyling: false
                    });
                } else if (res.success) {
                    Swal.fire({
                        icon: 'success',
                        title: res.title,
                        text: res.message,
                        customClass: {
                            actions: 'swal-actions-gap',
                            icon: 'swal-success-primary',
                            confirmButton: 'btn btn-primary-color',
                        },
                        buttonsStyling: false
                    }).then(() => {
                        window.location.href = res.redirect
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: res.title,
                        text: res.message,
                        customClass: {
                            actions: 'swal-actions-gap',
                            confirmButton: 'btn btn-primary-color',
                        },
                        buttonsStyling: false
                    });
                }
            })
        }
    </script>
</body>

</html>
