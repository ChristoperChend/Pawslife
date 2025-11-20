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
            <h1 class="fw-bold text-center">Riwayat Pengajuan Adopsi</h1>
            <hr>
        </div>

        @forelse ($riwayat as $items)
            <div class="card riwayat-card-item mb-3 shadow-sm overflow-hidden bg-white">
                <div class="d-flex flex-wrap align-items-stretch">
                    <div class="p-3 d-flex align-items-center justify-content-center bg-white" 
                        style="width: 140px; min-height: 130px;"
                    >
                        <img src="{{ asset($items->hewan->foto_hewan) }}" 
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
                    
                    <div class="p-3 d-flex flex-column justify-content-between bg-white" style="min-width: 200px;">
                        <div>
                            <h6 class="fw-bold mb-2">Status</h6>
                            @if ($items->status_pengajuan == "setuju")
                                @php
                                    $endDate = \Carbon\Carbon::parse($items->tanggal_akhir_percobaan)->startOfDay();
                                    $today = now()->startOfDay();
                                    if ($endDate->lt($today)) {
                                        $daysRemainingDisplay = 0;
                                    } else {
                                        $daysRemainingDisplay = $today->diffInDays($endDate);
                                    }
                                @endphp
                                @if ($endDate == $today || $endDate < $today)
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
                                        Diadopsi
                                    </span>
                                @else
                                    <h6 class="fw-bold" style="font-size: 14px">
                                            Masa Percobaan Sisa {{ $daysRemainingDisplay }} hari
                                            <i 
                                                class="fa-solid fa-circle-info tooltip-info"
                                                data-bs-toggle="tooltip" 
                                                data-bs-placement="top" 
                                                title="Jika masa percobaan sudah selesai, hewan akan otomatis diadopsi."
                                            ></i>
                                    </h6>
                                    <div class="d-flex gap-2 justify-content-end">
                                        <button 
                                            type="button" 
                                            class="btn btn-merah-color btn-sm riwayat-btn-aksi" 
                                            onclick="kembalikanHewan({{ $items->hewan->id }})"
                                        >
                                            Kembalikan
                                        </button>
                                        <button 
                                            type="button" 
                                            class="btn btn-primary-color btn-sm riwayat-btn-aksi" 
                                            onclick="adopsiHewan({{ $items->hewan->id }})"
                                        >
                                            Adopsi
                                        </button>
                                    </div>
                                @endif
                            @elseif($items->status_pengajuan == 'diajukan' || $items->status_pengajuan == 'diadopsi')
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
                                    {{ ucfirst($items->status_pengajuan) }}
                                </span>
                            @elseif($items->status_pengajuan == 'tolak' || $items->status_pengajuan == 'dikembalikan')
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
                                    {{ ucfirst($items->status_pengajuan) }}
                                </span>
                            @endif
                        </div>
                        <a href="{{ route('adopter.detailHewan', ['id' => $items->hewan_id]) }}" 
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
                <p>Belum ada riwayat pengajuan adopsi.</p>
            </div>
        @endforelse
        <div class="d-flex justify-content-center mt-4">{{ $riwayat->links() }}</div>
    </div>

    @include('layout.loading')

    <script>
        function adopsiHewan(hewanId) {
            Swal.fire({
                icon: "question",
                title: "Alasan Melakukan Adopsi",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Selanjutnya",
                cancelButtonText: "Kembali",
                reverseButtons: true,
                width: '800px',
                html: '<div><hr> <h6 class="text-start">Apa alasan anda ingin melakukan adopsi pada hewan ini?</h6> <textarea class="form-control" rows="4" id="alasan_adopsi"></textarea> <hr></div>',
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
                    Swal.fire({
                        icon: "question",
                        title: "Apakah anda yakin melakukan adopsi?",
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
                            fetch('{{ route('adopter.adopsiHewan') }}', {
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
            })
        }

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
