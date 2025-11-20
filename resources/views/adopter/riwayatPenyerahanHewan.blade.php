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

        @forelse ($riwayat as $items)
            <div class="card riwayat-card-item mb-3 shadow-sm overflow-hidden bg-white">
                <div class="d-flex flex-wrap align-items-stretch">
                    <div class="p-3 d-flex align-items-center justify-content-center bg-white" 
                        style="width: 140px; min-height: 130px;"
                    >
                        <img src="{{ asset($items->foto_hewan) }}" 
                            alt="Foto Hewan"
                            class="rounded"
                            style="width: 100px; height: 100px; object-fit: cover; background:#e5e7eb;">
                    </div>

                    <div class="flex-fill p-3 border-end d-flex flex-column justify-content-center bg-white">
                        <p class="mb-1">
                            <span class="text-muted small" style="letter-spacing:.03em;">
                                Nama hewan:
                            </span>
                            <span class="fw-semibold ms-1">
                                {{  Str::ucfirst($items->nama_hewan ?? 'Nama tidak tersedia') }}
                            </span>
                        </p>

                        <p class="mb-0">
                            <span class="text-muted small" style="letter-spacing:.03em;">
                                Jenis hewan:
                            </span>
                            <span class="fw-semibold ms-1">
                                {{ Str::ucfirst($items->jenis_hewan ?? '-') }}
                            </span>
                        </p>
                    </div>

                    <div class="p-3 d-flex flex-column justify-content-between bg-white" style="min-width: 200px;">
                        <div>
                            <h6 class="fw-bold mb-2">Status</h6>
                            @if($items->status_penyerahan == 'diajukan' || $items->status_penyerahan == 'setuju')
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
                                    {{ ucfirst($items->status_penyerahan) }}
                                </span>
                            @elseif($items->status_penyerahan == 'tolak')
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
                                    {{ ucfirst($items->status_penstatus_penyerahangajuan) }}
                                </span>
                            @endif
                        </div>
                        <a href="{{ route('adopter.detailPenyerahanHewan', ['id' => $items->id, 'adopter_id' => $items->adopter_id]) }}" 
                            class="text-primary fw-semibold small text-decoration-none d-inline-flex align-items-center gap-1"
                        >
                            <i class="bi bi-info-circle fs-5" style="cursor:pointer; color:#0d6efd;" title="View Status"></i>
                            <span>Informasi Hewan</span>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center text-muted mt-5">
                <p>Belum ada riwayat penyerahan hewan peliharaan.</p>
            </div>
        @endforelse
        <div class="d-flex justify-content-center mt-4">{{ $riwayat->links() }}</div>
    </div>
@endsection
