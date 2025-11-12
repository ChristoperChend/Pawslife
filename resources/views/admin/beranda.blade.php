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
        font-size: 1.3rem;
        color: #343a40;
    }

    .shelter-email {
        font-size: 1rem;
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
                <div class="card shelter-card-item shadow-lg mb-4">
                    <div class="d-flex p-3 p-md-4">
                        <div class="foto-shelter me-4 me-md-5">
                            <img src="{{ asset('storage/' . $items->foto_shelter) }}" alt="Foto shelter">
                        </div>
                        
                        <div class="flex-grow-1">
                            <p class="mb-0 text-muted small status-label">Nama Shelter</p>
                            <h5 class="fw-bold mb-3 shelter-nama">{{ $items->nama_shelter }}</h5>
                            
                            <p class="mb-0 text-muted small status-label">Email Shelter</p>
                            <h6 class="fw-bold shelter-email">{{ $items->pengguna->email }}</h6>
                        </div>
                        
                        <div class="ms-auto d-flex align-items-end">
                            <div class="info-lengkap-link">
                                <span class="fw-bold status-label">
                                    <a href="{{ route('admin.detailShelter', ['id' => $items->id]) }}" class="text-decoration-none text-dark">
                                        Informasi Lengkap <i class="fa-solid fa-chevron-right fa-xs ms-1"></i>
                                    </a>
                                </span>
                            </div>
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
