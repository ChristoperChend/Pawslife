<style>
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


    .daftar-hewan {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-bottom: 1px solid #f1f1f1;
        transition: transform .3s ease;
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

    h4 {
        min-height: 264px;
    }

    .card-title-hewan {
        font-size: 1.25rem;
        color: #212529;
    }

    .card-subtitle-hewan {
        font-size: 0.9rem;
        color: #6c757d !important;
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
</style>

@extends('layout.master')

@section('content')

    <div class="container py-5">
        <form class="search-wrap" role="search" method="GET" action="{{ route('adopter.daftarFavorit') }}">
            <i class="fa-solid fa-search"></i>
            <input type="text" name="search" autocomplete="off" class="form-control" placeholder="Cari hewan berdasarkan nama, jenis, atau jenis kelamin..." value="{{ request('search') }}">
        </form>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 justify-content-start">
            @if (!$listFavorit->isEmpty())
                @foreach ($listFavorit as $favorit)
                    @if ($favorit->hewan->status_hewan == "siap_di_adopsi")
                        <div class="col d-flex justify-content-center">
                            <div class="card hewan-container border-0 shadow-sm">
                                <div class="ratio">
                                    <img src="{{ asset('storage/' . $favorit->hewan->foto_hewan) }}" class="daftar-hewan" alt="Foto {{ $favorit->hewan->nama_hewan ?? 'Hewan' }}">
                                </div>
                                <span class="heart-icon {{ in_array($favorit->hewan->id, $favoritHewanIds) ? 'liked' : '' }}" onclick="toggleHeart(this, {{ $favorit->hewan->id }})">
                                    <i class="{{ in_array($favorit->hewan->id, $favoritHewanIds) ? 'fa-solid' : 'fa-regular' }} fa-heart fa-xl"></i>
                                </span>
                                
                                <div class="p-3"> 
                                    <a href="{{ route('adopter.detailHewan', ['id' => $favorit->hewan->id]) }}" class="text-decoration-none">
                                        <h5 class="card-title-hewan fw-bold mb-0 text-truncate">
                                            {{ $favorit->hewan->nama_hewan ?? 'Nama Hewan' }}
                                            @if (strtolower($favorit->hewan->jenis_hewan ?? '') === 'anjing')
                                                <i class="fa-solid fa-bone ms-1"></i>
                                            @elseif (strtolower($favorit->hewan->jenis_hewan ?? '') === 'kucing')
                                                <i class="fa-solid fa-paw ms-1"></i>
                                            @endif
                                        </h5>
                                        <p class="card-subtitle-hewan mb-2 text-muted small">{{ $favorit->hewan->ras ?? 'Jenis Ras' }}</p>
                                        <p class="small mb-0 text-muted"><i class="fa-solid fa-house me-1"></i> {{ $favorit->hewan->shelter->nama_shelter ?? 'Shelter Tidak Dikenal' }}</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                <h4 class="d-flex justify-content-center align-items-center w-100">Tidak ada daftar favorit</h4>
            @endif
        </div>
        <div class="d-flex justify-content-center mt-4"> {{ $listFavorit->links() }} </div>
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
                    })
                    .then(() => {
                        location.reload();
                    })
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
                    })
                    .then(() => {
                        location.reload();
                    })
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