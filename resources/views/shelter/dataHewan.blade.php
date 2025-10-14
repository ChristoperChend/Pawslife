@extends('layout.master')

<style>
    :root {
        --card-radius: 1rem;
        --card-shadow: 0 6px 16px rgba(0,0,0,.06);
    }

    .page-header {
        max-width: 860px;
        margin: 2rem auto;
        text-align: center;
    }

    .page-header h2 {
        font-weight: 700;
        font-size: 1.9rem;
        margin-bottom: .5rem;
    }

    .page-subtitle {
        color: #6b7280;
        font-size: 1rem;
    }

    .search-wrap {
        max-width: 600px;
        margin: 0 auto 2rem;
        position: relative;
    }
    .search-wrap .form-control {
        border-radius: 2rem;
        padding: .75rem 1rem .75rem 2.5rem; 
        border: 1px solid #e5e7eb;
        transition: border .2s ease, box-shadow .2s ease;
    }
    .search-wrap .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(13,110,253,.15);
    }
    .search-wrap .fa-search {
        position: absolute;
        top: 50%;
        left: 1rem;
        transform: translateY(-50%);
        color: #9ca3af;
        font-size: .95rem;
    }

    .pet-card {
        width: 100%;
        max-width: 280px;        
        border: none;
        border-radius: var(--card-radius);
        background: #fff;
        box-shadow: var(--card-shadow);
        transition: transform .2s ease, box-shadow .2s ease;
        overflow: hidden;
    }
    .pet-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(0,0,0,.08);
    }

    .pet-card .ratio {
        aspect-ratio: 4 / 3;
        height: 240px; 
    }

    .pet-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-bottom: 1px solid #f1f1f1;
        transition: transform .3s ease;
    }

    .pet-card .card-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin: 0 0 .75rem 0;
        text-align: center;
        color: #111827;
    }

    .btn-pet {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        padding: .55rem 1rem;
        font-weight: 600;
        font-size: .9rem;
        border-radius: .6rem;
        border: 1.5px solid var(--primary-color);
        color: var(--primary-color);
        transition: all .2s ease;
        text-decoration: none;
    }
    .btn-pet:hover {
        background: var(--primary-color);
        color: #fff;
        box-shadow: 0 4px 12px rgba(13,110,253,.25);
    }
    .btn-pet:active {
        transform: translateY(1px);
    }

    @media (max-width: 576px){
        .pet-card { max-width: 100%; }
    }
</style>

@section('content')
<div class="container py-4">
    <div class="page-header">
        <h2>Daftar Hewan Peliharaan</h2>
        <p class="page-subtitle">Kelola dan lihat semua hewan peliharaan Anda di sini</p>
    </div>

    <form class="search-wrap" role="search" method="GET" action="{{ route('shelter.data.hewan')}}">
        <i class="fa-solid fa-search"></i>
        <input name="q" class="form-control" type="search" placeholder="Cari hewan berdasarkan nama..." aria-label="Search" value="{{ $q ?? request('q') }}">
    </form>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        @foreach ($dataHewan as $data)
        @php
            $isDog = str_contains($data->jenis_hewan, 'anjing');
            $isCat = str_contains($data->jenis_hewan, 'kucing');
        @endphp
            <div class="col d-flex justify-content-center">
                <div class="card pet-card">
                    <div class="ratio ratio-4x3">
                        <img src="{{ asset($data->foto_hewan) }}" class="card-img-top" alt="{{ $data->nama_hewan }}" loading="lazy">
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title">
                            {{ $data->nama_hewan }} 
                            <i class="fa-solid {{ $isDog ? 'fa-bone' : 'fa-paw' }}"></i>
                        </h5>
                        <a href="{{ route('shelter.detail.hewan', $data->id) }}"
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
