<style>
    .banner {
        width: 100%;
        max-width: none;
        height: 350px;
        object-fit: cover;
    }

    .banner-text {
        top: 70px;
    }

    .button-container {
        position: relative;
        z-index: 20;
        margin-top: -150px;
        margin-bottom: 50px;
    }

    .image-container {
        position: relative;
        max-width: 300px;
        height: 250px;
    }

    .hewan-container {
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
    }

    .hewan-container h5,
    .hewan-container h6 {
        margin: 2px;
        color: white;
        padding-left: 10px;
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
        width: 250px;
        height: 200px;
    }
</style>

@extends('layout.master')

@section('content')
    <img src="{{ asset('image/banner.jpeg') }}" class="banner" alt="Banner Beranda">

    <div class="container">
        <div class="container position-absolute text-center banner-text">
            <h1 class=" fw-bold">Dapatkan teman terbaik baru hari ini</h1>
        </div>

        <div class="container button-container">
            <div class="row justify-content-center">
                <a href="{{ route('adopter.daftarHewan', ['jenis_hewan' => 'kucing']) }}" class="col-12 col-sm-6 d-flex justify-content-center mb-3">
                    <div class="image-container cursor">
                        <img src="{{ asset('image/kucing.jpeg') }}" class="hewan-image" alt="Kucing">
                        <div class="overlay-text">Kucing</div>
                    </div>
                </a>
                <a href="{{ route('adopter.daftarHewan', ['jenis_hewan' => 'anjing']) }}" class="col-12 col-sm-6 d-flex justify-content-center mb-3">
                    <div class="image-container cursor">
                        <img src="{{ asset('image/anjing.jpeg') }}" class="hewan-image" alt="Anjing">
                        <div class="overlay-text">Anjing</div>
                    </div>
                </a>
            </div>
        </div>

        <div class="text-center mb-1">
            <a href="{{ route('adopter.daftarHewan') }}" class="text-decoration-none cursor fw-bold text-black" style="font-size: 25px;">
                Lihat semua 
                <i class="fa-solid fa-chevron-right fa-2xs" style="color: #000000;"></i>
            </a>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 justify-content-start">
            @foreach ($listHewan as $hewan)
                <div class="col d-flex justify-content-center">
                    <a href="{{ route('adopter.detailHewan', ['id' => $hewan->id]) }}" class="hewan-container cursor secondary-color text-decoration-none">
                        <img src="{{ asset('storage/' . $hewan->foto_hewan) }}" class="daftar-hewan">
                        <h5 class="pt-2">{{ $hewan->nama_hewan ?? '-' }}</h5>
                        <h6 class="fw-bold mb-3">{{ $hewan->ras ?? '-' }}</h6>
                        <h6>{{ $hewan->status_steril ?? '-' }} | {{ $hewan->status_vaksin ?? '-' }}</h6>
                        <h6 class="pb-2">{{ $hewan->shelter->nama_shelter ?? '-' }}</h6>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
