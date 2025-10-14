<style>
    .logo-image {
        width: 55px;
    }

    .navbar{
        background-color: #ffffff;
        border-bottom: 1px solid #e5e5e5;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }
    
    .nav-link {
        color: #333;
        font-weight: 500;
        padding: 0.5rem 1rem !important;
        transition: color 0.3s ease, border-bottom 0.3s ease;
    }

    .nav-link:hover {
        color: var(--primary-color);
        /* transform: translateY(-2px); */
    }

    .nav-link.active {
        color: var(--primary-color) !important;
        border-bottom: 2px solid var(--primary-color);
    }

    .auth-text {
        color: black;
        text-decoration: none;
        font-weight: bold;
    }

    .auth-text:hover {
        transform: translateY(-2px);
    }

    .profile-image-navbar {
        object-fit: cover;
    }

    .dropdown:hover .dropdown-menu {
        display: block;
        margin-top: 0;
    }

    @media (max-width: 991.98px) {
        .container {
            --bs-gutter-x: 0 !important;
        }

        .navbar-nav .nav-item {
            text-align: center;
        }

        .auth-section {
            display: flex;
            justify-content: center;
            padding-top: 1rem;
            padding-bottom: 0.5rem;
        
        }
        .auth-section .btn {
            margin: 0 0.5rem;
        }

        .dropdown-menu {
            text-align: center;
        }
    }
</style>

<header>
    <nav class="navbar navbar-expand-lg nav-color">
        <div class="container">
            <a class="navbar-brand" href="{{ Auth::check() ? route('beranda.' . Auth::user()->tipe_pengguna . 'Beranda') : route('beranda.adopterBeranda') }}">
                <img src="{{ asset('image/AppLogo.png') }}" alt="Logo Image" class="logo-image">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="toggle navigation">
                <i class="fa-solid fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse justify-content-lg-end" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        @if (Auth::check())
                            <a class="nav-link {{request()->routeIs('beranda.*') ? 'active' : ''}}" href="{{ route('beranda.' . Auth::user()->tipe_pengguna . 'Beranda') }}">Beranda</a>
                        @else
                            <a class="nav-link" href="{{ route('beranda.adopterBeranda') }}">Beranda</a>
                        @endif
                    </li>

                    @if (Auth::check() && Auth::user()->tipe_pengguna == 'adopter')
                        <li class="nav-item"><a class="nav-link" href="{{ route('adopter.daftarShelter') }}">Shelter</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#" id="riwayatDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Riwayat
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="riwayatDropdown">
                                <li><a class="dropdown-item" href="{{ route('adopter.showRiwayatPengajuanAdopsi') }}">Riwayat pengajuan adopsi</a></li>
                                <li><a class="dropdown-item" href="{{ route('adopter.showRiwayatPenyerahanHewan') }}">Riwayat penyerahan hewan</a></li>
                            </ul>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('adopter.showLepasAdopsi') }}">Lepas Adopsi</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('tentangKami') }}">Tentang Kami</a></li>
                    @elseif (Auth::check() && Auth::user()->tipe_pengguna == 'shelter')
                        <li class="nav-item"><a class="nav-link {{request()->routeIs('shelter.data.hewan') ? 'active' : ''}}" href="{{ route('shelter.data.hewan') }}">Data Hewan</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link {{request()->routeIs('shelter.daftar.pengajuan.*') ? 'active' : ''}}" href="#" id="daftarPengajuanDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Daftar Pengajuan
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="daftarPengajuanDropdown">
                                <li><a class="dropdown-item {{request()->routeIs('shelter.daftar.pengajuan.adopsi.hewan') ? 'active' : ''}}" href="{{ route('shelter.daftar.pengajuan.adopsi.hewan') }}">Daftar pengajuan adopsi</a></li>
                                <li><a class="dropdown-item {{request()->routeIs('shelter.daftar.pengajuan.penyerahan.hewan') ? 'active' : ''}}" href="{{ route('shelter.daftar.pengajuan.penyerahan.hewan') }}">Daftar pengajuan penyerahan hewan</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#" id="riwayatShelterDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Riwayat
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="riwayatShelterDropdown">
                                <li><a class="dropdown-item" href="#">Riwayat pengambilan hewan adopter</a></li>
                                <li><a class="dropdown-item" href="#">Riwayat hewan yang telah diadopsi</a></li>
                            </ul>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('tentangKami') }}">Tentang Kami</a></li>
                    @elseif (Auth::check() && Auth::user()->tipe_pengguna == 'admin')
                        <li class="nav-item"><a class="nav-link" href="">Shelter</a></li>
                        <li class="nav-item"><a class="nav-link" href="">Riwayat</a></li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('adopter.daftarShelter') }}">Shelter</a></li>
                        <li class="nav-item"><a class="nav-link" href="">Riwayat</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('adopter.showLepasAdopsi') }}">Lepas Adopsi</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('tentangKami') }}">Tentang Kami</a></li>
                    @endif
                </ul>

                <div class="auth-section d-flex align-items-center">
                    @auth
                        <button class="btn p-0 me-2">
                            @if (Auth::user()->tipe_pengguna === 'adopter' && Auth::user()->adopter)
                                <a href="{{ route('adopter.daftarFavorit') }}"><i class="fa-solid fa-heart fa-2xl" style="color: #ff0000;"></i></a>
                            @endif
                        </button>
                        <button class="btn ps-3"> 
                            @if(Auth::user()->tipe_pengguna === 'adopter' && Auth::user()->adopter)
                                <a href="{{ route('adopter.profile') }}">
                                    <img src="{{ asset('storage/' . Auth::user()->adopter->foto_adopter) }}" width="40" height="40" class="rounded-circle profile-image-navbar" alt="Foto Adopter">
                                </a>
                            @elseif(Auth::user()->tipe_pengguna === 'shelter' && Auth::user()->shelter)
                                <a>
                                    <img src="{{ asset('storage/' . Auth::user()->shelter->foto_shelter) }}" width="40" height="40" class="rounded-circle profile-image-navbar" alt="Foto Shelter">
                                </a>
                            @endif
                        </button>
                        @else
                            <a href="{{ route('login') }}" class="auth-text me-3 cursor">Log In</a>
                            <a href="{{ route('register') }}" class="auth-text cursor">Daftar Sekarang</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
</header>
