<style>
    .foto-hewan {
        flex: 0 0 120px;
        height: 150px;
        overflow: hidden;
    }

    .foto-hewan img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .riwayat-card-item {
        border-radius: 12px;
        transition: box-shadow 0.3s ease;
        border: 1px solid #dee2e6;
    }

    .riwayat-card-item:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
    }

    .riwayat-content-wrapper {
        background: white; 
        border-radius: 12px;
    }

    .riwayat-hewan-nama {
        font-size: 1.1rem;
        color: #343a40;
    }

    .riwayat-hewan-jenis {
        font-size: 0.9rem;
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

    .status-badge {
        font-size: 1rem !important;
        padding: 0.5em 1em !important;
        font-weight: 600 !important;
        min-width: 120px !important;
        display: inline-block !important;
    }

    .riwayat-btn-aksi {
        font-size: 0.85rem !important;
        padding: 5px 10px !important;
        font-weight: 600 !important;
    }

    .tooltip-info {
        cursor: pointer;
        font-size: 0.9em;
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
            <h1 class="fw-bold text-center">Riwayat Pengajuan Adopsi</h1>
            <hr>
        </div>

        @if ($riwayat->isNotEmpty())
            <div class="card border-0 shadow-sm mb-4" style="background:#eef2fb;">
                <div class="card-body d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
                    
                    <div class="d-flex align-items-start gap-3">
                        <div class="d-flex justify-content-center align-items-center rounded-circle" 
                            style="width: 55px; height: 50px; background: rgba(13,110,253,0.1);">
                            <i class="bi bi-exclamation-circle fs-4 text-primary"></i>
                        </div>
                        
                        <div>
                            <h6 class="fw-bold mb-1">Batas Pengajuan Adopsi</h6>
                            <p class="small text-muted mb-0" style="line-height:1.6">
                                Kamu hanya dapat mengajukan adopsi <b>maksimal 5 hewan</b> secara bersamaan.
                                Jika masih dalam <b>masa percobaan</b> atau <b>diajukan</b>, kamu tidak bisa mengajukan adopsi baru.
                            </p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center">
                        <span class="badge rounded-pill px-3 py-2"
                            style="background: #e8f0fe; color: var(--primary-color); border: 1px solid var(--primary-color);">
                            Pengajuan Aktif Sekarang: {{ $jumlahDiajukan }}
                        </span>
                    </div>
                    
                </div>
            </div>
        @endif

        @forelse ($riwayat as $items)
            <div class="card riwayat-card-item mb-3 shadow-sm overflow-hidden bg-white">
                <div class="d-flex flex-wrap">
                    <div class="p-3 d-flex align-items-center justify-content-center bg-white text-center" 
                        style="width: 140px; min-height: 130px;">
                        <img src="{{ asset('storage/' . $items->hewan->foto_hewan) }}" 
                            alt="Foto Hewan"
                            class="rounded mx-auto d-block"
                            style="width: 100px; height: 100px; object-fit: cover; background:#e5e7eb;">
                    </div>
    
                    <div class="flex-fill p-3 border-end d-flex flex-column justify-content-center bg-white">
                        <p class="mb-1">
                            <span class="text-muted small" style="letter-spacing:.03em;">
                                Nama hewan:
                            </span>
                            <span class="fw-semibold ms-1">
                                {{  Str::ucfirst($items->hewan->nama_hewan ?? 'Nama tidak tersedia') }}
                            </span>
                        </p>

                        <p class="mb-0">
                            <span class="text-muted small" style="letter-spacing:.03em;">
                                Jenis hewan:
                            </span>
                            <span class="fw-semibold ms-1">
                                {{ Str::ucfirst($items->hewan->jenis_hewan ?? '-') }}
                            </span>
                        </p>
                    </div>
                    
                    <hr class="d-block d-sm-none w-100 my-2" style="border-top: 3px solid #b3b3b3;">

                    <div class="p-3 d-flex flex-column justify-content-between bg-white" style="min-width: 220px;">
                        <div>
                            <h6 class="fw-bold mb-2">Status</h6>
                            @if ($items->status_pengajuan == 'setuju')
                                <div class="d-flex flex-column align-items-center w-100">
                                    @php
                                        $today = \Carbon\Carbon::today();
                                        $akhir = $items->tanggal_akhir_percobaan 
                                                    ? \Carbon\Carbon::parse($items->tanggal_akhir_percobaan) 
                                                    : null;
                                    @endphp

                                    @if($items->tanggal_mulai_percobaan && $items->tanggal_akhir_percobaan && $akhir->gt($today))
                                        <div class="badge px-3 py-2 rounded-pill mb-2 shadow-sm bg-light w-100" 
                                            style="color: var(--primary-color); border: 1px solid var(--primary-color);">
                                            <i class="bi bi-clock-history me-1"></i> Masa Percobaan
                                        </div>
                                        <div class="d-flex flex-column align-items-center mb-2">
                                            <small class="text-secondary" style="font-size: 0.75rem; letter-spacing: 0.5px;">PERIODE:</small>
                                            <small class="fw-semibold text-dark" style="font-size: 0.85rem;">
                                                {{ \Carbon\Carbon::parse($items->tanggal_mulai_percobaan)->format('d M') }} 
                                                <span class="text-muted mx-1">&mdash;</span> 
                                                {{ \Carbon\Carbon::parse($items->tanggal_akhir_percobaan)->format('d M Y') }}
                                            </small>
                                        </div>
                                        <div class="w-100 mt-1 mb-3">
                                            <button 
                                                type="button" 
                                                class="btn btn-merah-color btn-sm w-100 fw-semibold"
                                                style="font-size: 0.9rem; padding: 6px 12px;"
                                                onclick="kembalikanHewan({{ $items->hewan->id }})"
                                            >
                                                Batalkan
                                            </button>
                                        </div>
                                    @else
                                        <div class="badge px-3 py-2 rounded-pill mb-2 shadow-sm bg-light w-100" 
                                            style="color: var(--primary-color); border: 1px solid var(--primary-color);">
                                            Diadopsi
                                        </div>
                                    @endif
                                </div>
                            @elseif($items->status_pengajuan == 'diajukan')
                                <div class="badge px-3 py-2 rounded-pill mb-2 shadow-sm bg-light w-100" 
                                    style="color: var(--primary-color); border: 1px solid var(--primary-color);">
                                    Diajukan
                                </div>
                            @elseif($items->status_pengajuan == 'diadopsi')
                                <div class="badge px-3 py-2 rounded-pill mb-2 shadow-sm bg-light w-100" 
                                    style="color: var(--primary-color); border: 1px solid var(--primary-color);">
                                    Diadopsi
                                </div>
                            @elseif($items->status_pengajuan == 'tolak')
                                <div class="badge px-3 py-2 rounded-pill mb-2 shadow-sm w-100" 
                                    style="color: #dc3545; border: 1px solid #dc3545; background-color: #ffe8ea;">
                                    Pengajuan Ditolak
                                </div>
                            @elseif($items->status_pengajuan == 'dikembalikan')
                                <div class="badge px-3 py-2 rounded-pill mb-2 shadow-sm w-100" 
                                    style="color: #dc3545; border: 1px solid #dc3545; background-color: #ffe8ea;">
                                    Hewan Dikembalikan
                                </div>
                            @endif
                        </div>
                        <a href="{{ route('adopter.detailHewan', ['id' => $items->hewan_id]) }}" 
                            class="text-primary fw-semibold small text-decoration-none align-items-center gap-0"
                        >
                            <i class="bi bi-info-circle fs-5 me-1"
                            style="cursor:pointer; color:#0d6efd;"
                            title="View Status"></i>

                            <span>Informasi Hewan</span>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <h4 class="d-flex justify-content-center align-items-center w-100">Tidak ada riwayat pengajuan adopsi</h4>
        @endforelse
        <div class="d-flex justify-content-center mt-4">{{ $riwayat->links() }}</div>
    </div>

    @include('layout.loading')

    <script>
        function kembalikanHewan(hewanId) {
            Swal.fire({
                icon: "question",
                title: "Alasan Mengembalikan Hewan",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Selanjutnya",
                cancelButtonText: "Kembali",
                reverseButtons: true,
                width: '800px',
                html: '<div><hr> <h6 class="text-start">Apa alasan anda ingin mengembalikan hewan ini?</h6> <textarea class="form-control" rows="4" id="alasan_adopsi"></textarea> <hr></div>',
                preConfirm: () => {
                    const alasan = document.getElementById('alasan_adopsi').value;
                    if (!alasan) {
                        Swal.showValidationMessage('Alasan wajib diisi!');
                    }
                    return alasan;
                },
                customClass: {
                    actions: 'swal-actions-gap',
                    icon: 'swal-question-primary',
                    confirmButton: 'btn btn-primary-color',
                    cancelButton: 'btn btn-merah-color'
                },
                buttonsStyling: false
            })
            .then((result) => {
                const alasanAdopsi = result.value;
                if (result.isConfirmed) {
                    if (result.isConfirmed) {
                    Swal.fire({
                        icon: "question",
                        title: "Apakah anda yakin mengembalikan hewan?",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yakin",
                        cancelButtonText: "Kembali",
                        reverseButtons: true,
                        customClass: {
                            actions: 'swal-actions-gap',
                            icon: 'swal-question-primary',
                            confirmButton: 'btn btn-primary-color',
                            cancelButton: 'btn btn-merah-color'
                        },
                        buttonsStyling: false
                    })
                    .then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('fullscreen-loading').classList.remove('d-none')
                            fetch('{{ route('adopter.kembalikanHewan') }}', {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                },
                                body: JSON.stringify({
                                    hewan_id: hewanId,
                                    alasan_adopsi: alasanAdopsi
                                })
                            })
                            .then(res => res.json())
                            .then(res => {
                                document.getElementById('fullscreen-loading').classList.add('d-none')
                                if (res.errors) {
                                    
                                } else if (res.success) {
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
                                    .then(() => {
                                        location.reload();
                                    })
                                } else {
                                    Swal.fire({
                                        icon: "error",
                                        title: res.title,
                                        text: res.message,
                                        customClass: {
                                            actions: 'swal-actions-gap',
                                            confirmButton: 'btn btn-primary-color',
                                        },
                                        buttonsStyling: false
                                    })
                                    .then(() => {
                                        location.reload();
                                    })
                                }
                            })
                        }
                    })
                }
                }
            })
        }

        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endsection
