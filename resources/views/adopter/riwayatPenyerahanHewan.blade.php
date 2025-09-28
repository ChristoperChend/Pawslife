<style>
    .foto-hewan {
        flex: 0 0 120px;
        height: 150px;
        overflow: hidden;
    }

    .foto-hewan img {
        width: 100%;
        height: 100%;
        /* object-fit: cover; */
    }

    .garis-vertikal {
        width: 1px;
        height: 100px;
        background-color: #000;
        margin-right: 1rem;
    }

    .info-status-container {
        align-items: center;
    }

    @media (max-width: 768px) {
        .info-status-container {
            flex-direction: column;
            align-items: flex-start;
        }

        .garis-vertikal {
            width: 100%;
            height: 1px;
            margin: 1rem 0;
        }

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
            <div class="card shadow-sm mb-5">
                <div class="d-flex align-items-center bg-light" style="padding: 1rem;">
                    <!-- Foto Hewan -->
                    <div class="foto-hewan me-4">
                        <img src="{{ asset('storage/' . $items->foto_hewan) }}" alt="Foto Hewan">
                    </div>

                    <!-- Info Hewan + Status -->
                    <div class="d-flex flex-grow-1 info-status-container">
                        <!-- Info Hewan -->
                        <div class="flex-grow-1">
                            <h5 class="fw-bold mb-3">{{ $items->nama_hewan }}</h5>
                            <h6 class="mb-0">{{ $items->jenis_hewan }}</h6>
                        </div>

                        <!-- Garis -->
                        <div class="garis-vertikal"></div>

                        <!-- Status -->
                        <div class="text-start me-5" style="flex-shrink: 0;">
                            <h5 class="fw-bold mb-3">Status</h5>
                            <h6 class="mb-0">{{ $items->status_penyerahan }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="d-flex justify-content-center mt-4">{{ $riwayat->links() }}</div>
    </div>
@endsection
