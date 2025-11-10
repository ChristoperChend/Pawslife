<style>
    .foto-hewan {
        flex: 0 0 120px;
        height: 150px;
        overflow: hidden;
    }

    .foto-hewan img {
        width: 100%;
        height: 100%;
        border-radius: 12px;
    }

    .riwayat-card-item {
        border-radius: 12px;
        transition: box-shadow 0.3s ease;
        border: 1px solid #dee2e6;
    }

    .riwayat-card-item:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
    }

    .riwayat-hewan-nama {
        font-size: 1.3rem;
        color: #343a40;
    }

    .riwayat-hewan-jenis {
        font-size: 1rem;
        color: #343a40;
    }

    .garis-vertikal-riwayat {
        width: 1px;
        height: 80px;
        background-color: #e9ecef;
    }

    .status-label {
        font-size: 0.9rem;
        color: #6c757d;
    }

    @media (max-width: 768px) {
        .foto-hewan {
            width: auto;
            height: 150px;
        }
    }
</style>

@extends('layout.master')

@section('content')
    <div class="container py-5">
        <div class="text-atas mb-5">
            <h1 class="fw-bold text-center">Riwayat Penyerahan Hewan Peliharaan</h1>
            <hr>
        </div>

        @foreach ($riwayat as $items)
            <div class="card riwayat-card-item shadow-sm mb-5">
                <div class="d-flex align-items-center bg-light" style="padding: 1rem;">
                    <div class="foto-hewan me-4">
                        <img src="{{ asset('storage/' . $items->foto_hewan) }}" alt="Foto Hewan">
                    </div>

                    <div class="flex-grow-1">
                        <p class="mb-0 text-muted small">Nama Hewan</p>
                        <h5 class="fw-bold mb-3 riwayat-hewan-nama">{{ $items->nama_hewan }}</h5>
                        
                        <p class="mb-0 text-muted small">Jenis Hewan</p>
                        <h6 class="fw-bold riwayat-hewan-jenis">{{ $items->jenis_hewan }}</h6>
                    </div>

                    <div class="d-flex align-items-center ms-auto info-status-wrapper">
                        <div class="garis-vertikal-riwayat me-4 d-none d-md-block"></div>

                        <div class="text-end status-section">
                            <p class="fw-bold mb-2 status-label">Status Penyerahan</p>
                            
                            <div class="d-flex justify-content-end">
                                <h6 class="mb-0">{{ $items->status_penyerahan }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="d-flex justify-content-center mt-4">{{ $riwayat->links() }}</div>
    </div>
@endsection
