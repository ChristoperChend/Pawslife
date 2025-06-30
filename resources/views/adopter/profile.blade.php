<style>
    .adopter-image {
        width: 600px;
        height: 450px !important;
        border-radius: 10px;
    }

    div h5 {
        margin-bottom: 0px;
    }

    .detail-row {
        margin-bottom: 15px;
    }
    .detail-row label {
        margin-bottom: 0;
    }

    .mr {
        margin-right: 0.7em !important;
    }
</style>

@extends('layout.master')

@section('content')

    <div class="container mt-5">
        <div class="row">
            <div class="col-12 col-md-6 text-center">
                <img src="{{ asset('storage/' . $adopter->adopter->foto_adopter) }}" class="adopter-image img-fluid" alt="Adopter Image">
            </div>

            <div class="col-12 col-md-6">
                <div class="row detail-row">
                    <div class="col-12">
                        <h5>Nama lengkap</h5>
                        <label class="secondary-color w-100 p-2 text-white rounded-2 mb-3">
                            {{ $adopter->adopter->nama_lengkap ?? 'data tidak ada' }}
                            <a href="" class="float-end text-decoration-none text-white">edit</a>
                        </label>
                    </div>
                </div>

                <div class="row detail-row">
                    <div class="col-12">
                        <h5>Email</h5>
                        <label class="secondary-color w-100 p-2 text-white rounded-2 mb-3">{{ $adopter->email ?? 'data tidak ada' }}</label>
                    </div>
                </div>

                <div class="row detail-row">
                    <div class="col-12">
                        <h5>Alamat</h5>
                        <label class="secondary-color w-100 p-2 text-white rounded-2 mb-3">
                            {{ $adopter->adopter->alamat ?? 'data tidak ada' }}
                            <a href="" class="float-end text-decoration-none text-white">edit</a>
                        </label>
                    </div>
                </div>

                <div class="row detail-row">
                    <div class="col-12">
                        <h5>Usia</h5>
                        <label class="secondary-color w-100 p-2 text-white rounded-2 mb-3">
                            {{ $adopter->adopter->usia ?? 'data tidak ada' }}
                            <a href="" class="float-end text-decoration-none text-white">edit</a>
                        </label>
                    </div>
                </div>

                <div class="row detail-row">
                    <div class="col-12">
                        <h5>No handphone</h5>
                        <label class="secondary-color w-100 p-2 text-white rounded-2 mb-3">
                            {{ $adopter->adopter->no_handphone ?? 'data tidak ada' }}
                            <a href="" class="float-end text-decoration-none text-white">edit</a>
                        </label>
                    </div>
                </div>

                <div class="row detail-row">
                    <div class="col-12">
                        <h5>No whatsapp</h5>
                        <label class="secondary-color w-100 p-2 text-white rounded-2 mb-3">
                            {{ $adopter->adopter->no_whatsapp ?? 'data tidak ada' }}
                            <a href="" class="float-end text-decoration-none text-white">edit</a>
                        </label>
                    </div>
                </div>

                <div class="row detail-row">
                    <div class="col-12">
                        <h5>Pekerjaan</h5>
                        <label class="secondary-color w-100 p-2 text-white rounded-2 mb-3">
                            {{ $adopter->adopter->pekerjaan ?? 'data tidak ada' }}
                            <a href="" class="float-end text-decoration-none text-white">edit</a>
                        </label>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-warning w-30 fw-bold ms-4 mr">Logout</a>
                </div>
            </div>
        </div>
    </div>

@endsection