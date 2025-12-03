<style>
    .shelter-card-item {
        border-radius: 12px;
        transition: box-shadow 0.3s ease;
        border: 1px solid #dee2e6;
        display: block; 
    }

    .shelter-card-item:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
        transform: translateY(-2px); 
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

    @media (max-width: 576px) {
        .shelter-card-item {
            padding: 15px 0;
        }

        .shelter-card-item > .d-flex {
            flex-direction: column !important;
            align-items: center;
        }

        .shelter-card-item > .d-flex > div:first-child {
            width: 100%;
            padding: 10px 0 !important;
        }
        
        .shelter-card-item img {
            width: 100px; 
            height: 100px;
            margin: 0 auto;
            display: block;
            border-radius: 12px !important;
        }

        .shelter-card-item .flex-fill {
            width: 100%;
            text-align: center;
            padding: 10px 0 15px 0 !important;
            border-right: none !important;
        }
        
        .shelter-card-item > .d-flex > div:last-child {
            width: 100%;
            padding: 0 15px 15px !important;
            text-align: center;
        }
        
        .shelter-card-item .flex-fill p, 
        .shelter-card-item .flex-fill h5,
        .shelter-card-item .flex-fill h6 {
            text-align: center !important;
        }
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
                <a href="{{ route('admin.detailShelter', ['id' => $items->id]) }}" 
                   class="card shelter-card-item shadow-sm overflow-hidden bg-white mb-3 text-decoration-none">
                   
                    <div class="d-flex flex-wrap">
                        
                        <div class="p-3 d-flex align-items-center justify-content-center bg-white" 
                            style="width: 140px; min-height: 130px;"
                        >
                            <img src="{{ asset('storage/'.$items->foto_shelter) }}" 
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
                        
                    </div>
                </a>
            @endforeach
        @else
            <h4 class="d-flex justify-content-center align-items-center w-100">Tidak ada daftar shelter</h4>
        @endif
    </div>

    @include('layout.loading')

@endsection