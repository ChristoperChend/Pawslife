<style>
    .adopter-image {
        width: 600px;
        height: 450px !important;
        border-radius: 10px;
        margin-bottom: 1.5rem;
    }

    div h5 {
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
</style>

@extends('layout.master')

@section('content')

    <div class="container py-5">
        <div class="row">
            <div class="col-12 col-md-6 text-center">
                <img src="{{ asset('storage/' . $adopter->adopter->foto_adopter) }}" class="adopter-image img-fluid" alt="Adopter Image">
            </div>

            <div class="col-12 col-md-6">
                <div class="row detail-row">
                    <div class="col-12">
                        <h5>Nama lengkap</h5>
                        <label class="border shadow-sm w-100 p-2 text-white rounded-2 mb-3 position-relative">
                            <span id="text_nama_lengkap">{{ $adopter->adopter->nama_lengkap ?? 'data tidak ada' }}</span>
                            <input type="text" id="input_nama_lengkap" value="{{ $adopter->adopter->nama_lengkap }}" class="form-control d-none">
                            <a href="#" class="float-end text-decoration-none text-black" id="edit_nama_lengkap" onclick="editField('nama_lengkap')">edit</a>
                            <button class="btn btn-outline-primary float-end d-none" id="save_nama_lengkap" onclick="saveField('nama_lengkap'); return false;">Simpan</button>
                        </label>
                    </div>
                </div>

                <div class="row detail-row">
                    <div class="col-12">
                        <h5>Email</h5>
                        <label class="border shadow-sm w-100 p-2 text-white rounded-2 mb-3">{{ $adopter->email ?? 'data tidak ada' }}</label>
                    </div>
                </div>

                <div class="row detail-row">
                    <div class="col-12">
                        <h5>Alamat</h5>
                        <label class="border shadow-sm w-100 p-2 text-white rounded-2 mb-3 position-relative">
                            <span id="text_alamat">{{ $adopter->adopter->alamat ?? 'data tidak ada' }}</span>
                            <input type="text" id="input_alamat" value="{{ $adopter->adopter->alamat }}" class="form-control d-none">
                            <a href="#" class="float-end text-decoration-none text-black" id="edit_alamat" onclick="editField('alamat')">edit</a>
                            <button class="btn btn-outline-primary float-end d-none" id="save_alamat" onclick="saveField('alamat'); return false;">Simpan</button>
                        </label>
                    </div>
                </div>

                <div class="row detail-row">
                    <div class="col-12">
                        <h5>Usia</h5>
                        <label class="border shadow-sm w-100 p-2 text-white rounded-2 mb-3 position-relative">
                            <span id="text_usia">{{ $adopter->adopter->usia ?? 'data tidak ada' }}</span>
                            <input type="text" id="input_usia" value="{{ $adopter->adopter->usia }}" class="form-control d-none">
                            <a href="#" class="float-end text-decoration-none text-black" id="edit_usia" onclick="editField('usia')">edit</a>
                            <button class="btn btn-outline-primary float-end d-none" id="save_usia" onclick="saveField('usia'); return false;">Simpan</button>
                        </label>
                    </div>
                </div>

                <div class="row detail-row">
                    <div class="col-12">
                        <h5>No Handphone</h5>
                        <label class="border shadow-sm w-100 p-2 text-white rounded-2 mb-3 position-relative">
                            <span id="text_no_handphone">{{ $adopter->adopter->no_handphone ?? 'data tidak ada' }}</span>
                            <input type="text" id="input_no_handphone" value="{{ $adopter->adopter->no_handphone }}" class="form-control d-none">
                            <a href="#" class="float-end text-decoration-none text-black" id="edit_no_handphone" onclick="editField('no_handphone')">edit</a>
                            <button class="btn btn-outline-primary float-end d-none" id="save_no_handphone" onclick="saveField('no_handphone'); return false;">Simpan</button>
                        </label>
                    </div>
                </div>

                <div class="row detail-row">
                    <div class="col-12">
                        <h5>No Whatsapp</h5>
                        <label class="border shadow-sm w-100 p-2 text-white rounded-2 mb-3 position-relative">
                            <span id="text_no_whatsapp">{{ $adopter->adopter->no_whatsapp ?? 'data tidak ada' }}</span>
                            <input type="text" id="input_no_whatsapp" value="{{ $adopter->adopter->no_whatsapp }}" class="form-control d-none">
                            <a href="#" class="float-end text-decoration-none text-black" id="edit_no_whatsapp" onclick="editField('no_whatsapp')">edit</a>
                            <button class="btn btn-outline-primary float-end d-none" id="save_no_whatsapp" onclick="saveField('no_whatsapp'); return false;">Simpan</button>
                        </label>
                    </div>
                </div>

                <div class="row detail-row">
                    <div class="col-12">
                        <h5>Pekerjaan</h5>
                        <label class="border shadow-sm w-100 p-2 text-white rounded-2 mb-3 position-relative">
                            <span id="text_pekerjaan">{{ $adopter->adopter->pekerjaan ?? 'data tidak ada' }}</span>
                            <input type="text" id="input_pekerjaan" value="{{ $adopter->adopter->pekerjaan }}" class="form-control d-none">
                            <a href="#" class="float-end text-decoration-none text-black" id="edit_pekerjaan" onclick="editField('pekerjaan')">edit</a>
                            <button class="btn btn-outline-primary float-end d-none" id="save_pekerjaan" onclick="saveField('pekerjaan'); return false;">Simpan</button>
                        </label>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a href="#" onclick="confirmLogout(event)" class="btn btn-warning w-30 fw-bold ms-4 mr">Logout</a>
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
                })
                .then(res => res.json())
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
                })
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