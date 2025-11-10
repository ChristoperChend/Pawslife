<style>
    .shelter-image {
        width: 600px;
        height: 450px !important;
        border-radius: 10px;
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

    .detail-field-wrapper {
        display: flex;
        align-items: center;
        justify-content: space-between;
        border: 1px solid #cacaca;
        border-left: 5px solid var(--primary-color);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        border-radius: 8px;
        padding: 10px 15px;
        position: relative;
        transition: all 0.2s ease;
    }

    .detail-field-wrapper:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
    }

    .detail-label {
        font-size: 0.95rem;
        font-weight: 500 !important;
        color: #495057 !important;
    }

    .detail-text {
        flex-grow: 1;
        color: #212529; 
        font-size: 1rem;
        font-weight: 600;
    }

    .card-title-hewan {
        font-size: 1.25rem;
        color: #212529;
    }

    .card-subtitle-hewan {
        font-size: 0.9rem;
        color: #6c757d !important;
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
</style>

@extends('layout.master')

@section('content')
    <div class="container py-5">
        <div class="row detail-shelter-container g-5 mb-5">
            <div class="col-12 col-md-5 text-center">
                <img src="{{ asset('storage/' . $detailShelter->foto_shelter) }}" class="shelter-image img-fluid" alt="Foto Shelter {{ $detailShelter->nama_shelter ?? 'Shelter' }}">
            </div>

            <div class="col-12 col-md-7">
                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="detail-label"><i class="fa-solid fa-house me-1"></i> Nama Shelter</h5>
                        <div class="detail-field-wrapper">
                            <span class="detail-text">{{ $detailShelter->nama_shelter ?? 'Data tidak tersedia' }}</span>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="detail-label"><i class="fa-solid fa-phone me-1"></i> No Telepon</h5>
                        <div class="detail-field-wrapper">
                            <span class="detail-text">{{ $detailShelter->no_telepon_shelter ?? 'Data tidak tersedia' }}</span>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="detail-label"><i class="fa-solid fa-location-dot me-1"></i> Alamat</h5>
                        <div class="detail-field-wrapper">
                            <span class="detail-text">{{ $detailShelter->alamat_shelter ?? 'Data tidak tersedia' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div>
            <h2 class="fw-bold text-center">List Hewan {{ $detailShelter->nama_shelter }}</h2>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 justify-content-start">
                @if (!$listHewan->isEmpty())
                @foreach ($listHewan as $hewan)
                    <div class="col d-flex justify-content-center">
                        <div class="card hewan-container shadow-sm">
                            <img src="{{ asset('storage/' . $hewan->foto_hewan) }}" class="daftar-hewan" alt="Foto {{ $hewan->nama_hewan ?? 'Hewan' }}">
                            <span class="heart-icon {{ in_array($hewan->id, $favoritHewanIds) ? 'liked' : '' }}" onclick="toggleHeart(this, {{ $hewan->id }})">
                                <i class="{{ in_array($hewan->id, $favoritHewanIds) ? 'fa-solid' : 'fa-regular' }} fa-heart fa-xl"></i>
                            </span>
                            
                            <div class="p-3">
                                <a href="{{ route('adopter.detailHewan', ['id' => $hewan->id]) }}" class="text-decoration-none">
                                    <h5 class="card-title-hewan fw-bold mb-0 text-truncate">{{ $hewan->nama_hewan ?? '-' }}</h5>
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

            @if (!$listHewan->isEmpty())
                <div class="text-end mt-4">
                    <a href="{{ route('adopter.daftarHewan', ['shelter_id' => $detailShelter->id]) }}" class="btn-lihat-semua text-decoration-none cursor fw-bold">
                        Lihat semua 
                        <i class="fa-solid fa-chevron-right fa-2xs"></i>
                    </a>
                </div>
            @endif
        </div>
    </div>

    @extends('layout.loading')

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
                        text: res.message
                    })
                    icon.classList.remove('fa-regular');
                    icon.classList.add('fa-solid');
                    el.classList.add('liked');
                } else if (res.status === 'removed') {
                    Swal.fire({
                        icon: 'success',
                        title: res.title,
                        text: res.message
                    })
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