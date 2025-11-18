<style>
    .shelter-card-item {
        border-radius: 12px;
        transition: box-shadow 0.3s ease;
        border: 1px solid #dee2e6;
    }

    .shelter-card-item:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
    }

    .shelter-nama {
        font-size: 1.1rem;
        color: #343a40;
    }

    .shelter-email {
        font-size: 0.9rem;
        color: #343a40;
    }
</style>

@extends('layout.master')

@section('content')
    <div class="container py-5">
        <div class="text-atas mb-5">
            <h1 class="fw-bold text-center">Riwayat Pendaftaran Shelter</h1>
            <hr>
        </div>

        @if (!$shelter->isEmpty())
            @foreach ($shelter as $items)
                @if ($items->status != "diajukan")
                    <div class="card shelter-card-item mb-3 shadow-sm overflow-hidden bg-white">
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
                                <h6 class="fw-bold shelter-telepon">{{ $items->pengguna->email }}</h6>
                            </div>

                            <div class="p-3 d-flex flex-column justify-content-between bg-white" style="min-width: 200px;">
                                <div>
                                    <h6 class="fw-bold mb-2">Status</h6>
                                    @if ($items->status == "diterima")
                                        <span 
                                            class="d-inline-flex align-items-center fw-semibold"
                                            style="
                                                background-color: #e8f0fe;
                                                color: #1967d2;
                                                border-radius: 6px;
                                                font-size: 0.9rem;
                                                padding: 4px 10px;
                                                min-width: 170px;
                                                justify-content: center;
                                            ">
                                            {{ ucfirst($items->status) }}
                                        </span>
                                    @elseif ($items->status == "ditolak")
                                        <span 
                                            class="d-inline-flex align-items-center fw-semibold"
                                            style="
                                                background-color: #ffe8ea;
                                                color: #dc3545;
                                                border-radius: 6px;
                                                font-size: 0.9rem;
                                                padding: 4px 10px;
                                                min-width: 170px;
                                                justify-content: center;
                                            ">
                                            {{ ucfirst($items->status) }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @else
            <h4 class="d-flex justify-content-center align-items-center w-100">Tidak ada riwayat pendaftaran shelter</h4>
        @endif
    </div>

    @include('layout.loading')

@endsection
