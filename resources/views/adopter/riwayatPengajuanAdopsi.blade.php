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

    .riwayat-content-wrapper {
        background: white; 
        border-radius: 12px;
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

    .status-badge {
        font-size: 1rem !important;
        padding: 0.5em 1em !important;
        font-weight: 600 !important;
        min-width: 120px !important;
        display: inline-block !important;
    }

    .riwayat-btn-aksi {
        font-size: 1rem !important;
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

        @foreach ($riwayat as $items)
            <div class="card riwayat-card-item shadow-sm mb-5">
                <div class="d-flex align-items-center bg-light" style="padding: 1rem;">
                    <div class="foto-hewan me-4">
                        <img src="{{ asset('storage/' . $items->hewan->foto_hewan) }}" alt="Foto Hewan">
                    </div>

                    <div class="flex-grow-1">
                        <p class="mb-0 text-muted small">Nama Hewan</p>
                        <h5 class="fw-bold mb-3 riwayat-hewan-nama">{{ $items->hewan->nama_hewan }}</h5>
                        
                        <p class="mb-0 text-muted small">Jenis Hewan</p>
                        <h6 class="fw-bold riwayat-hewan-jenis">{{ $items->hewan->jenis_hewan }}</h6>
                    </div>
                    

                    <div class="d-flex align-items-center ms-auto info-status-wrapper">
                        <div class="garis-vertikal-riwayat me-4 d-none d-md-block"></div>

                        <div class="text-end status-section">
                            <p class="fw-bold mb-2 status-label">Status Pengajuan</p>
                            
                            @if ($items->status_pengajuan == "Masa percobaan")
                                @php
                                    $updatedAt = \Carbon\Carbon::parse($items->updated_at);
                                    $totalHoursPassed = $updatedAt->diffInHours(now());
                                    $daysPassed = floor($totalHoursPassed / 24); 
                                    $daysRemaining = 7 - $daysPassed;
                                    $daysRemainingDisplay = max(0, $daysRemaining); 
                                @endphp
                                <h6 class="fw-bold">
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
                                        class="btn btn-outline-danger btn-sm riwayat-btn-aksi" 
                                        onclick="kembalikanHewan({{ $items->hewan->id }})"
                                    >
                                        Kembalikan
                                    </button>
                                    <button 
                                        type="button" 
                                        class="btn btn-success btn-sm riwayat-btn-aksi" 
                                        onclick="adopsiHewan({{ $items->hewan->id }})"
                                    >
                                        Adopsi
                                    </button>
                                </div>
                            @else
                                <span class="badge status-badge {{ 
                                    $items->status_pengajuan == 'Diadopsi' ? 'text-bg-success' : 
                                    ($items->status_pengajuan == 'Dikembalikan' ? 'text-bg-danger' : 
                                    'text-bg-warning') 
                                }}">
                                    {{ $items->status_pengajuan }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
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
                }
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
                                        text: res.message
                                    })
                                    .then(() => {
                                        location.reload();
                                    })
                                } else {
                                    Swal.fire({
                                        icon: "error",
                                        title: res.title,
                                        text: res.message
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
                }
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
                                        text: res.message
                                    })
                                    .then(() => {
                                        location.reload();
                                    })
                                } else {
                                    Swal.fire({
                                        icon: "error",
                                        title: res.title,
                                        text: res.message
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
