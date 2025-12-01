<style>
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

    .shelter-container {
        width: 100%;
        max-width: 280px;  
        border: none;
        border-radius: 1rem;
        background: #fff;
        transition: transform .2s ease, box-shadow .2s ease;
        overflow: hidden;
        box-shadow: 0 6px 16px rgba(0,0,0,.06);
    }

    .shelter-container:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(0,0,0,.08);
    }

    .shelter-container .ratio {
        aspect-ratio: 4 / 3;
        height: 240px; 
    }

    .daftar-shelter {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-bottom: 1px solid #f1f1f1;
        transition: transform .3s ease;
    }

    .card-title-shelter {
        font-size: 1.25rem;
        color: #212529;
    }

    .card-subtitle-shelter {
        font-size: 0.9rem;
        color: #6c757d !important;
    }

    .card-text-alamat {
        font-size: 0.8rem;
        color: #495057 !important;
    }
</style>

@extends('layout.master')

@section('content')
    <div class="container py-5">
        <form class="search-wrap" role="search" method="GET" action="{{ route('adopter.daftarShelter') }}">
            <i class="fa-solid fa-search"></i>
            <input type="text" name="search" autocomplete="off" class="form-control" placeholder="Cari shelter berdasarkan nama atau Lokasi..." value="{{ request('search') }}">
        </form>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 justify-content-start">
            @if (!$listShelter->isEmpty())
                @foreach ($listShelter as $shelter)
                    @if ($shelter->status === 'diterima')
                        <a href="{{ route('adopter.detailShelter', ['id' => $shelter->id]) }}" class="col d-flex justify-content-center text-decoration-none">
                            <div class="card shelter-container border-0 shadow-lg">
                                <div class="ratio">
                                    <img src="{{ asset('storage/' . $shelter->foto_shelter) }}" class="daftar-shelter" alt="Foto Shelter {{ $shelter->nama_shelter ?? 'Shelter' }}">
                                </div>

                                <div class="p-3">
                                    <h5 class="card-title-shelter fw-bold mb-0 text-truncate">{{ $shelter->nama_shelter ?? 'Shelter Tidak Dikenal' }}</h5>
                                    <p class="card-subtitle-shelter mb-1 text-muted small">{{ $shelter->lokasi ?? '-' }}</p>
                                    <p class="card-text-alamat text-muted mt-2 mb-0">
                                        <i class="fa-solid fa-location-dot me-1"></i> {{ Str::limit($shelter->alamat_shelter, 35, '...') }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    @endif
                @endforeach
            @else
                <h4 class="d-flex justify-content-center align-items-center w-100">Tidak ada daftar shelter</h4>
            @endif
        </div>
        <div class="d-flex justify-content-center mt-4"> {{ $listShelter->links() }} </div>
    </div>
@endsection

<script>
    document.getElementById('search-form').addEventListener('submit', function() {
        document.getElementById('fullscreen-loading').classList.remove('d-none');
    });
</script>
