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

    /* 1. The Wrapper */
    .search-container {
        display: flex;
        align-items: stretch; /* Keeps them same height */
        justify-content: center;
        max-width: 750px; 
        margin: 0 auto 2rem;
        gap: 10px;
    }

    /* 2. The Slimmer Search Bar */
    .search-wrap {
        flex-grow: 1;
        margin: 0;
        max-width: none;
    }
    
    .search-wrap .form-control {
        height: 100%;
        background: #fff;
        /* Reduced padding for a smaller height */
        padding: 0.5rem 1rem 0.5rem 2.5rem; 
        font-size: 0.95rem;
    }

    .search-wrap .fa-search {
        /* Icon positioning remains centered */
        font-size: 0.9rem;
        left: 1rem;
    }

    /* 3. The Slimmer Stat Ticket */
    .stat-ticket {
        position: relative;
        display: inline-flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        
        background: #fff;
        border: 2px dashed #e0e7ff; 
        border-radius: 1rem; /* Slightly reduced radius */
        
        min-width: 100px; /* More compact width */
        padding: 0.25rem 0.75rem; /* Drastically reduced padding */
        
        overflow: hidden;
        transition: all 0.3s ease;
        text-decoration: none;
        cursor: default;
    }

    .stat-ticket:hover {
        border-color: var(--primary-color);
        transform: translateY(-2px) rotate(-1deg);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .stat-ticket .stat-number {
        font-size: 1.4rem; /* Smaller number */
        font-weight: 800;
        color: var(--primary-color);
        line-height: 1.1; /* Tighter line height */
        z-index: 2;
    }

    .stat-ticket .stat-label {
        font-size: 0.6rem; /* Smaller label */
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #9ca3af;
        z-index: 2;
    }

    /* Smaller Watermark Icon */
    .stat-ticket .watermark-icon {
        position: absolute;
        right: -5px;
        bottom: -8px;
        font-size: 2.5rem; /* Reduced icon size */
        color: var(--primary-color);
        opacity: 0.08;
        transform: rotate(-15deg);
        z-index: 1;
    }

    /* Mobile Responsive */
    @media (max-width: 576px) {
        .search-container { flex-direction: column; }
        .stat-ticket {
            flex-direction: row; 
            padding: 0.75rem;
            gap: 10px;
        }
        .stat-ticket .stat-number { line-height: 1; margin-bottom: 0; }
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

    <div class="search-container">
        
        <form class="search-wrap" role="search" method="GET" action="{{ route('shelter.data.hewan')}}">
            <i class="fa-solid fa-search"></i>
            <input name="q" class="form-control" type="search" placeholder="Cari hewan..." aria-label="Search" value="{{ $q ?? request('q') }}">
        </form>

        <div class="stat-ticket" title="Total Hewan Anda">
            <i class="fa-solid fa-paw watermark-icon"></i>
            <span class="stat-number">{{ $dataHewan->total() }}</span>
            <span class="stat-label">Total Hewan</span>
        </div>

    </div>

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

    <div class="d-flex justify-content-center mt-5 mb-5">
        {{$dataHewan->links()}}
    </div>
</div>

@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', () => {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: @json(session('success')),
            customClass: {
                icon: 'swal-success-primary',
                confirmButton: 'btn btn-primary-color',
            },
            buttonsStyling: false
        })
    });
</script>
@endif

@if (session('error'))
<script>
  document.addEventListener('DOMContentLoaded', () => {
    Swal.fire({
      icon: 'error',
      title: 'Gagal',
      text: @json(session('error')),
    });
  });
</script>
@endif
@endsection
