<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

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

        .choice {
            display: inline-flex;
            background-color: var(--primary-color);
            border-radius: 50px; /* Sudut sangat membulat */
            padding: 3px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .choice a {
            z-index: 111; 
            text-decoration: none;
            color: #fff;
        }

        .choice-btn {
            text-decoration: none;
            color: #495057;
            padding: 8px 15px;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: block;
            text-align: center;
        }

        .form-section {
            align-items: center;
            display: flex;
            min-height: 100vh
        }

        #form_adopter h1 {
            margin-right: 10rem;
        }

        #form_shelter h1 {
            margin-right: 6.7rem;
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
            height: 100vh;
            float: right;
            display: block;
        }

        .choice-btn.active-choice {
            background-color: #20c997;
            color: white;
            box-shadow: 0 2px 5px rgba(32, 201, 151, 0.4);
        }

        .choice-btn:not(.active-choice):hover {
            background-color: #dee2e6;
            color: #343a40;
        }
    </style>
</head>

<body>
    <div class="container-fluid login-container d-flex position-relative">
        <div class="choice my-2 ms-2 align-self-start">
            <a class="choice-btn pointer" id="btn_adopter" onclick="gantiKeAdopter()">Adopter</a>
            <a class="choice-btn pointer" id="btn_shelter" onclick="gantiKeShelter()">Shelter</a>
        </div>
        <div class="col-7 form-section justify-content-center position-absolute py-5">
            <div>
                <div id="form_adopter">
                    <h1 class="fw-bold mb-1">Mulai Sekarang</h1>
                    <h6 class="fw-bold">Adopsi, berbagi, dan peduli</h6>
                    <form method="POST" action="{{ route('register') }}" class="mt-4" enctype="multipart/form-data">
                        @csrf
                        <div id="tahap_1_adopter">
                            <div class="mb-4">
                                <label for="nama_lengkap" class="form-label mb-0">Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" class="form-control" id="nama_lengkap"
                                    placeholder="Masukkan nama lengkap anda">
                            </div>
                            <div class="mb-4">
                                <label for="email" class="form-label mb-0">Email</label>
                                <input type="text" name="email" class="form-control" id="email"
                                    placeholder="Masukkan email anda">
                            </div>
                            <div class="mb-4">
                                <label for="password" class="form-label mb-0">Kata Sandi</label>
                                <input type="password" name="password" class="form-control" id="password"
                                    placeholder="Masukkan kata sandi anda">
                            </div>
                            <div class="mb-4">
                                <label for="confirmation_password" class="form-label mb-0">Konfirmasi kata Sandi</label>
                                <input type="password" name="confirmation_password" class="form-control"
                                    id="confirmation_password" placeholder="Masukkan konfirmasi kata sandi anda">
                            </div>
                            <button type="button" class="btn btn-primary w-100 fw-bold"
                                onclick="validasiAdopterTahap1()">
                                <span>Selanjutnya</span>
                            </button>
                        </div>

                        <div id="tahap_2_adopter" class="d-none">
                            <div class="mb-4">
                                <label for="alamat" class="form-label mb-0">Alamat</label>
                                <input type="text" name="alamat" class="form-control" id="alamat"
                                    placeholder="Masukkan alamat anda">
                            </div>
                            <div class="mb-4">
                                <label for="usia" class="form-label mb-0">Usia</label>
                                <input type="text" name="usia" class="form-control" id="usia"
                                    placeholder="Masukkan usia anda">
                            </div>
                            <div class="mb-4">
                                <label for="pekerjaan" class="form-label mb-0">Pekerjaan</label>
                                <input type="text" name="pekerjaan" class="form-control" id="pekerjaan"
                                    placeholder="Masukkan pekerjaan anda">
                            </div>
                            <div class="mb-4">
                                <label for="no_handphone" class="form-label mb-0">No Handphone</label>
                                <input type="text" name="no_handphone" class="form-control" id="no_handphone"
                                    placeholder="Masukkan no handphone anda">
                            </div>
                            <div class="mb-4">
                                <label for="no_whatsapp" class="form-label mb-0">No Whatsapp</label>
                                <input type="text" name="no_whatsapp" class="form-control" id="no_whatsapp"
                                    placeholder="Masukkan no whatsapp anda">
                            </div>
                            <div class="mb-4">
                                <label for="foto" class="form-label mb-0">Foto</label>
                                <input type="file" name="foto" class="form-control" id="foto"
                                    placeholder="Masukkan foto anda">
                            </div>
                            <button type="button" class="btn btn-primary w-100 fw-bold"
                                onclick="validasiAdopterTahap2()">
                                <span>Sign up</span>
                            </button>
                        </div>
                    </form>
                </div>

                <div id="form_shelter" class="d-none">
                    <h1 class="fw-bold mb-1">Isi data sheltermu</h1>
                    <form method="POST" class="mt-4" enctype="multipart/form-data">
                        @csrf
                        <div id="tahap_1_shelter">
                            <div class="mb-4">
                                <label for="nama_shelter" class="form-label mb-0">Nama shelter</label>
                                <input type="text" name="nama_shelter" class="form-control" id="nama_shelter"
                                    placeholder="Masukkan nama shelter">
                            </div>
                            <div class="mb-4">
                                <label for="email_shelter" class="form-label mb-0">Email shelter</label>
                                <input type="text" name="email_shelter" class="form-control" id="email_shelter"
                                    placeholder="Masukkan email shelter">
                            </div>
                            <div class="mb-4">
                                <label for="alamat_shelter" class="form-label mb-0">Alamat shelter</label>
                                <input type="text" name="alamat_shelter" class="form-control" id="alamat_shelter"
                                    placeholder="Masukkan alamat shelter">
                            </div>
                            <div class="mb-4">
                                <label for="no_telepon_shelter" class="form-label mb-0">No telepon shelter</label>
                                <input type="text" name="no_telepon_shelter" class="form-control"
                                    id="no_telepon_shelter" placeholder="Masukkan no telepon shelter">
                            </div>
                            <button type="button" class="btn btn-primary w-100 fw-bold"
                                onclick="validasiShelterTahap1()">
                                <span>Selanjutnya</span>
                            </button>
                        </div>

                        <div id="tahap_2_shelter" class="d-none">
                            <div class="mb-4">
                                <label for="foto_shelter" class="form-label mb-0">Foto shelter</label>
                                <input type="file" name="foto_shelter" class="form-control" id="foto_shelter">
                            </div>
                            <div class="mb-4">
                                <label for="dokumen_legal" class="form-label mb-0">Dokumen legalitas pendirian
                                    shelter</label>
                                <input type="file" name="dokumen_legal" class="form-control" id="dokumen_legal">
                            </div>
                            <div class="mb-4">
                                <label for="deskripsi_shelter" class="form-label mb-0">Deskripsi singkat
                                    shelter</label>
                                <input type="text" name="deskripsi_shelter" class="form-control"
                                    id="deskripsi_shelter" placeholder="Masukkan deskripsi shelter">
                            </div>
                            <div class="mb-4">
                                <label for="password_shelter" class="form-label mb-0">Kata Sandi</label>
                                <input type="password" name="password_shelter" class="form-control"
                                    id="password_shelter" placeholder="Masukkan kata sandi anda">
                            </div>
                            <div class="mb-4">
                                <label for="confirmation_password_shelter" class="form-label mb-0">Konfirmasi kata
                                    Sandi</label>
                                <input type="password" name="confirmation_password_shelter" class="form-control"
                                    id="confirmation_password_shelter"
                                    placeholder="Masukkan konfirmasi kata sandi anda">
                            </div>
                            <button type="button" class="btn btn-primary w-100 fw-bold"
                                onclick="validasiShelterTahap2()">
                                <span>Kirim</span>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="d-flex align-items-center my-4">
                    <hr class="flex-grow-1">
                    <span class="mx-2">atau</span>
                    <hr class="flex-grow-1">
                </div>

                <div class="text-center">
                    <label>Sudah punya akun?</label>
                    <a href="{{ route('login') }}" class="text-decoration-none pointer">Sign in</a>
                </div>
            </div>
        </div>

        <div class="col-5 img-container p-0 position-fixed">
            <img src="{{ asset('image/register2.jpg') }}" alt="Login Image">
        </div>
    </div>

    @include('sweetalert::alert')
    @include('layout.loading')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        var dataAdopterTahap1 = {}
        var dataShelterTahap1 = {}

        function toggleChoiceButton(activeId) {
            const adopterBtn = document.getElementById('btn_adopter');
            const shelterBtn = document.getElementById('btn_shelter');

            adopterBtn.classList.remove('active-choice');
            shelterBtn.classList.remove('active-choice');

            if (activeId === 'adopter') {
                adopterBtn.classList.add('active-choice');
            } else if (activeId === 'shelter') {
                shelterBtn.classList.add('active-choice');
            }
        }

        function gantiKeAdopter() {
            document.getElementById('form_adopter').classList.remove('d-none');
            document.getElementById('form_shelter').classList.add('d-none');
            document.getElementById('tahap_1_adopter').classList.remove('d-none');
            document.getElementById('tahap_2_adopter').classList.add('d-none');

            toggleChoiceButton('adopter');
        }

        function gantiKeShelter() {
            document.getElementById('form_adopter').classList.add('d-none');
            document.getElementById('form_shelter').classList.remove('d-none');
            document.getElementById('tahap_1_shelter').classList.remove('d-none');
            document.getElementById('tahap_2_shelter').classList.add('d-none');

            toggleChoiceButton('shelter');
        }

        function validasiAdopterTahap1() {
            document.getElementById('fullscreen-loading').classList.remove('d-none')
            const data = {
                nama_lengkap: document.getElementById('nama_lengkap').value,
                email: document.getElementById('email').value,
                password: document.getElementById('password').value,
                confirmation_password: document.getElementById('confirmation_password').value,
                csrf_token: '{{ csrf_token() }}'
            }
            document.querySelectorAll('.error-validasi1').forEach(e => e.remove())
            fetch('{{ route('register.validasiAdopterTahap1') }}', {
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
                    dataAdopterTahap1 = data
                    document.getElementById('tahap_1_adopter').classList.add('d-none')
                    document.getElementById('tahap_2_adopter').classList.remove('d-none')
                }
            })
        }

        function validasiAdopterTahap2() {
            document.getElementById('fullscreen-loading').classList.remove('d-none')
            const formData = new FormData()
            formData.append('alamat', document.getElementById('alamat').value)
            formData.append('usia', document.getElementById('usia').value)
            formData.append('pekerjaan', document.getElementById('pekerjaan').value)
            formData.append('no_handphone', document.getElementById('no_handphone').value)
            formData.append('no_whatsapp', document.getElementById('no_whatsapp').value)
            formData.append('foto', document.getElementById('foto').files[0])
            formData.append('_token', '{{ csrf_token() }}')

            document.querySelectorAll('.error-validasi2').forEach(e => e.remove())
            fetch('{{ route('register.validasiAdopterTahap2') }}', {
                method: "POST",
                headers: {
                    "Accept": "Application/json",
                },
                body: formData
            })
            .then(res => res.json())
            .then(res => {
                document.getElementById('fullscreen-loading').classList.add('d-none')
                if (res.errors) {
                    for (const key in res.errors) {
                        const input = document.getElementById(key)
                        if (input) {
                            const div = document.createElement('div')
                            div.className = 'text-danger mt-1 fs-7 error-validasi2'
                            div.innerText = res.errors[key][0]
                            input.parentNode.appendChild(div)
                        }
                    }
                } else if (res.success) {
                    const finalFormData = new FormData()
                    for (const key in dataAdopterTahap1) {
                        if (key !== 'csrf_token' && key !== 'confirmation_password') {
                            finalFormData.append(key, dataAdopterTahap1[key])
                        }
                    }
                    finalFormData.append('password', dataAdopterTahap1.password);
                    finalFormData.append('alamat', document.getElementById('alamat').value)
                    finalFormData.append('usia', document.getElementById('usia').value)
                    finalFormData.append('pekerjaan', document.getElementById('pekerjaan').value)
                    finalFormData.append('no_handphone', document.getElementById('no_handphone').value)
                    finalFormData.append('no_whatsapp', document.getElementById('no_whatsapp').value)
                    finalFormData.append('foto', document.getElementById('foto').files[0])
                    finalFormData.append('_token', '{{ csrf_token() }}')

                    document.getElementById('fullscreen-loading').classList.remove('d-none')

                    fetch('{{ route('registerAdopter') }}', {
                        method: "POST",
                        headers: {
                            "Accept": "Application/json",
                        },
                        body: finalFormData
                    })
                    .then(res => res.json())
                    .then(res => {
                        document.getElementById('fullscreen-loading').classList.add('d-none')
                        if (res.errors) {
                            Swal.fire({
                                icon: 'error',
                                title: res.title,
                                text: response.message
                            });
                        } else if (res.success) {
                            Swal.fire({
                                icon: 'success',
                                title: res.title,
                                text: res.message,
                                showConfirmButton: false,
                                timer: 1500
                            })
                            .then(() => {
                                window.location.href = res.redirect
                            })
                        }
                    })
                }
            })
        }

        function validasiShelterTahap1() {
            document.getElementById('fullscreen-loading').classList.remove('d-none')
            const data = {
                nama_shelter: document.getElementById('nama_shelter').value,
                email_shelter: document.getElementById('email_shelter').value,
                alamat_shelter: document.getElementById('alamat_shelter').value,
                no_telepon_shelter: document.getElementById('no_telepon_shelter').value,
                csrf_token: '{{ csrf_token() }}'
            }
            document.querySelectorAll('.error-validasi1').forEach(e => e.remove())
            fetch('{{ route('register.validasiShelterTahap1') }}', {
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
                    dataShelterTahap1 = data
                    document.getElementById('tahap_1_shelter').classList.add('d-none')
                    document.getElementById('tahap_2_shelter').classList.remove('d-none')
                }
            })
        }

        function validasiShelterTahap2() {
            document.getElementById('fullscreen-loading').classList.remove('d-none')
            const formData = new FormData()
            formData.append('foto_shelter', document.getElementById('foto_shelter').files[0])
            formData.append('dokumen_legal', document.getElementById('dokumen_legal').files[0])
            formData.append('deskripsi_shelter', document.getElementById('deskripsi_shelter').value)
            formData.append('password_shelter', document.getElementById('password_shelter').value)
            formData.append('confirmation_password_shelter', document.getElementById('confirmation_password_shelter').value)
            formData.append('_token', '{{ csrf_token() }}')

            document.querySelectorAll('.error-validasi2').forEach(e => e.remove())
            fetch('{{ route('register.validasiShelterTahap2') }}', {
                method: "POST",
                headers: {
                    "Accept": "Application/json",
                },
                body: formData
            })
            .then(res => res.json())
            .then(res => {
                document.getElementById('fullscreen-loading').classList.add('d-none')
                if (res.errors) {
                    for (const key in res.errors) {
                        const input = document.getElementById(key)
                        if (input) {
                            const div = document.createElement('div')
                            div.className = 'text-danger mt-1 fs-7 error-validasi2'
                            div.innerText = res.errors[key][0]
                            input.parentNode.appendChild(div)
                        }
                    }
                } else if (res.success) {
                    const finalFormData = new FormData()
                    for (const key in dataShelterTahap1) {
                        if (key !== 'csrf_token') {
                            finalFormData.append(key, dataShelterTahap1[key])
                        }
                    }
                    finalFormData.append('foto_shelter', document.getElementById('foto_shelter').files[0])
                    finalFormData.append('dokumen_legal', document.getElementById('dokumen_legal').files[0])
                    finalFormData.append('deskripsi_shelter', document.getElementById('deskripsi_shelter').value)
                    finalFormData.append('password_shelter', document.getElementById('password_shelter').value)
                    finalFormData.append('confirmation_password_shelter', document.getElementById('confirmation_password_shelter').value)
                    finalFormData.append('_token', '{{ csrf_token() }}')

                    document.getElementById('fullscreen-loading').classList.remove('d-none')

                    fetch('{{ route('registerShelter') }}', {
                        method: "POST",
                        headers: {
                            "Accept": "Application/json",
                        },
                        body: finalFormData
                    })
                    .then(res => res.json())
                    .then(res => {
                        document.getElementById('fullscreen-loading').classList.add('d-none')
                        if (res.errors) {
                            Swal.fire({
                                icon: 'error',
                                title: res.title,
                                text: response.message
                            });
                        } else if (res.success) {
                            Swal.fire({
                                icon: 'success',
                                title: res.title,
                                text: res.message,
                                showConfirmButton: false,
                                timer: 1500
                            })
                            .then(() => {
                                window.location.href = res.redirect
                            })
                        }
                    })
                }
            })
        }
    </script>
</body>

</html>
