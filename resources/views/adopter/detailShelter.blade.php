<style>
    .shelter-image {
        width: 600px;
        height: 450px !important;
        border: 1px solid #d8d8d8;
        border-radius: 10px;
        object-fit: cover;
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

    .detail-field-wrapper {
        display: flex;
        background-color: #fff;
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
        font-weight: bold;
    }

    .detail-text {
        flex-grow: 1 !important;
        color: #212529 !important; 
        font-size: 1rem !important;
        border: none !important;
    }

    .form-control:disabled {
        background-color: #fff !important;
    }

    .stat-ticket {
        position: relative;
        display: inline-flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: #fff;
        border: 2px dashed #e0e7ff; 
        border-radius: 1rem;
        min-width: 100px;
        padding: 0.25rem 0.75rem;
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
        font-size: 1.4rem;
        font-weight: 800;
        color: var(--primary-color);
        line-height: 1.1;
        z-index: 2;
    }

    .stat-ticket .stat-label {
        font-size: 0.6rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #9ca3af;
        z-index: 2;
    }

    .stat-ticket .watermark-icon {
        position: absolute;
        right: -5px;
        bottom: -8px;
        font-size: 2.5rem;
        color: var(--primary-color);
        opacity: 0.08;
        transform: rotate(-15deg);
        z-index: 1;
    }

    .hewan-card-body-alt {
        padding: 1.25rem 1.5rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1; 
        background-color: #fff;
        align-items: center; 
        text-align: center;
    }

    .hewan-name-hero {
        font-size: 1.4rem;
        font-weight: 800;
        color: #2c3e50;
        margin-bottom: 1rem;
        line-height: 1.2;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%;
    }

    .hewan-shelter-footer {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        color: #2c6ade;
        margin-top: auto; 
        padding-top: 12px;
        border-top: 1px solid #e2e2e2c5;
        width: 100%;
    }

    .hewan-shelter-footer i {
        margin-right: 8px;
        color: #2c6ade;
    }

    @media (max-width: 576px) {
        .row>* {
            padding-right: 3px !important;
            padding-left: 3px !important;
        }

        .shelter-image {
            height: 350px !important;
        }
    }
</style>

@extends('layout.master')

@section('content')
    <div class="container py-5">
        <div class="text-atas">
            <h1 class="fw-bold text-center">Detail Shelter</h1>
            <hr>
        </div>
        <div class="row detail-shelter-container g-4 mb-5">
            <div class="col-12 col-md-6 text-center">
                <img src="{{ asset('storage/' . $detailShelter->foto_shelter) }}" class="shelter-image img-fluid" alt="Foto Shelter {{ $detailShelter->nama_shelter ?? 'Shelter' }}">
            </div>

            <div class="col-12 col-md-6">
                <div class="row mb-4">
                    <div class="col-6">
                        <label class="form-label fw-semibold">Nama Shelter</label>
                        <div class="detail-field-wrapper">
                            <span class="detail-text">{{ $detailShelter->nama_shelter ?? 'Data tidak tersedia' }}</span>
                        </div>
                    </div>
                    
                    <div class="col-6">
                        <label class="form-label fw-semibold">Nomor Telepon</label>
                        <div class="detail-field-wrapper">
                            <span class="detail-text">{{ $detailShelter->no_telepon_shelter ?? 'Data tidak tersedia' }}</span>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-6">
                        <label class="form-label fw-semibold">Nama Bank</label>
                        <div class="detail-field-wrapper">
                            <span class="detail-text">{{ $detailShelter->nama_bank ?? 'Data tidak tersedia' }}</span>
                        </div>
                    </div>

                    <div class="col-6">
                        <label class="form-label fw-semibold">Nomor Rekening</label>
                        <div class="detail-field-wrapper">
                            <span class="detail-text">{{ $detailShelter->nomor_rekening ?? 'Data tidak tersedia' }}</span>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <label class="form-label fw-semibold">Alamat</label>
                        <div class="detail-field-wrapper">
                            <span class="detail-text">{{ $detailShelter->alamat_shelter ?? 'Data tidak tersedia' }}</span>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <label class="form-label fw-semibold">Deskripsi Shelter</label>
                        <div class="detail-field-wrapper" style="padding: 0px">
                            <textarea class="form-control detail-text" style="padding: 10px 15px;" rows="3" disabled>{{ $detailShelter->deskripsi_shelter ?? 'Data tidak tersedia' }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div>
            <div class="d-flex justify-content-center align-items-center flex-wrap gap-sm-3 mb-3">
                <h2 class="fw-bold text-center">List Hewan {{ $detailShelter->nama_shelter }}</h2>

                <div class="stat-ticket" title="Total Hewan Anda">
                    <i class="fa-solid fa-paw watermark-icon"></i>
                    <span class="stat-number">{{ $listHewan->total() }}</span>
                    <span class="stat-label">Total Hewan</span>
                </div>
            </div>

            @if (!$listHewan->isEmpty())
                <div class="text-end">
                    <a href="{{ route('adopter.daftarHewan', ['shelter_id' => $detailShelter->id]) }}" class="btn btn-primary-color text-decoration-none">
                        Lihat semua
                    </a>
                </div>
            @endif

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 justify-content-start">
                @if (!$listHewan->isEmpty())
                    @foreach ($listHewan as $hewan)
                        <div class="col d-flex justify-content-center">
                            <div class="card hewan-container border-0 shadow-sm">
                                <span class="heart-icon {{ in_array($hewan->id, $favoritHewanIds) ? 'liked' : '' }}" onclick="toggleHeart(this, {{ $hewan->id }})">
                                    <i class="{{ in_array($hewan->id, $favoritHewanIds) ? 'fa-solid' : 'fa-regular' }} fa-heart fa-xl"></i>
                                </span>
                                <a href="{{ route('adopter.detailHewan', ['id' => $hewan->id]) }}" class="text-decoration-none">
                                    <div class="ratio">
                                        <img src="{{ asset('storage/' . $hewan->foto_hewan) }}" class="daftar-hewan" alt="Foto {{ $hewan->nama_hewan ?? 'Hewan' }}">
                                    </div>
                                    <div class="hewan-card-body-alt">
                                        <h5 class="hewan-name-hero" title="{{ $hewan->nama_hewan }}">
                                            {{ $hewan->nama_hewan ?? 'Nama Hewan' }}
                                        </h5>
                                        <div class="hewan-shelter-footer">
                                            <i class="fa-solid fa-house"></i>
                                            <span class="text-truncate">{{ $hewan->shelter->nama_shelter ?? 'Shelter' }}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <h4 class="d-flex justify-content-center align-items-center w-100">Tidak ada daftar hewan</h4>
                @endif
            </div>
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
                        text: res.message,
                        customClass: {
                            actions: 'swal-actions-gap',
                            icon: 'swal-success-primary',
                            confirmButton: 'btn btn-primary-color',
                        },
                        buttonsStyling: false
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