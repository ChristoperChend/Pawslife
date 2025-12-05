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
        display: flex;
        flex-direction: column;
        height: 100%;
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
    }

    .shelter-card-body-alt {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1; 
        background-color: #fff;
        align-items: center; 
        text-align: center;
    }

    .shelter-meta-top {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 0.5rem;
        width: 100%;
    }

    .shelter-meta-icon {
        font-size: 1rem;
        margin-right: 8px;
        background: #90a4ae;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        color: #2c6ade; 
    }

    .shelter-city-text {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #90a4ae;
    }

    .shelter-name-hero {
        font-size: 1.4rem;
        font-weight: 800;
        color: #2c3e50;

        line-height: 1.2;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%;
    }

    .shelter-footer {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        color: var(--primary-color);
        margin-top: auto; 
        padding-top: 12px;
        border-top: 1px solid #f0f2f5;
        width: 100%; 
    }

    .shelter-footer i {
        margin-right: 8px;
        color: var(--primary-color);
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
                        <div class="col d-flex justify-content-center">
                            <a href="{{ route('adopter.detailShelter', ['id' => $shelter->id]) }}" class="text-decoration-none w-100 d-flex justify-content-center">
                                <div class="card shelter-container border-0 shadow-sm">
                                    
                                    <div class="ratio">
                                        <img src="{{ asset('storage/' . $shelter->foto_shelter) }}" class="daftar-shelter" alt="Foto Shelter {{ $shelter->nama_shelter ?? 'Shelter' }}">
                                    </div>

                                    <div class="shelter-card-body-alt">

                                        <h5 class="shelter-name-hero" title="{{ $shelter->nama_shelter }}">
                                            {{ $shelter->nama_shelter ?? 'Shelter' }}
                                        </h5>

                                        <div class="shelter-meta-top">
                                            
                                            <span class="shelter-city-text">
                                                {{ $shelter->lokasi ?? 'Lokasi' }}
                                            </span>
                                        </div>

                                        <div class="shelter-footer">
                                            <i class="fa-solid fa-location-dot"></i>
                                            <span class="text-truncate">
                                                {{ Str::limit($shelter->alamat_shelter, 25, '...') }}
                                            </span>
                                        </div>

                                    </div>
                                    </div>
                            </a>
                        </div>
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
