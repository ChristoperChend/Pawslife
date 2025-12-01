<style>
    .page-header h2 {
        font-weight: 700;
        font-size: 1.9rem;
        margin-bottom: .5rem;
    }

    .adopter-image {
        width: 100%;
        max-width: 400px;
        height: 400px;
        object-fit: cover;
        border-radius: 12px;
        border: 1px solid #e5e5e5;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .detail-row div h5 {
        margin-bottom: 0px;
        font-weight: normal !important;
        font-size: 18px;
        margin-bottom: 5px;
    }

    .detail-row {
        margin-bottom: 15px;
    }
    .detail-row label {
        margin-bottom: 0;
        color: black !important;
        background: white !important;
    }

    .detail-row label input {
        width: 80%;
        display: inline-block;
    }

    .detail-row label button {
        margin-right: 10px;
    }

    .mr {
        margin-right: 0.7em !important;
    }

    .detail-label {
        font-size: 0.95rem;
        font-weight: 500 !important;
        color: #495057 !important;
        margin-bottom: 10px
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

    .detail-text {
        flex-grow: 1 !important;
        color: #212529 !important; 
        font-size: 1rem !important;
        font-weight: 600 !important;
        border: none !important;
    }

    .form-control:focus {
        box-shadow: none !important;
    }

    .detail-input {
        flex-grow: 1;
        border: none !important;
        box-shadow: none !important;
        padding: 0;
        margin-right: 10px;
        font-size: 1rem;
        font-weight: 600;
        height: auto;
    }

    .edit-link {
        color: var(--primary-color);
        font-size: 0.9rem;
        font-weight: 600;
        flex-shrink: 0;
    }

    .save-btn {
        font-size: 0.85rem !important;
        padding: 3px 10px !important;
        border-radius: 5px;
        flex-shrink: 0;
    }

    .detail-field-wrapper .form-control {
        display: inline-block;
        width: 100%;
        padding: 0;
    }

    .detail-field-wrapper.edit-mode {
        border-color: #007bff; 
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.2);
        padding: 10px 10px;
    }

    .btn-logout-custom {
        padding: 8px 30px;
        font-size: 1.1rem;
        border-radius: 5px;
    }

    @media (max-width: 767.98px) {
        .col-12.col-md-6.d-flex.justify-content-start {
            justify-content: center !important;
        }
        
        .col-12.col-md-6.d-flex.justify-content-end {
            justify-content: center !important;
            margin-bottom: 10px !important;
        }
    }
</style>

@extends('layout.master')

@section('content')

    <div class="container py-4">
        <div class="page-header text-center" style="max-width: 860px; margin: 2rem auto;">
            <h2>Profil Adopter</h2>
        </div>
        <div class="card shadow-sm border-0 mx-auto" style="max-width: 900px;">
            <div class="card-body p-md-5">
                <form action="{{ route('adopter.updateProfile', $adopter->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
    
                    <div class="text-center mb-4">
                        <img src="{{ asset('storage/' . $adopter->foto_adopter) }}" 
                            alt="Foto Adopter" class="adopter-image mb-3">
                        <div class="mb-3" style="max-width: 320px; margin: 0 auto;">
                            <label class="form-label fw-semibold">Ganti Foto Adopter</label>
                            <input type="file" name="foto_adopter" class="form-control" accept=".jpg, .jpeg, .png">
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                            <div class="detail-field-wrapper">
                                <input type="text" name="nama_adopter" class="form-control detail-text" 
                                value="{{ old('nama_adopter', $adopter->nama_lengkap) }}" required>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                            <div class="detail-field-wrapper" style="background-color: #f3f3f3 !important;">
                                <span class="detail-text">{{ $adopter->pengguna->email ?? 'data tidak ada' }}</span>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Alamat <span class="text-danger">*</span></label>
                            <div class="detail-field-wrapper" style="padding: 0px">
                                <textarea 
                                    name="alamat_adopter" 
                                    class="form-control detail-text" 
                                    rows="3" 
                                    style="padding: 10px 15px;"
                                    required
                                >{{ old('alamat_adopter', $adopter->alamat) }}</textarea>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Usia <span class="text-danger">*</span></label>
                            <div class="detail-field-wrapper">
                                <input type="text" name="usia_adopter" class="form-control detail-text" 
                                value="{{ old('usia_adopter', $adopter->usia) }}" required>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Pekerjaan <span class="text-danger">*</span></label>
                            <div class="detail-field-wrapper">
                                <input type="text" name="pekerjaan_adopter" class="form-control detail-text" 
                                value="{{ old('pekerjaan_adopter', $adopter->pekerjaan) }}" required>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">No Handphone <span class="text-danger">*</span></label>
                            <div class="detail-field-wrapper">
                                <input type="text" name="nomor_telepon_adopter" class="form-control detail-text" 
                                value="{{ old('nomor_telepon_adopter', $adopter->no_handphone) }}" required>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">No Whatsapp <span class="text-danger">*</span></label>
                            <div class="detail-field-wrapper">
                                <input type="text" name="nomor_wa_adopter" class="form-control detail-text" 
                                value="{{ old('nomor_wa_adopter', $adopter->no_whatsapp) }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4 align-items-center">
                        <div class="col-12 col-md-6 d-flex justify-content-start gap-3 flex-wrap order-md-1 order-2">
                            <a href="{{ url()->previous() }}" class="btn btn-kembali">Kembali</a>
                            <a href="#" onclick="confirmLogout(event)" class="btn btn-merah-color">Logout</a>
                        </div>

                        <div class="col-12 col-md-6 d-flex justify-content-end gap-2 flex-wrap mt-2 mt-md-0 order-md-2 order-1">
                            <button type="submit" class="btn btn-primary-color">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    @include('layout.loading')

    <script>
        function confirmLogout(event) {
            event.preventDefault();
            Swal.fire({
                icon: "question",
                title: "Konfirmasi Logout",
                text: "Apakah Anda yakin ingin logout?",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Logout",
                cancelButtonText: "Kembali",
                reverseButtons: true,
                customClass: {
                    actions: 'swal-actions-gap',
                    icon: 'swal-question-primary',
                    cancelButton: 'btn btn-primary-color',
                    confirmButton: 'btn btn-merah-color'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form[method="POST"][enctype="multipart/form-data"]');

            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const formData = new FormData(form); 
                    Swal.fire({
                        icon: 'question',
                        title: 'Apakah Anda yakin?',
                        text: 'Apakah Anda yakin ingin mengubah data adopter?',
                        showCancelButton: true,
                        confirmButtonText: 'Yakin',
                        cancelButtonText: 'Kembali',
                        reverseButtons: true,
                        confirmButtonColor: '#0d6efd',
                        cancelButtonColor: '#6c757d',
                        customClass: {
                            actions: 'swal-actions-gap',
                            icon: 'swal-question-primary',
                            confirmButton: 'btn btn-primary-color',
                            cancelButton: 'btn btn-merah-color'
                        },
                        buttonsStyling: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('fullscreen-loading').classList.remove('d-none');
                            fetch(form.action, {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                }
                            })
                            .then(res => res.json())
                            .then(data => {
                                document.getElementById('fullscreen-loading').classList.add('d-none');
                                if (data.success) {
                                    Swal.fire({
                                        icon: "success",
                                        title: data.title,
                                        text: data.message,
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
                                        title: data.title,
                                        text: data.message,
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
                            .catch(err => {
                                document.getElementById('fullscreen-loading').classList.add('d-none');
                                Swal.fire({
                                    icon: "error",
                                    title: "Gagal",
                                    text: "Terjadi kesalahan saat mengirim data.",
                                    customClass: {
                                        actions: 'swal-actions-gap',
                                        confirmButton: 'btn btn-primary-color',
                                    },
                                    buttonsStyling: false
                                })
                                .then(() => {
                                    location.reload();
                                })
                                console.error(err);
                            });
                        }
                    });
                });
            }
        });
    </script>

@endsection