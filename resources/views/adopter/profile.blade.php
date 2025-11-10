<style>
    .adopter-image {
        width: 600px! important;
        height: 450px !important;
        border-radius: 10px;
        margin-bottom: 1.5rem;
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
        flex-grow: 1;
        color: #212529; 
        font-size: 1rem;
        font-weight: 600;
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
</style>

@extends('layout.master')

@section('content')

    <div class="container py-5">
        <div class="row">
            <div class="col-12 col-md-6 text-center">
                <img src="{{ asset('storage/' . $adopter->adopter->foto_adopter) }}" class="adopter-image img-fluid" alt="Adopter Image">
            </div>

            <div class="col-12 col-md-6">
                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="detail-label"><i class="fa-solid fa-user me-1"></i> Nama Lengkap</h5>
                        <div class="detail-field-wrapper">
                            <span id="text_nama_lengkap" class="detail-text">{{ $adopter->adopter->nama_lengkap ?? 'data tidak ada' }}</span>
                            <input type="text" id="input_nama_lengkap" value="{{ $adopter->adopter->nama_lengkap }}" class="form-control d-none detail-input">
                            
                            <a href="#" class="edit-link text-decoration-none" id="edit_nama_lengkap" onclick="editField('nama_lengkap'); return false;">edit</a>
                            <button class="btn btn-primary btn-sm save-btn d-none" id="save_nama_lengkap" onclick="saveField('nama_lengkap'); return false;">Simpan</button>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="detail-label"><i class="fa-solid fa-envelope me-1"></i> Email</h5>
                        <div class="detail-field-wrapper">
                            <span class="detail-text">{{ $adopter->email ?? 'data tidak ada' }}</span>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="detail-label"><i class="fa-solid fa-map-location-dot me-1"></i> Alamat</h5>
                        <div class="detail-field-wrapper">
                            <span id="text_alamat" class="detail-text">{{ $adopter->adopter->alamat ?? 'data tidak ada' }}</span>
                            <input type="text" id="input_alamat" value="{{ $adopter->adopter->alamat }}" class="form-control d-none detail-input">
                            
                            <a href="#" class="edit-link text-decoration-none" id="edit_alamat" onclick="editField('alamat'); return false;">edit</a>
                            <button class="btn btn-primary btn-sm save-btn d-none" id="save_alamat" onclick="saveField('alamat'); return false;">Simpan</button>
                        </div>
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="detail-label"><i class="fa-solid fa-calendar-day me-1"></i> Usia</h5>
                        <div class="detail-field-wrapper">
                            <span id="text_usia" class="detail-text">{{ $adopter->adopter->usia ?? 'data tidak ada' }}</span>
                            <input type="text" id="input_usia" value="{{ $adopter->adopter->usia }}" class="form-control d-none detail-input">
                            
                            <a href="#" class="edit-link text-decoration-none" id="edit_usia" onclick="editField('usia'); return false;">edit</a>
                            <button class="btn btn-primary btn-sm save-btn d-none" id="save_usia" onclick="saveField('usia'); return false;">Simpan</button>
                        </div>
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="detail-label"><i class="fa-solid fa-mobile-screen-button me-1"></i> No Handphone</h5>
                        <div class="detail-field-wrapper">
                            <span id="text_no_handphone" class="detail-text">{{ $adopter->adopter->no_handphone ?? 'data tidak ada' }}</span>
                            <input type="text" id="input_no_handphone" value="{{ $adopter->adopter->no_handphone }}" class="form-control d-none detail-input">
                            
                            <a href="#" class="edit-link text-decoration-none" id="edit_no_handphone" onclick="editField('no_handphone'); return false;">edit</a>
                            <button class="btn btn-primary btn-sm save-btn d-none" id="save_no_handphone" onclick="saveField('no_handphone'); return false;">Simpan</button>
                        </div>
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="detail-label"><i class="fa-brands fa-whatsapp me-1"></i> No Whatsapp</h5>
                        <div class="detail-field-wrapper">
                            <span id="text_no_whatsapp" class="detail-text">{{ $adopter->adopter->no_whatsapp ?? 'data tidak ada' }}</span>
                            <input type="text" id="input_no_whatsapp" value="{{ $adopter->adopter->no_whatsapp }}" class="form-control d-none detail-input">
                            
                            <a href="#" class="edit-link text-decoration-none" id="edit_no_whatsapp" onclick="editField('no_whatsapp'); return false;">edit</a>
                            <button class="btn btn-primary btn-sm save-btn d-none" id="save_no_whatsapp" onclick="saveField('no_whatsapp'); return false;">Simpan</button>
                        </div>
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="detail-label"><i class="fa-solid fa-briefcase me-1"></i> Pekerjaan</h5>
                        <div class="detail-field-wrapper">
                            <span id="text_pekerjaan" class="detail-text">{{ $adopter->adopter->pekerjaan ?? 'data tidak ada' }}</span>
                            <input type="text" id="input_pekerjaan" value="{{ $adopter->adopter->pekerjaan }}" class="form-control d-none detail-input">
                            
                            <a href="#" class="edit-link text-decoration-none" id="edit_pekerjaan" onclick="editField('pekerjaan'); return false;">edit</a>
                            <button class="btn btn-primary btn-sm save-btn d-none" id="save_pekerjaan" onclick="saveField('pekerjaan'); return false;">Simpan</button>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-5">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a href="#" onclick="confirmLogout(event)" class="btn btn-warning fw-bold btn-logout-custom">Logout</a>
                </div>
            </div>
        </div>
    </div>

    @include('layout.loading')

    <script>
        function editField(field) {
            document.getElementById('text_' + field).style.display = 'none'
            document.getElementById('input_' + field).classList.remove('d-none')
            document.getElementById('edit_' + field).classList.add('d-none')
            document.getElementById('save_' + field).classList.remove('d-none')
        }

        function saveField(field) {
            Swal.fire({
                icon: "question",
                title: "Perubahan Data",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yakin",
                cancelButtonText: "Kembali",
                reverseButtons: true,
                text: 'Apakah anda yakin mengubah data?'
            })
            .then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('fullscreen-loading').classList.remove('d-none')
                    const data = {
                        value: document.getElementById('input_' + field).value,
                        field: field
                    }
                    fetch("{{ route('adopter.updateProfile') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify(data)
                    }).then(res => res.json())
                    .then(res => {
                        document.getElementById('fullscreen-loading').classList.add('d-none')
                        if (res.success) {
                            Swal.fire({
                                icon: 'success',
                                title: res.title,
                                text: res.message,
                            })
                            .then(() => {
                                location.reload();
                            })
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: res.title,
                                text: res.message,
                            })
                            .then(() => {
                                location.reload();
                            })
                        }
                    }).catch(error => {
                        document.getElementById('fullscreen-loading').classList.add('d-none');
                        Swal.fire('Error!', 'Terjadi kesalahan saat menyimpan data.', 'error');
                        location.reload();
                    });
                } else {
                    location.reload()
                }
            })
        }

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
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }
    </script>

@endsection