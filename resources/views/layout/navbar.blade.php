<style>
    .logo-image {
        width: 55px;
    }

    .nav-link {
        color: white;
    }

    .nav-link:hover {
        color: #ffd700;
    }

    .auth a {
        color: white;
    }

    .auth a:hover {
        color: #ffd700;
    }
</style>

<header class="primary-color position-sticky">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            {{-- Adopter --}}
            @if (Auth::check() && Auth::user()->tipe_pengguna == 'adopter')
                <a href="{{ route('beranda.adopterBeranda') }}" class="d-flex align-items-center text-white text-decoration-none">
                    <img src="{{ asset('image/logo.png') }}" alt="Logo Image" class="logo-image">
                </a>

                <ul class="nav cursor col-12 col-lg-auto me-lg-auto justify-content-center mb-md-0">
                    <li class="px-1"><a class="nav-link" href="{{ route('beranda.adopterBeranda') }}">Beranda</a></li>
                    <li class="px-1"><a class="nav-link" href="">Shelter</a></li>
                    <li class="px-1"><a class="nav-link" href="">Riwayat</a></li>
                    <li class="px-1"><a class="nav-link" href="">Lepas Adopsi</a></li>
                    <li class="px-1"><a class="nav-link" href="">Tentang Kami</a></li>
                </ul>
            {{-- Shelter --}}
            @elseif (Auth::check() && Auth::user()->tipe_pengguna == 'shelter')
                <a href="{{ route('beranda.adopterBeranda') }}" class="d-flex align-items-center text-white text-decoration-none">
                    <img src="{{ asset('image/logo.png') }}" alt="Logo Image" class="logo-image">
                </a>

                <ul class="nav cursor col-12 col-lg-auto me-lg-auto justify-content-center mb-md-0">
                    <li class="px-1"><a class="nav-link" href="{{ route('beranda.shelterBeranda') }}">Beranda</a></li>
                    <li class="px-1"><a class="nav-link" href="">Shelter</a></li>
                    <li class="px-1"><a class="nav-link" href="">Data Hewan</a></li>
                    <li class="px-1"><a class="nav-link" href="">Daftar Pengajuan</a></li>
                    <li class="px-1"><a class="nav-link" href="">Riwayat</a></li>
                    <li class="px-1"><a class="nav-link" href="">Tentang Kami</a></li>
                </ul>
            {{-- Admin --}}
            @elseif (Auth::check() && Auth::user()->tipe_pengguna == 'admin')
                <a href="{{ route('beranda.adopterBeranda') }}" class="d-flex align-items-center text-white text-decoration-none">
                    <img src="{{ asset('image/logo.png') }}" alt="Logo Image" class="logo-image">
                </a>

                <ul class="nav cursor col-12 col-lg-auto me-lg-auto justify-content-center mb-md-0">
                    <li class="px-1"><a class="nav-link" href="{{ route('beranda.adminBeranda') }}">Beranda</a></li>
                    <li class="px-1"><a class="nav-link" href="">Shelter</a></li>
                    <li class="px-1"><a class="nav-link" href="">Riwayat</a></li>
                </ul>
            {{-- Quest --}}
            @else
                <a href="{{ route('beranda.adopterBeranda') }}" class="d-flex align-items-center text-white text-decoration-none">
                    <img src="{{ asset('image/logo.png') }}" alt="Logo Image" class="logo-image">
                </a>

                <ul class="nav cursor col-12 col-lg-auto me-lg-auto justify-content-center mb-md-0">
                    <li class="px-1"><a class="nav-link" href="{{ route('beranda.adopterBeranda') }}">Beranda</a></li>
                    <li class="px-1"><a class="nav-link" href="">Shelter</a></li>
                    <li class="px-1"><a class="nav-link" href="">Riwayat</a></li>
                    <li class="px-1"><a class="nav-link" href="">Lepas Adopsi</a></li>
                    <li class="px-1"><a class="nav-link" href="">Tentang Kami</a></li>
                </ul>

                <div class="text-end text-white auth">
                    <a href="{{ route('login') }}" class="text-decoration-none cursor">Log In</a>
                    <a href="{{ route('register') }}" class="ms-4 text-decoration-none cursor">Daftar Sekarang</a>
                </div>
            @endif

            @auth
                <button class="btn">
                    <i class="fa-solid fa-heart fa-xl" style="color: #ff0000;"></i>
                </button>
                {{-- {{ dump(Auth::user()) }} --}}
                <button class="btn">
                    @if(Auth::user()->tipe_pengguna === 'adopter' && Auth::user()->adopter)
                        <img src="{{ asset('storage/' . Auth::user()->adopter->foto_adopter) }}" width="35" height="35"  class="rounded-circle" alt="Foto Adopter">
                    @elseif(Auth::user()->tipe_pengguna === 'shelter' && Auth::user()->shelter)
                        <img src="{{ asset('storage/' . Auth::user()->shelter->foto_shelter) }}" width="50" alt="Foto Shelter">
                    @endif
                </button>
            @endauth
        </div>
    </div>
</header>
