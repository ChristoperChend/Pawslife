<style>
    /* --- ANIMATIONS --- */
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

    /* Animation for the Bones and Paws */
    @keyframes floatUpGlow {
        0% {
            opacity: 0;
            transform: translateY(0) scale(0.5) rotate(0deg);
        }
        20% {
            opacity: 0.8;
        }
        80% {
            opacity: 0.4;
        }
        100% {
            opacity: 0;
            transform: translateY(-300px) scale(1.2) rotate(20deg);
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

    .glowing-paws-container {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        z-index: 1;
        pointer-events: none;
    }

    .glowing-paw {
        position: absolute;
        bottom: 0px;
        color: rgba(255, 255, 255, 0.5);

        /* Effect */
        /* text-shadow: 0 0 10px rgba(255, 255, 255, 0.9), 0 0 20px rgba(113, 223, 247, 0.7); */
        text-shadow: none;
        opacity: 0;
        animation: floatUpGlow linear infinite;
    }

    /* Paw Customization*/
    .paw-1 { left: 10%; font-size: 24px; animation-duration: 7s; animation-delay: 0s; }
    .paw-2 { left: 25%; font-size: 40px; animation-duration: 10s; animation-delay: 2s; }
    .paw-3 { left: 45%; font-size: 28px; animation-duration: 6s; animation-delay: 4s; }
    .paw-4 { left: 60%; font-size: 36px; animation-duration: 11s; animation-delay: 1s; }
    .paw-5 { left: 75%; font-size: 22px; animation-duration: 8s; animation-delay: 3s; }
    .paw-6 { left: 90%; font-size: 35px; animation-duration: 9s; animation-delay: 5s; }
    .paw-7 { left: 15%; font-size: 15px; animation-duration: 6s; animation-delay: 0s; }
    .paw-8 { left: 50%; font-size: 23px; animation-duration: 7s; animation-delay: 2s; }
    .paw-9 { left: 80%; font-size: 49px; animation-duration: 11s; animation-delay: 4s; }
    .paw-10 { left: 60%; font-size: 41px; animation-duration: 12s; animation-delay: 5s; }


    .banner-content {
        position: relative;
        z-index: 10;
    }

    .banner-content h1 {
        font-weight: 800;
        font-size: 50px;
        margin-bottom: 15px;
        animation: fadeUp 0.6s ease-out forwards;
    }

    .banner-content p {
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
        filter: drop-shadow(0px 5px 10px rgba(0, 0, 0, 0.15));
    }

    .button-container {
        position: relative;
        z-index: 20;
        margin-top: -220px;
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
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.18);
    }

    .image-container:hover {
        transform: translateY(-10px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.25);
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
    .animal-card {
        position: relative;
        width: 100%;
        max-width: 280px;
        height: 250px;
        background: white;
        border-radius: 30px;
        border: 3px solid transparent;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .animal-card img {
        width: 150px;
        height: auto;
        transition: transform 0.4s ease;
        
    }

    .animal-label {
        margin-top: 15px;
        font-weight: 700;
        font-size: 24px;
        color: #333;
        opacity: 0.7;
        transition: all 0.3s ease;
    }

    /* cat card */
    .cat-card:hover {
        transform: translateY(-10px) scale(1.02);
        border-color: #4FC3F7;
        box-shadow: 0 15px 30px rgba(79, 195, 247, 0.4);
    }
    
    .cat-card:hover .animal-label {
        color: #0288D1;
        opacity: 1;
    }

    /* dog card */
    .dog-card:hover {
        transform: translateY(-10px) scale(1.02);
        border-color: #4FC3F7;
        box-shadow: 0 15px 30px rgba(79, 195, 247, 0.4);
    }

    .dog-card:hover .animal-label {
        color: #0288D1;
        opacity: 1;
    }

    .animal-card:hover img {
        transform: scale(1.1) rotate(5deg);
    }

</style>

@extends('layout.master')

@section('content')
    <section class="banner-section">
        
        <div class="glowing-paws-container">
            <i class="fa-solid fa-paw glowing-paw paw-1"></i>
            <i class="fa-solid fa-bone glowing-paw paw-2"></i>
            <i class="fa-solid fa-paw glowing-paw paw-3"></i>
            <i class="fa-solid fa-bone glowing-paw paw-4"></i>
            <i class="fa-solid fa-paw glowing-paw paw-5"></i>
            <i class="fa-solid fa-bone glowing-paw paw-6"></i>
            <i class="fa-solid fa-paw glowing-paw paw-7"></i>
            <i class="fa-solid fa-bone glowing-paw paw-8"></i>
            <i class="fa-solid fa-paw glowing-paw paw-9"></i>
            <i class="fa-solid fa-paw glowing-paw paw-10"></i>
        </div>

        <div class="banner-content">
            <h1>Temukan Sahabat Baru Hari Ini</h1>
            <p>Berikan cinta dan rumah baru untuk hewan yang membutuhkan. Temukan teman berbulu yang sempurna untuk keluarga Anda.</p>
        </div>

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
        <div class="container py-5">
        <div class="container button-container">
            <div class="row justify-content-center g-4"> <a href="{{ route('adopter.daftarHewan', ['jenis_hewan' => 'kucing']) }}" class="col-12 col-sm-5 col-md-4 d-flex justify-content-center text-decoration-none">
                    <div class="animal-card dog-card">
                        <img src="{{ asset('storage/icon/unnamed.jpg') }}" alt="Kucing">
                        <span class="animal-label">Anjing</span>
                    </div>
                </a>

                <a href="{{ route('adopter.daftarHewan', ['jenis_hewan' => 'anjing']) }}" class="col-12 col-sm-5 col-md-4 d-flex justify-content-center text-decoration-none">
                    <div class="animal-card cat-card">
                        <img src="{{ asset('storage/icon/unnamed (1).jpg') }}" alt="Anjing">
                        <span class="animal-label">Kucing</span>
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