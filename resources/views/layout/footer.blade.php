<style>
    .row {
        margin: 0;
    }

    .logo-image-footer {
        width: 150px;
        transition: transform 0.3s ease;
    }

    .logo-image-footer:hover {
        transform: scale(1.05);
    }

    div h5 {
        font-weight: bold;
        font-size: 1.3rem !important;
    }

    footer a {
        transition: color 0.3s ease, transform 0.2s ease;
        display: inline-block;
    }

    footer a:hover {
        transform: translateX(5px);
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

<footer class="primary-color bottom-0 w-100">
    <div class="container py-4 text-white">
        <div class="row d-flex justify-content-center justify-content-start footer-content">
            <div class="col-12 col-md-3">
                <a href="{{ Auth::check() ? route('beranda.' . Auth::user()->tipe_pengguna . 'Beranda') : route('beranda.adopterBeranda') }}">
                    <img src="{{ asset('image/logo.png') }}" alt="Logo Image" class="logo-image-footer">
                </a>
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
                    <li class="nav-item mb-2">
                        <a href="{{ route('tentangKami') }}" style="text-decoration: none; color: white;">
                            Tentang Kami
                        </a>
                    </li>
                </ul>
            </div>

            @if (Auth::check() && Auth::user()->tipe_pengguna === 'shelter')
                <div class="col-12 col-md-2">
                    <h5>Layanan Kami</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2">
                            <a href="{{ route('shelter.daftar.pengajuan.adopsi.hewan') }}" style="text-decoration: none; color: white;">
                                Daftar Pengajuan Adopsi
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="{{ route('shelter.daftar.pengajuan.penyerahan.hewan') }}" style="text-decoration: none; color: white;">
                                Daftar Pengajuan Penyerahan Hewan
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="{{ route('shelter.riwayat.pengambilan.hewan') }}" style="text-decoration: none; color: white;">
                                Riwayat Pengambilan Hewan Adopter
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="{{ route('shelter.riwayat.pengajuan.adopsi') }}" style="text-decoration: none; color: white;">
                                Riwayat Pengajuan Adopsi Hewan
                            </a>
                        </li>
                    </ul>
                </div>
            @elseif (Auth::check() && Auth::user()->tipe_pengguna === 'admin')
                <div class="col-12 col-md-2">
                    <h5>Layanan Kami</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2">
                            <a href="{{ route('beranda.adminBeranda') }}" style="text-decoration: none; color: white;">
                                Daftar Pengajuan Pendaftaran Shelter
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="{{ route('admin.riwayatPendaftaran') }}" style="text-decoration: none; color: white;">
                                Daftar Riwayat Pendaftaran Shelter
                            </a>
                        </li>
                    </ul>
                </div>
            @else
                <div class="col-12 col-md-2">
                    <h5>Layanan Kami</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2">
                            <a href="{{ route('adopter.daftarHewan') }}" style="text-decoration: none; color: white;">
                                Pengajuan Adopsi
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="{{ route('adopter.showLepasAdopsi') }}" style="text-decoration: none; color: white;">
                                Penyerahan Adopsi
                            </a>
                        </li>
                    </ul>
                </div>
            @endif

            <div class="col-12 col-md-2">
                <h5>Lainnya</h5>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2">
                        <a href="https://youtube.com/@pawslife67?si=7zHJkxYMSREMvJjY" target="_blank" rel="noopener noreferrer" style="text-decoration: none; color: white;">
                            Youtube - Pawslife
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="https://www.instagram.com/pawslife67?igsh=cmd4aDEyaGppajJm" target="_blank" rel="noopener noreferrer" style="text-decoration: none; color: white;">
                            Instagram - Pawslife
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="https://x.com/pawslife67?t=0pKmIDJknrIMr4kTAbQxrw&s=09" target="_blank" rel="noopener noreferrer" style="text-decoration: none; color: white;">
                            X - Pawslife
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="https://www.tiktok.com/@pawslife67" target="_blank" rel="noopener noreferrer" style="text-decoration: none; color: white;">
                            TikTok - Pawslife
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <hr class="text-white container border-3">
    <div class="container d-flex justify-content-center align-content-center">
        <h6 class="text-white fw-bold">&copy; {{ date('Y') }} Pawslife. All rights reserved.</h6>
    </div>
</footer>
