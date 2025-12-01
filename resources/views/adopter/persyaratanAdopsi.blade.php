@extends('layout.master')

<style>
    .page-header {
        max-width: 860px;
        margin: 2rem auto;
        text-align: center;
        position: relative;
        z-index: 2;
    }

    .ajukan-adopsi {
        text-align: justify;
    }

    .warning-box {
        background-color: #ffe8ea;
        border: 1px solid #dc3545;
        padding: 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
    }

    .warning-text {
        color: #dc3545;
        font-weight: bold;
        text-align: center;
        flex-grow: 1;
    }

    .custom-list {
        list-style: none;
        padding-left: 0;
        counter-reset: item;
    }

    .custom-list li {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 15px;
        counter-increment: item;
    }

    .custom-list li::before {
        content: counter(item);
        width: 25px;
        height: 25px;
        background: #2f6cf6;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 13px;
        box-shadow: 0 4px 6px rgba(13, 110, 253, 0.2); 
        flex-shrink: 0;
    }
</style>

@section('content')
    <div class="container py-5">
        <div class="page-header">
            <h2>Persyaratan Adopsi <b>{{ $detailShelter->shelter->nama_shelter ?? 'Tempat Penampungan' }}</b></h2>
        </div>
        <div class="card requirements-card shadow-sm mx-auto" style="max-width: 850px;">
            <div class="card-body p-4 p-md-5 position-relative">
                <div class="ajukan-adopsi">
                    <div class="warning-box">
                        <div class="warning-text">
                            <label class="fw-bold fs-5">* Pengajuan adopsi tidak bisa dibatalkan. *</label>
                        </div>
                    </div>
                    <hr>
                    @if ($detailShelter->shelter->masa_percobaan && $detailShelter->shelter->masa_percobaan > 0)
                        <h6>
                            <b>{{ $detailShelter->shelter->nama_shelter }}</b> menyediakan "Percobaan Adopsi" untuk
                            memastikan kecocokan antara hewan dan calon pengadopsi selama
                            <b>{{ $detailShelter->shelter->masa_percobaan }} hari</b>.
                        </h6>
                    @else
                        <h6>
                            <b>{{ $detailShelter->shelter->nama_shelter }}</b> tidak menyediakan masa percobaan adopsi.
                            Setelah pengajuan disetujui, proses adopsi akan langsung berlanjut ke tahap selanjutnya.
                        </h6>
                    @endif
                    <ol class="fw-bold custom-list">
                        @foreach ($detailShelter->shelter->persyaratan_adopsi as $index => $syarat)
                            <li>
                                <h6 class="mb-0 lh-base">
                                    {{ str_ends_with(trim($syarat), '.') ? trim($syarat) : trim($syarat) . '.' }}
                                </h6>
                            </li>
                        @endforeach
                    </ol>
                    <hr>

                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" value="1" id="setujuPersyaratan" name="setuju"
                            required>
                        <label class="form-check-label text-dark" for="setujuPersyaratan">
                            Saya telah membaca, memahami, dan menyetujui <b>semua persyaratan adopsi</b> di atas.
                        </label>
                        @error('setuju')
                            <div class="text-danger mt-1 small">
                                <i class="fas fa-exclamation-triangle me-1"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="button" class="btn btn-primary-color" disabled id="tombolAdopsi"
                            onclick="ajukanAdopsi()">
                            Lanjutkan Proses Adopsi
                        </button>
                        <a href="{{ url()->previous() }}" class="btn btn-kembali">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layout.loading')

    <script>
        const masaPercobaan = {{ $detailShelter->shelter->masa_percobaan ?? 0 }};

        document.addEventListener('DOMContentLoaded', function() {
            const checkbox = document.getElementById('setujuPersyaratan');
            const submitButton = document.getElementById('tombolAdopsi');

            function toggleSubmitButton() {
                submitButton.disabled = !checkbox.checked;
            }

            toggleSubmitButton();
            checkbox.addEventListener('change', toggleSubmitButton);
        });

        function ajukanAdopsi() {
            if (!masaPercobaan || masaPercobaan <= 0) {
                submitAdopsi()
                return
            }

            Swal.fire({
                icon: "question",
                title: "Percobaan Adopsi",
                showCancelButton: true,
                confirmButtonText: "Setuju",
                cancelButtonText: "Kembali",
                reverseButtons: true,
                width: '800px',
                html: `
                    <div class="ajukan-adopsi">
                        <div class="text-center text-danger">
                            <label class="fw-bold">* Pengajuan adopsi tidak bisa dibatalkan. *</label>
                        </div>
                        <hr>
                        <h6><b>{{ $detailShelter->shelter->nama_shelter }}</b> menyediakan "Percobaan Adopsi" untuk memastikan kecocokan antara hewan dan calon pengadopsi selama <b>${masaPercobaan} hari</b>.</h6>
                        <h6>1. Calon pengadopsi diberikan waktu <b>${masaPercobaan} hari</b> untuk mengenal dan merawat hewan yang diadopsi.</h6>
                        <h6>2. Jika selama masa percobaan terdapat kendala atau ketidaksesuaian, calon pengadopsi diperbolehkan mengembalikan hewan ke shelter asal tanpa konsekuensi dengan menekan tombol <b>"Kembalikan"</b> di <b>Riwayat pengajuan adopsi</b>.</h6>
                        <h6>3. Jika <b>TIDAK</b> melakukan konfirmasi setelah melewati masa percobaan, maka masa percobaan akan otomatis berakhir dan hewan otomatis diadopsi.</h6>
                        <hr>
                    </div>
                `,
                customClass: {
                    actions: 'swal-actions-gap',
                    icon: 'swal-question-primary',
                    confirmButton: 'btn btn-primary-color',
                    cancelButton: 'btn btn-merah-color'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) submitAdopsi()
            })
        }

        function submitAdopsi() {
            document.getElementById('fullscreen-loading').classList.remove('d-none')
            const data = {
                adopter_id: '{{ $adopter_id }}',
                hewan_id: '{{ $detailShelter->id }}',
                shelter_id: '{{ $detailShelter->shelter->id }}',
                alasan: '{{ $alasan }}'
            }
            fetch("{{ route('adopter.ajukanAdopsi') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify(data)
                })
                .then(res => res.json())
                .then(res => {
                    document.getElementById('fullscreen-loading').classList.add('d-none')
                    if (res.success) {
                        Swal.fire({
                            icon: "success",
                            title: res.title,
                            text: res.message,
                            customClass: {
                                actions: 'swal-actions-gap',
                                icon: 'swal-success-primary',
                                confirmButton: 'btn btn-primary-color',
                            },
                            buttonsStyling: false
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
                    }
                })
        }
    </script>
@endsection
