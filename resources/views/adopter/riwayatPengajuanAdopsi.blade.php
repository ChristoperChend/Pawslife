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
            <h1 class="fw-bold text-center">Riwayat Pengajuan Adopsi</h1>
            <hr>
        </div>

        @foreach ($riwayat as $items)
            <div class="card shadow-sm mb-5">
                <div class="d-flex align-items-center bg-light" style="padding: 1rem;">
                    <!-- Foto Hewan -->
                    <div class="foto-hewan me-4">
                        <img src="{{ asset('storage/' . $items->hewan->foto_hewan) }}" alt="Foto Hewan">
                    </div>

                    <!-- Info Hewan + Status -->
                    <div class="d-flex flex-grow-1 info-status-container">
                        <!-- Info Hewan -->
                        <div class="flex-grow-1">
                            <h5 class="fw-bold mb-3">{{ $items->hewan->nama_hewan }}</h5>
                            <h6 class="mb-0">{{ $items->hewan->jenis_hewan }}</h6>
                        </div>

                        <!-- Garis -->
                        <div class="garis-vertikal"></div>

                        <!-- Status -->
                        <div class="text-start me-5" style="flex-shrink: 0;">
                            <h5 class="fw-bold mb-3">Status</h5>
                            {{-- {{ dd($selesaiMasaPercobaan) }} --}}
                            @if ($items->selesai_masa_percobaan)
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-outline-primary w-30 fw-bold" onclick="kembalikanHewan()">Kembalikan</button>
                                    <button type="button" class="btn btn-outline-primary w-30 fw-bold ms-4" onclick="adopsiHewan()">Adopsi</button>
                                </div>
                            @else
                                <h6 class="mb-0">{{ $items->status_pengajuan }}</h6>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="d-flex justify-content-center mt-4">{{ $riwayat->links() }}</div>
    </div>

    <script>
        function kembalikanHewan() {
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
                            
                        }
                    })
                }
            })
        }

        function adopsiHewan() {
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
                if (result.isConfirmed) {
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
                }
                }
            })
        }
    </script>
@endsection
