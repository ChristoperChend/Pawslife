<style>
    .hewan-image {
        width: 100%;
        max-width: 400px;
        height: 400px;
        object-fit: cover;
        border-radius: 12px;
        border: 1px solid #e5e5e5;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .page-header {
        max-width: 1060px;
        margin: 24px auto 0;
    }

    .page-header h2 {
        font-weight: 800;
        letter-spacing: .3px;
    }

    .detail-field-wrapper {
        display: flex;
        align-items: center;
        justify-content: space-between;
        border: 1px solid #cacaca;
        border-left: 5px solid var(--primary-color);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        border-radius: 8px;
        padding: 10px 15px;
        position: relative;
        transition: all 0.2s ease;
    }

    .detail-field-wrapper:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
    }

    .detail-label {
        font-size: 0.95rem;
        font-weight: bold;
        color: #495057 !important;
    }

    .detail-text {
        flex-grow: 1 !important;
        color: #212529 !important;
        font-size: 1rem !important;
        border: none !important;
    }

    .ajukan-adopsi {
        text-align: justify;
    }

    .form-control:disabled {
        background-color: #fff !important;
    }

    @media (max-width: 576px) {
        .row>* {
            padding-right: 3px !important;
            padding-left: 3px !important;
        }

        .hewan-image {
            height: 350px !important;
        }
    }
</style>

@extends('layout.master')

@section('content')
    <div class="container py-5">
        <div class="page-header text-center" style="max-width: 860px; margin: 2rem auto;">
            <h2>Detail Hewan</h2>
        </div>

        <div class="card shadow-sm border-0 mx-auto" style="max-width: 900px;">
            <div class="card-body p-md-5">
                <div class="row-12 row-md-6 text-center mb-4">
                    <img src="{{ asset('storage/' . $detailHewan->foto_hewan) }}" class="hewan-image"
                        alt="{{ $detailHewan->nama_hewan }}">
                </div>
                <div class="row mb-4">
                    <div class="col-6">
                        <label class="form-label fw-semibold">Nama Shelter</label>
                        <a href="{{ route('adopter.detailShelter', ['id' => $detailHewan->shelter->id]) }}"
                            class="text-decoration-none cursor">
                            <div class="detail-field-wrapper">
                                <span
                                    class="detail-text">{{ $detailHewan->shelter->nama_shelter ?? 'data tidak ada' }}</span>
                                <i class="fa-solid fa-chevron-right fa-2xs" style="color: #000000;"></i>
                            </div>
                        </a>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold">Nama hewan</label>
                        <div class="detail-field-wrapper">
                            <span class="detail-text">{{ $detailHewan->nama_hewan ?? 'data tidak ada' }}</span>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-6">
                        <label class="form-label fw-semibold">Jenis hewan</label>
                        <div class="detail-field-wrapper">
                            <span class="detail-text">{{ $detailHewan->jenis_hewan ?? 'data tidak ada' }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold">Ras hewan</label>
                        <div class="detail-field-wrapper">
                            <span class="detail-text">{{ $detailHewan->ras ?? 'data tidak ada' }}</span>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-6">
                        <label class="form-label fw-semibold">Jenis kelamin hewan</label>
                        <div class="detail-field-wrapper">
                            <span class="detail-text">{{ $detailHewan->jenis_kelamin ?? 'data tidak ada' }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold">Berat hewan (Kg)</label>
                        <div class="detail-field-wrapper">
                            <span class="detail-text">{{ $detailHewan->berat ?? 'data tidak ada' }}</span>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-6">
                        <label class="form-label fw-semibold">Apakah hewan sudah disteril</label>
                        <div class="detail-field-wrapper">
                            <span class="detail-text">{{ $detailHewan->status_steril ?? 'data tidak ada' }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold">Tanggal Sterilisasi</label>
                        <div class="detail-field-wrapper">
                            <span
                                class="detail-text">{{ $detailHewan->tanggal_steril ? \Carbon\Carbon::parse($detailHewan->tanggal_steril)->format('d F Y') : '-' }}</span>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-6">
                        <label class="form-label fw-semibold">Apakah hewan sudah divaksin</label>
                        <div class="detail-field-wrapper">
                            <span class="detail-text">{{ $detailHewan->status_vaksin ?? 'data tidak ada' }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold">Tanggal Vaksinasi</label>
                        <div class="detail-field-wrapper">
                            <span
                                class="detail-text">{{ $detailHewan->tanggal_vaksin ? \Carbon\Carbon::parse($detailHewan->tanggal_vaksin)->format('d F Y') : '-' }}</span>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <label class="form-label fw-semibold">Catatan medis hewan</label>
                        <div class="detail-field-wrapper" style="padding: 0px">
                            <textarea class="form-control detail-text" style="padding: 10px 15px;" rows="3" disabled>{{ $detailHewan->catatan_medis ?? 'data tidak ada' }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <label class="form-label fw-semibold">Deskripsi hewan</label>
                        <div class="detail-field-wrapper" style="padding: 0px">
                            <textarea class="form-control detail-text" style="padding: 10px 15px;" rows="3" disabled>{{ $detailHewan->deskripsi_hewan ?? 'data tidak ada' }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-5 gap-3">
                    <a href="{{ route('adopter.persyaratanAdopsi') }}" style="margin-left: 11px;"
                        class="btn btn-kembali">Kembali</a>
                    <button type="button" style="margin-right: 10px" class="btn btn-primary-color"
                        onclick="ajukanAdopsi()">Ajukan Adopsi</button>
                </div>
            </div>
        </div>
    </div>

    @include('layout.loading')

    <script>
        function ajukanAdopsi() {
            const adopterId = '{{ $adopter_id }}';

            if (!adopterId || adopterId == 0 || adopterId == "0") {
                Swal.fire({
                    icon: "error",
                    title: "Harus Login",
                    text: "Silahlan lakukan login sebagai adopter untuk melanjutkan proses pengajuan adopsi.",
                    showCancelButton: true,
                    cancelButtonText: "Kembali",
                    confirmButtonText: "Login",
                    reverseButtons: true,
                    customClass: {
                        actions: 'swal-actions-gap',
                        confirmButton: 'btn btn-primary-color',
                        cancelButton: 'btn btn-kembali'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('login') }}";
                    }
                });
                return;
            }

            Swal.fire({
                    icon: "question",
                    title: "Alasan Pengajuan Adopsi",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Selanjutnya",
                    cancelButtonText: "Kembali",
                    reverseButtons: true,
                    width: '800px',
                    html: '<div><hr> <h6 class="text-start">Apa alasan anda ingin mengadopsi hewan ini?</h6> <textarea class="form-control" rows="4" id="alasan_adopsi"></textarea> <hr></div>',
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
                    if (result.isConfirmed) {
                        const alasan = result.value;
                        document.getElementById('fullscreen-loading').classList.remove('d-none')
                        const data = {
                            adopter_id: '{{ $adopter_id }}',
                            hewan_id: '{{ $detailHewan->id }}',
                            shelter_id: '{{ $detailHewan->shelter->id }}',
                            alasan: alasan
                        }
                        fetch("{{ route('adopter.persyaratanAdopsi') }}", {
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
                                    window.location.href = res.redirect_url;
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
                })
        }
    </script>
@endsection
