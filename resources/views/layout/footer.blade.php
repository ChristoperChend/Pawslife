<style>
    .row {
        margin: 0;
    }

    .logo-image-footer {
        width: 150px;
    }

    div h5 {
        font-weight: bold;
    }

    @media (max-width: 767.98px) {
        .footer-content .col-12 {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .footer-content .col-12:last-child {
            margin-bottom: 0;
        }
    }
</style>

<footer class="primary-color bottom-0 w-100 mt-5">
    <div class="container py-4 text-white">
        <div class="row d-flex justify-content-center justify-content-start footer-content">
            <div class="col-12 col-md-3">
                <img src="{{ asset('image/logo.png') }}" alt="Logo Image" class="logo-image-footer">
            </div>

            <div class="col-12 col-md-2">
                <h5>Nomor Telepon</h5>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2">+62 812-3456-7890</li>
                </ul>

                <h5>Nomor Whatsapp</h5>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2">+62 812-3456-7890</li>
                </ul>
            </div>

            <div class="col-12 col-md-2">
                <h5>Tentang Kami</h5>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2">Tentang Kami</li>
                </ul>
            </div>

            <div class="col-12 col-md-2">
                <h5>Layanan Kami</h5>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2">Pengajuan Adopsi</li>
                    <li class="nav-item mb-2">Penyerahan Adopsi</li>
                </ul>
            </div>

            <div class="col-12 col-md-2">
                <h5>Lainnya</h5>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2">Youtube - Pawslife</li>
                    <li class="nav-item mb-2">Instagram - Pawslife</li>
                    <li class="nav-item mb-2">X - Pawslife</li>
                    <li class="nav-item mb-2">Tiktok - Pawslife</li>
                </ul>
            </div>
        </div>
    </div>

    <hr class="text-white container border-3">
    <div class="container d-flex justify-content-center align-content-center">
        <h6 class="text-white fw-bold">&copy; {{ date('Y') }} Pawslife. All rights reserved.</h6>
    </div>
</footer>
