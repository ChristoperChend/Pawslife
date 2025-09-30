@extends('layout.master')

<style>
    .page-header {
        max-width: 960px;
        margin: 24px auto 0;
        text-align: center;
    }

    .page-header h2 {
        font-weight: 800;
        letter-spacing: .3px;
    }

    .page-subtitle {
        color: #6b7280;
        font-size: .95rem;
    }

    .pet-card {
        width: 100%;
        max-width: 270px;        
        border: 1px solid #e9ecef;
        border-radius: .9rem;
        background: #fff;
        transition: transform .2s ease, box-shadow .2s ease;
        overflow: hidden;
    }
    .pet-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 24px rgba(16,24,40,.10), 0 6px 12px rgba(16,24,40,.06);
    }

    .pet-card img { object-fit: cover; }

    .pet-card .card-title {
        font-size: 1.05rem;
        font-weight: 700;
        margin: 0 0 .6rem 0;
        text-align: center;
        color: black;
    }

    .btn-pet {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .4rem;
        width: 100%;
        padding: .45rem .8rem;
        font-weight: 600;
        font-size: .9rem;
        border-radius: .6rem;
        border: 1.5px solid #0d6efd;
        background: transparent;
        color: #0d6efd;
        transition: all .2s ease;
        text-decoration: none;
    }
    .btn-pet:hover {
        background: #0d6efd;
        color: #fff;
        box-shadow: 0 4px 12px rgba(13,110,253,.25);
    }
    .btn-pet:active {
        transform: translateY(1px);
    }

    .search-wrap {
        max-width: 800px;  
        margin: 0 auto 1.5rem;
        position: relative;
    }
    .search-wrap .form-control {
        border-radius: 2rem;
        padding: .65rem 1rem .65rem 2.5rem; 
        border: 1px solid #e5e7eb;
        transition: all .2s ease;
    }
    .search-wrap .fa-search {
        position: absolute;
        top: 50%;
        left: 15px;
        transform: translateY(-50%);
        color: #9ca3af;
        font-size: .9rem;
    }

    @media (max-width: 576px){
        .pet-card { max-width: 100%; }
    }
</style>

@section('content')
<div class="container py-3">
    <div class="page-header">
        <h2>Daftar Hewan Yang Anda Miliki</h2>
        <p class="page-subtitle">Kelola dan lihat semua hewan peliharaan Anda di sini</p>
    </div>

    <form class="search-wrap" role="search" method="GET" action="{{ route('shelter.data.hewan')}}">
        <i class="fa-solid fa-search"></i>
        <input name="q" class="form-control" type="search" placeholder="Cari hewan berdasarkan nama" aria-label="Search" value="{{ $q ?? request('q') }}">
    </form>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 justify-content-center">
        @foreach ($dataHewan as $data)
        @php
            $isDog = str_contains($data->jenis_hewan, 'anjing');
            $isCat = str_contains($data->jenis_hewan, 'kucing');
        @endphp
            <div class="col d-flex justify-content-center">
                <div class="card pet-card shadow-sm">
                    <div class="ratio ratio-4x3">
                        <img src="{{ asset($data->foto_hewan) }}" class="card-img-top" alt="{{ $data->nama_hewan }}" loading="lazy">
                    </div>
                    <div class="card-body">
                                
                        <h5 class="card-title">{{ $data->nama_hewan }} <i class="fa-solid {{ $isDog ? 'fa-bone' : ($isCat ? 'fa-paw' : 'fa-paw') }}"></i></h5>
                        <a href="#"
                           class="btn-pet"
                           aria-label="Lihat {{ $data->nama_hewan }}">
                            Lihat
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
