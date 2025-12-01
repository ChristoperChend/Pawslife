<style>
    .logo-image {
        width: 55px;
    }

    .navbar {
        position: fixed;
        top: 10px;
        left: 50%;
        transform: translateX(-50%);
        width: 95%;
        z-index: 1050;
        padding: 12px 20px;
        border-radius: 15px;
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(12px); 
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        transition: background 0.3s ease, box-shadow 0.3s ease;
    }
    
    .nav-link {
        color: #333;
        font-weight: 700;
        font-size: 17px;
        padding: 0.5rem 1rem !important;
        transition: color 0.3s ease, border-bottom 0.3s ease;
    }

    .nav-link:hover {
        color: var(--primary-color);
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

    .btn-favorite {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #333; /* Dark grey default to match text */
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        text-decoration: none;
    }

    .btn-favorite i {
        font-size: 1.4rem; /* More balanced size than fa-2xl */
        transition: transform 0.2s ease;
    }

    .btn-favorite:hover {
        color: #ff4757; /* A more elegant, modern red */
        transform: translateY(-2px);
    }

    .btn-favorite:hover i {
        font-weight: 900; /* Switches to solid version on hover if using FA Pro, or just stays bold */
        transform: scale(1.15); /* Heartbeat effect */
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
                            <a class="nav-link {{request()->routeIs('beranda.*') ? 'active' : ''}}" href="{{ route('beranda.adopterBeranda') }}">Beranda</a>
                        @endif
                    </li>

                    @if (Auth::check() && Auth::user()->tipe_pengguna == 'adopter')
                        <li class="nav-item"><a class="nav-link {{request()->routeIs('adopter.daftarShelter') ? 'active' : ''}}" href="{{ route('adopter.daftarShelter') }}">Shelter</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link
                                {{request()->routeIs('adopter.showRiwayatPengajuanAdopsi') || request()->routeIs('adopter.showRiwayatPenyerahanHewan') ? 'active' : ''}}"
                                href="#" id="riwayatDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"> Riwayat
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="riwayatDropdown">
                                <li><a class="dropdown-item" href="{{ route('adopter.showRiwayatPengajuanAdopsi') }}">Riwayat pengajuan adopsi</a></li>
                                <li><a class="dropdown-item" href="{{ route('adopter.showRiwayatPenyerahanHewan') }}">Riwayat penyerahan hewan</a></li>
                            </ul>
                        </li>
                        <li class="nav-item"><a class="nav-link {{request()->routeIs('adopter.showLepasAdopsi') ? 'active' : ''}}" href="{{ route('adopter.showLepasAdopsi') }}">Lepas Adopsi</a></li>
                        <li class="nav-item"><a class="nav-link {{request()->routeIs('tentangKami') ? 'active' : ''}}" href="{{ route('tentangKami') }}">Tentang Kami</a></li>
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
                                <li><a class="dropdown-item {{request()->routeIs('shelter.riwayat.pengambilan.hewan') ? 'active' : ''}}" href="{{ route('shelter.riwayat.pengambilan.hewan') }}">Riwayat pengambilan hewan adopter</a></li>
                                <li><a class="dropdown-item {{request()->routeIs('shelter.riwayat.pengajuan.adopsi') ? 'active' : ''}}" href="{{ route('shelter.riwayat.pengajuan.adopsi') }}">Riwayat pengajuan adopsi hewan</a></li>
                            </ul>
                        </li>
                        <li class="nav-item"><a class="nav-link {{request()->routeIs('shelter.persyaratan.adopsi') ? 'active' : ''}}" href="{{ route('shelter.persyaratan.adopsi') }}">Persyaratan Adopsi</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('tentangKami') }}">Tentang Kami</a></li>
                    @elseif (Auth::check() && Auth::user()->tipe_pengguna == 'admin')
                        <li class="nav-item"><a class="nav-link {{request()->routeIs('admin.riwayatPendaftaran') ? 'active' : ''}}" href="{{ route('admin.riwayatPendaftaran') }}">Riwayat</a></li>
                    @else
                        <li class="nav-item"><a class="nav-link {{request()->routeIs('adopter.daftarShelter') ? 'active' : ''}}" href="{{ route('adopter.daftarShelter') }}">Shelter</a></li>
                        <li class="nav-item"><a class="nav-link" href="">Riwayat</a></li>
                        <li class="nav-item"><a class="nav-link {{request()->routeIs('adopter.showLepasAdopsi') ? 'active' : ''}}" href="{{ route('adopter.showLepasAdopsi') }}">Lepas Adopsi</a></li>
                        <li class="nav-item"><a class="nav-link {{request()->routeIs('tentangKami') ? 'active' : ''}}" href="{{ route('tentangKami') }}">Tentang Kami</a></li>
                    @endif
                </ul>

                <div class="auth-section d-flex align-items-center">
                    @auth
                        @if (Auth::user()->tipe_pengguna === 'adopter' && Auth::user()->adopter)
                            <button class="btn p-0 me-2">
                                <a href="{{ route('adopter.daftarFavorit') }}" class="btn-favorite" title="Favorit Saya">
                                    <i class="fa-regular fa-heart"></i> 
                                </a>
                            </button>
                        @endif
                        <button class="btn ps-3"> 
                            @if(Auth::user()->tipe_pengguna === 'adopter' && Auth::user()->adopter)
                                <a href="{{ route('adopter.profile') }}">
                                    <img src="{{ asset(Auth::user()->adopter->foto_adopter) }}" width="40" height="40" class="rounded-circle profile-image-navbar" alt="Foto Adopter">
                                </a>
                            @elseif(Auth::user()->tipe_pengguna === 'shelter' && Auth::user()->shelter)
                                <a href="{{ route('shelter.profil') }}">
                                    <img src="{{ asset(Auth::user()->shelter->foto_shelter) }}" width="40" height="40" class="rounded-circle profile-image-navbar" alt="Foto Shelter">
                                </a>
                            @elseif(Auth::user()->tipe_pengguna === 'admin')
                                <a href="{{ route('admin.profile') }}">
                                    <i class="fa-solid fa-user"></i>
                                </a>
                            @endif
                        </button>
                        @else
                            <a href="{{ route('login') }}" class="nav-link me-3 cursor">Log In</a>
                            <a href="{{ route('register') }}" class="nav-link cursor">Daftar Sekarang</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
</header>