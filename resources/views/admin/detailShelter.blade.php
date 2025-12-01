<style>
    .shelter-image {
        width: 100%;
        max-width: 400px;
        height: 400px;
        object-fit: cover;
        border-radius: 12px;
        border: 1px solid #e5e5e5;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .dokumen-image {
        width: 450px;
        height: 350px !important;
        border-radius: 10px;
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
        font-weight: 500 !important;
        color: #495057 !important;
    }

    .detail-text {
        flex-grow: 1;
        color: #212529; 
        font-size: 1rem;
    }

    .page-header {
        max-width: 1060px;
        margin: 24px auto 0;
    }
    .page-header h2 {
        font-weight: 800;
        letter-spacing: .3px;
    }

    @media (max-width: 576px) {
        .shelter-image {
            height: 350px !important;
        }

        .dokumen-image {
            height: 300px !important;
        }
    }
</style>

@extends('layout.master')

@section('content')
    <div class="container py-4">
        <div class="page-header text-center" style="max-width: 860px; margin: 2rem auto;">
            <h2>Detail Shelter</h2>
        </div>

        <div class="card shadow-sm border-0 mx-auto" style="max-width: 900px;">
            <div class="card-body p-md-5">
                <div class="text-center mb-4">
                    <img src="{{ asset($detailShelter->foto_shelter) }}" 
                        alt="{{ $detailShelter->nama_shelter }}"  
                        class="shelter-image mb-3">
                </div>

                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Nama Shelter</label>
                        <div class="detail-field-wrapper">
                            <span class="detail-text">{{ $detailShelter->nama_shelter ?? 'Data tidak tersedia' }}</span>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Email Shelter</label>
                        <div class="detail-field-wrapper">
                            <span class="detail-text">{{ $detailShelter->pengguna->email ?? 'Data tidak tersedia' }}</span>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-semibold">No Telepon</label>
                        <div class="detail-field-wrapper">
                            <span class="detail-text">{{ $detailShelter->no_telepon_shelter ?? 'Data tidak tersedia' }}</span>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Alamat</label>
                        <div class="detail-field-wrapper">
                            <span class="detail-text">{{ $detailShelter->alamat_shelter ?? 'Data tidak tersedia' }}</span>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Dokumen Legalitas Pendirian</label>
                        <div class="detail-field-wrapper">
                            <img src="{{ asset($detailShelter->dokumen_legal) }}" class="dokumen-image img-fluid" alt="Foto Dokumen Shelter">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Deskripsi Shelter</label>
                        <div class="detail-field-wrapper">
                            <span class="detail-text">{{ $detailShelter->deskripsi_shelter ?? 'Data tidak tersedia' }}</span>
                        </div>
                    </div>
                </div>

                @if ($detailShelter->status == "diajukan")
                    <div class="d-flex justify-content-end mt-5 gap-3">
                        <button type="button" class="btn btn-merah-color" onclick="tolakShelter('{{ $detailShelter->id }}')">Tolak</button>
                        <button type="button" class="btn btn-primary-color" style="margin-right: 8px" onclick="setujuShelter('{{ $detailShelter->id }}')">Setuju</button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @extends('layout.loading')

    <script>
        function tolakShelter(id) {
            Swal.fire({
                icon: "question",
                title: "Penolakan Shelter",
                text: "Apakah anda yakin bahwa data yang diberikan tidak valid?",
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
                    fetch('{{ route('admin.tolakShelter') }}', {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            shelter_id: id
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

        function setujuShelter(id) {
            Swal.fire({
                icon: "question",
                title: "Persetujuan Shelter",
                text: "Apakah anda yakin bahwa data yang diberikan valid dan benar adanya?",
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
                    fetch('{{ route('admin.setujuShelter') }}', {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            shelter_id: id
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