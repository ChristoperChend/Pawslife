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

    @media (max-width: 576px) {
    .riwayat-card-item {
        padding: 10px 8px;
    }

    .riwayat-card-item > .d-flex {
        flex-direction: column !important;
        align-items: center;
    }

    .riwayat-card-item > .d-flex > div:first-child {
        width: 100%;
        text-align: center;
        padding: 10px 0;
    }

    .riwayat-card-item img {
        width: 130px !important;
        height: 130px !important;
        border-radius: 12px;
        margin: 0 auto !important;
        display: block;
    }

    .riwayat-card-item .flex-fill {
        border: none !important;
        text-align: center;
        padding: 14px 0 10px 0 !important;
        width: 100%;
    }

    .riwayat-hewan-nama,
    .riwayat-hewan-jenis {
        font-size: 1rem;
        margin-bottom: 2px !important;
    }
    
    .riwayat-card-item .flex-fill p span {
        display: block;
        margin-left: 0 !important;
        margin-right: 0 !important;
    }

    .riwayat-card-item .flex-fill p span.fw-semibold {
        font-size: 1.1rem;
    }

    .riwayat-card-item > .d-flex > div:last-child {
        width: 100%;
        text-align: center;
        padding-top: 10px !important;
        padding-bottom: 10px !important;
    }

    .status-badge,
    .riwayat-card-item span {
        width: 100% !important;
        min-width: 100% !important;
    }

    .riwayat-btn-aksi {
        width: 100%;
        margin-top: 5px;
    }

    .riwayat-card-item a {
        justify-content: center;
        margin-top: 12px;
    }

    .border-end {
        border: none !important;
    }

    .text-primary {
        justify-content: center;
    }

    .d-flex.gap-2.justify-content-end {
        justify-content: center !important;
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
                <div class="d-flex flex-wrap">
                    <div class="p-3 d-flex align-items-center justify-content-center bg-white text-center" 
                        style="width: 140px; min-height: 130px;"
                    >
                        <img src="{{ asset('storage/' . $items->foto_hewan) }}" 
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

                    <hr class="d-block d-sm-none w-100 my-2" style="border-top: 3px solid #b3b3b3;">

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
                            class="text-primary fw-semibold small text-decoration-none align-items-center gap-0"
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
