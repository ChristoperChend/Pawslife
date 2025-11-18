<style>
    .shelter-card-item {
        border-radius: 12px;
        transition: box-shadow 0.3s ease;
        border: 1px solid #dee2e6;
    }

    .shelter-card-item:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
    }

    .foto-shelter {
        flex: 0 0 120px;
        height: 150px;
        overflow: hidden;
    }

    .foto-shelter img {
        width: 100%;
        height: 100%;
        border-radius: 12px;
    }

    .shelter-nama {
        font-size: 1.1rem;
        color: #343a40;
    }

    .shelter-email {
        font-size: 0.9rem;
        color: #343a40;
    }

    .status-label {
        font-size: 0.9rem;
        color: #6c757d;
    }
</style>

@extends('layout.master')

@section('content')
    <div class="container py-5">
        <div class="text-atas mb-5">
            <h1 class="fw-bold text-center">List Pengajuan Pendaftaran Shelter</h1>
            <hr>
        </div>

        @if (!$listShelter->isEmpty())
            @foreach ($listShelter as $items)
                <div class="card shelter-card-item shadow-sm overflow-hidden bg-white">
                    <div class="d-flex flex-wrap align-items-stretch">
                        <div class="p-3 d-flex align-items-center justify-content-center bg-white" 
                            style="width: 140px; min-height: 130px;"
                        >
                            <img src="{{ asset($items->foto_shelter) }}" 
                                alt="Foto Shelter"
                                class="rounded"
                                style="width: 100px; height: 100px; object-fit: cover; background:#e5e7eb;">
                        </div>

                        <div class="flex-fill p-3 border-end d-flex flex-column justify-content-center bg-white">
                            <p class="mb-0 text-muted small">Nama Shelter</p>
                            <h5 class="fw-bold mb-1 shelter-nama">{{ $items->nama_shelter }}</h5>
                            
                            <p class="mb-0 text-muted small">Email Shelter</p>
                            <h6 class="fw-bold shelter-jenis">{{ $items->pengguna->email }}</h6>
                        </div>
                        
                        <div class="p-3 d-flex flex-column justify-content-between bg-white" style="min-width: 200px;">
                            <div></div>
                            <a href="{{ route('admin.detailShelter', ['id' => $items->id]) }}" 
                                class="text-primary fw-semibold small text-decoration-none d-inline-flex align-items-center gap-1"
                            >
                                <i class="bi bi-info-circle fs-5" style="cursor:pointer; color:#0d6efd;" title="View Status"></i>
                                <span>Informasi Lengkap</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <h4 class="d-flex justify-content-center align-items-center w-100">Tidak ada daftar shelter</h4>
        @endif
    </div>

    @include('layout.loading')

@endsection
