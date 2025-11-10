<style>
    @keyframes fadeUp {
        0% {
            opacity: 0;
            transform: translateY(30px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .banner-section {
        position: relative;
        background: linear-gradient(135deg, #f2994a, #6dd5ed, #2193b0);
        color: white;
        text-align: center;
        padding: 170px 20px 160px 20px;
        overflow: hidden;
        margin-top: -80px;
    }

    .banner-section h1 {
        font-weight: 800;
        font-size: 42px;
        margin-bottom: 15px;
        animation: fadeUp 0.6s ease-out forwards;
    }

    .banner-section p {
        font-size: 18px;
        margin-bottom: 25px;
        animation: fadeUp 0.6s ease-out forwards;
    }

    .banner-btn {
        background: white;
        color: #e76f51;
        padding: 12px 28px;
        font-weight: bold;
        border-radius: 8px;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        animation: fadeUp 0.6s ease-out forwards;
    }

    .banner-btn:hover {
        background: #fcefe8;
        transform: translateY(-3px);
    }

    .wave {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        overflow: hidden;
        line-height: 0;
    }

    .wave svg {
        position: relative;
        display: block;
        width: calc(120% + 1.3px);
        height: 100px;
    }

    .wave path {
        fill: #ffffff;
    }

    .button-container {
        position: relative;
        z-index: 20;
        margin-top: -150px;
        margin-bottom: 50px;
        animation: fadeUp 0.6s ease-out forwards;
    }

    .image-container {
        position: relative;
        max-width: 300px;
        height: 250px;
        overflow: hidden;
        border-radius: 20px;
        transition: transform 0.4s ease, box-shadow 0.4s ease;
    }

    .image-container:hover {
        transform: scale(1.05);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.25);
    }

    .image-container img {
        transition: transform 0.6s ease;
    }

    .image-container:hover img {
        transform: scale(1.1);
    }


    .hewan-container {
        border-radius: 10px;
        position: relative;
        transition: transform 0.4s ease, box-shadow 0.4s ease;
        transform: translateY(0) scale(1);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
        
    .hewan-container:hover {
        transform: translateY(-8px) scale(1.03);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.25);
    }

    .hewan-image {
        width: 300px;
        height: 250px;
        border-radius: 20px;
    }

    .img-fluid {
        max-width: 300px !important;
        height: 300px !important;
    }

    .overlay-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        font-size: 24px;
        font-weight: bold;
        text-align: center;
        visibility: hidden;
        width: 300px;
        height: 250px;
        border-radius: 20px;
        background-color: rgba(0, 0, 0, 0.6);
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .image-container:hover .overlay-text {
        visibility: visible;
    }

    .daftar-hewan {
        width: 275px;
        height: 225px;
        border-radius: 10px 10px 0px 0px;
    }

    .heart-icon {
        position: absolute;
        top: 1rem;
        right: 1rem;
        z-index: 10;
        color: black;
        font-size: 20px;
        cursor: pointer;
        transition: all 0.25s ease;

        background-color: rgba(255, 255, 255, 0.7);
        padding: 23px 12px 23px 12px;
        border-radius: 50%;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    .heart-icon:hover {
        transform: scale(1.1);
        color: #ff4d4d;
    }

    .heart-icon.liked {
        color: #ff0000;
    }

    .btn-lihat-semua {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 17px;
        color: #000;
        border: 2px solid #000;
        border-radius: 8px;
        background-color: #fff;
        padding: 8px 18px;
        transition: all 0.3s ease;
    }

    .btn-lihat-semua:hover {
        background-color: var(--primary-color);
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .card-title-hewan {
        font-size: 1.25rem;
        color: #212529;
    }

    .card-subtitle-hewan {
        font-size: 0.9rem;
        color: #6c757d !important;
    }
</style>

@extends('layout.master')

@section('content')
    <section class="banner-section">
        <h1>Dapatkan teman terbaik baru hari ini</h1>
        <p>Berikan cinta dan rumah baru untuk hewan yang membutuhkan. Temukan teman berbulu yang sempurna untuk keluarga Anda.</p>
        <a href="{{ route('adopter.daftarHewan') }}" class="banner-btn">Mulai Adopsi <i class="fa-solid fa-arrow-right"></i></a>

        <div class="wave">
            <svg viewBox="0 0 500 150" preserveAspectRatio="none">
                <path d="M0.00,49.98 C150.00,150.00 349.65,-49.98 500.00,49.98 L500.00,150.00 L0.00,150.00 Z"></path>
            </svg>
        </div>
    </section>

    <div class="container py-5">
        <div class="container button-container">
            <div class="row justify-content-center">
                <a href="{{ route('adopter.daftarHewan', ['jenis_hewan' => 'kucing']) }}" class="col-12 col-sm-6 d-flex justify-content-center mb-3">
                    <div class="image-container cursor">
                        <img src="{{ asset('image/cat logo2.png') }}" class="hewan-image" alt="Kucing">
                        <div class="overlay-text">Kucing</div>
                    </div>
                </a>
                <a href="{{ route('adopter.daftarHewan', ['jenis_hewan' => 'anjing']) }}" class="col-12 col-sm-6 d-flex justify-content-center mb-3">
                    <div class="image-container cursor">
                        <img src="{{ asset('image/dog logo.png') }}" class="hewan-image" alt="Anjing">
                        <div class="overlay-text">Anjing</div>
                    </div>
                </a>
            </div>
        </div>

        <div class="text-center mb-1">
            <a href="{{ route('adopter.daftarHewan') }}"  class="btn-lihat-semua fw-bold text-decoration-none">
                Lihat semua
            </a>
        </div>
        
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 justify-content-start">
            @if (!$listHewan->isEmpty())
                @foreach ($listHewan as $hewan)
                    <div class="col d-flex justify-content-center">
                        <div class="card hewan-container border-0 shadow-sm">
                            <img src="{{ asset('storage/' . $hewan->foto_hewan) }}" class="daftar-hewan" alt="Foto {{ $hewan->nama_hewan ?? 'Hewan' }}">
                            <span class="heart-icon {{ in_array($hewan->id, $favoritHewanIds) ? 'liked' : '' }}" onclick="toggleHeart(this, {{ $hewan->id }})">
                                <i class="{{ in_array($hewan->id, $favoritHewanIds) ? 'fa-solid' : 'fa-regular' }} fa-heart fa-xl"></i>
                            </span>
                            
                            <div class="p-3"> 
                                <a href="{{ route('adopter.detailHewan', ['id' => $hewan->id]) }}" class="text-decoration-none">
                                    <h5 class="card-title-hewan fw-bold mb-0 text-truncate">{{ $hewan->nama_hewan ?? 'Nama Hewan' }}</h5>
                                    <p class="card-subtitle-hewan mb-2 text-muted small">{{ $hewan->ras ?? 'Jenis Ras' }}</p>
                                    <div class="d-flex flex-wrap gap-2 mb-3">
                                        <span class="badge {{ ($hewan->status_steril ?? 'belum steril') == 'sudah steril' ? 'text-bg-success' : 'text-bg-warning' }}">{{ $hewan->status_steril ?? '-' }}</span>
                                        <span class="badge {{ ($hewan->status_vaksin ?? 'belum vaksin') == 'sudah vaksin' ? 'text-bg-primary' : 'text-bg-secondary' }}">{{ $hewan->status_vaksin ?? '-' }}</span>
                                    </div>
                                    <p class="small mb-0 text-muted"><i class="fa-solid fa-house me-1"></i> {{ $hewan->shelter->nama_shelter ?? 'Shelter Tidak Dikenal' }}</p>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <h4 class="d-flex justify-content-center align-items-center w-100">Tidak ada daftar hewan</h4>
            @endif
        </div>
    </div>
    
    @include('layout.loading')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const clickableElements = document.querySelectorAll('a[href], button[type="submit"], button[data-loading]');

            clickableElements.forEach(el => {
                el.addEventListener('click', function(e) {
                    const href = el.getAttribute('href');
                    if (el.target === '_blank' || !href || href.startsWith('#') || href.startsWith('javascript:')) {
                        return;
                    }
                    document.getElementById('fullscreen-loading').classList.remove('d-none');
                });
            });

            window.addEventListener('load', () => {
                document.getElementById('fullscreen-loading').classList.add('d-none');
            });
        });

        function toggleHeart(el, hewanId) {
            document.getElementById('fullscreen-loading').classList.remove('d-none')
            fetch("{{ route('adopter.tambahFavorit') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ hewan_id: hewanId })
            })
            .then(res => res.json())
            .then(res => {
                document.getElementById('fullscreen-loading').classList.add('d-none')
                const icon = el.querySelector('i');
                if (res.status === 'added') {
                    Swal.fire({
                        icon: 'success',
                        title: res.title,
                        text: res.message
                    });
                    icon.classList.remove('fa-regular');
                    icon.classList.add('fa-solid');
                    el.classList.add('liked');
                } else if (res.status === 'removed') {
                    Swal.fire({
                        icon: 'success',
                        title: res.title,
                        text: res.message
                    });
                    icon.classList.remove('fa-solid');
                    icon.classList.add('fa-regular');
                    el.classList.remove('liked');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: res.title,
                        text: res.message
                    })
                }
            });
        }
    </script>
@endsection
