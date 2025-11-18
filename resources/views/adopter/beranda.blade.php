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
        background: linear-gradient(135deg, #2c6ade, #71dff7);
        color: white;
        text-align: center;
        padding: 170px 20px 160px 20px;
        overflow: hidden;
        margin-top: -80px;
    }

    .banner-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
        background: 
            url('/image/bone-icon.svg') 5% 10%,
            url('/image/paw-icon.svg') 15% 25%,
            url('/image/bone-icon.svg') 25% 5%,
            url('/image/paw-icon.svg') 35% 40%,
            url('/image/bone-icon.svg') 45% 15%,
            url('/image/paw-icon.svg') 55% 60%,
            url('/image/bone-icon.svg') 65% 25%,
            url('/image/paw-icon.svg') 75% 80%,
            url('/image/bone-icon.svg') 85% 35%,
            url('/image/paw-icon.svg') 95% 50%,

            url('/image/bone-icon.svg') 10% 65%,
            url('/image/paw-icon.svg') 20% 85%,
            url('/image/bone-icon.svg') 30% 70%,
            url('/image/paw-icon.svg') 40% 20%,
            url('/image/bone-icon.svg') 50% 90%,
            url('/image/paw-icon.svg') 60% 35%,
            url('/image/bone-icon.svg') 70% 10%,
            url('/image/paw-icon.svg') 80% 55%,
            url('/image/bone-icon.svg') 90% 75%,
            url('/image/paw-icon.svg') 5% 45%;

        background-size: 
            40px, 35px, 40px, 35px, 40px, 35px, 40px, 35px, 40px, 35px,
            40px, 35px, 40px, 35px, 40px, 35px, 40px, 35px, 40px, 35px;
        background-repeat: no-repeat;
        opacity: 0.3;
        pointer-events: none;
    }

    .banner-section > * {
        position: relative;
        z-index: 1;
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
        fill: rgb(250, 250, 250);
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
        width: 100%;
        max-width: 280px;  
        border: none;
        border-radius: 1rem;
        background: #fff;
        transition: transform .2s ease, box-shadow .2s ease;
        overflow: hidden;
        box-shadow: 0 6px 16px rgba(0,0,0,.06);
    }
        
    .hewan-container:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(0,0,0,.08);
    }

    .hewan-container .ratio {
        aspect-ratio: 4 / 3;
        height: 240px; 
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
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-bottom: 1px solid #f1f1f1;
        transition: transform .3s ease;
    }

    .heart-icon {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        z-index: 10;
        color: black;
        font-size: 15px;
        cursor: pointer;
        transition: all 0.25s ease;

        background-color: rgba(255, 255, 255, 0.6);
        padding: 20px 10px 20px 10px;
        border-radius: 50%;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    .heart-icon:hover {
        transform: scale(1.1);
        color: #ff0000;
    }

    .heart-icon.liked {
        color: #ff0000;
    }

    .card-title-hewan {
        font-size: 1.2rem;
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

        <div class="wave">
            <svg viewBox="0 0 500 150" preserveAspectRatio="none">
                <path d="
                    M0,100 
                    C100,140 150,60 
                    250,100 
                    C350,140 400,60 
                    500,100 
                    L500,150 
                    L0,150 
                    Z"
                ></path>
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

        <div class="text-end" style="margin-right: 35px">
            <a href="{{ route('adopter.daftarHewan') }}" class="btn btn-primary-color fw-bold text-decoration-none">
                Lihat semua
            </a>
        </div>
        
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 justify-content-start">
            @if (!$listHewan->isEmpty())
                @foreach ($listHewan as $hewan)
                    @if ($hewan->status_hewan == "siap_di_adopsi")
                        <div class="col d-flex justify-content-center">
                            <div class="card hewan-container border-0 shadow-sm">
                                <div class="ratio">
                                    <img src="{{ asset($hewan->foto_hewan) }}" class="daftar-hewan" alt="Foto {{ $hewan->nama_hewan ?? 'Hewan' }}">
                                </div>
                                <span class="heart-icon {{ in_array($hewan->id, $favoritHewanIds) ? 'liked' : '' }}" onclick="toggleHeart(this, {{ $hewan->id }})">
                                    <i class="{{ in_array($hewan->id, $favoritHewanIds) ? 'fa-solid' : 'fa-regular' }} fa-heart fa-xl"></i>
                                </span>
                                
                                <div class="p-3"> 
                                    <a href="{{ route('adopter.detailHewan', ['id' => $hewan->id]) }}" class="text-decoration-none">
                                        <h5 class="card-title-hewan fw-bold mb-0 text-truncate">
                                            {{ $hewan->nama_hewan ?? 'Nama Hewan' }}
                                            @if (strtolower($hewan->jenis_hewan ?? '') === 'anjing')
                                                <i class="fa-solid fa-bone ms-1"></i>
                                            @elseif (strtolower($hewan->jenis_hewan ?? '') === 'kucing')
                                                <i class="fa-solid fa-paw ms-1"></i>
                                            @endif
                                        </h5>
                                        <p class="card-subtitle-hewan mb-2 text-muted small">{{ $hewan->ras ?? 'Jenis Ras' }}</p>
                                        <p class="small mb-0 text-muted"><i class="fa-solid fa-house me-1"></i> {{ $hewan->shelter->nama_shelter ?? 'Shelter Tidak Dikenal' }}</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                <h4 class="d-flex justify-content-center align-items-center w-100">Tidak ada daftar hewan</h4>
            @endif
        </div>
    </div>
    
    @include('layout.loading')

    <script>
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
                        text: res.message,
                        customClass: {
                            actions: 'swal-actions-gap',
                            icon: 'swal-success-primary',
                            confirmButton: 'btn btn-primary-color',
                        },
                        buttonsStyling: false
                    });
                    icon.classList.remove('fa-regular');
                    icon.classList.add('fa-solid');
                    el.classList.add('liked');
                } else if (res.status === 'removed') {
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
                    icon.classList.remove('fa-solid');
                    icon.classList.add('fa-regular');
                    el.classList.remove('liked');
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
                    })
                }
            });
        }
    </script>
@endsection
