<style>
    .hewan-image {
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
                <img src="{{ asset('storage/' . $detailHewan->foto_hewan) }}" class="hewan-image img-fluid" alt="Hewan Image">
                <label class="secondary-color w-75 p-2 text-white mb-3 mt-3 rounded-2">{{ $detailHewan->nama_hewan ?? 'data tidak ada' }}</label>
            </div>

            <div class="col-12 col-md-6">
                <div class="row detail-row">
                    <div class="col-12">
                        <h5>Nama shelter</h5>
                        <label class="secondary-color w-100 p-2 text-white rounded-2 mb-3">{{ $detailHewan->shelter->nama_shelter ?? 'data tidak ada' }}</label>
                    </div>
                </div>

                <div class="row detail-row">
                    <div class="col-12">
                        <h5>Jenis hewan</h5>
                        <label class="secondary-color w-100 p-2 text-white rounded-2 mb-3">{{ $detailHewan->jenis_hewan ?? 'data tidak ada' }}</label>
                    </div>
                </div>

                <div class="row detail-row">
                    <div class="col-12">
                        <h5>Ras hewan</h5>
                        <label class="secondary-color w-100 p-2 text-white rounded-2 mb-3">{{ $detailHewan->ras ?? 'data tidak ada' }}</label>
                    </div>
                </div>

                <div class="row detail-row">
                    <div class="col-12">
                        <h5>Jenis kelamin hewan</h5>
                        <label class="secondary-color w-100 p-2 text-white rounded-2 mb-3">{{ $detailHewan->jenis_kelamin ?? 'data tidak ada' }}</label>
                    </div>
                </div>

                <div class="row detail-row">
                    <div class="col-12">
                        <h5>Berat hewan</h5>
                        <label class="secondary-color w-100 p-2 text-white rounded-2 mb-3">{{ $detailHewan->berat ?? 'data tidak ada' }}</label>
                    </div>
                </div>

                <div class="row detail-row">
                    <div class="col-12">
                        <h5>Apakah hewan sudah disteril</h5>
                        <label class="secondary-color w-100 p-2 text-white rounded-2 mb-3">{{ $detailHewan->status_steril ?? 'data tidak ada' }}</label>
                    </div>
                </div>

                <div class="row detail-row">
                    <div class="col-12">
                        <h5>Apakah hewan sudah divaksin</h5>
                        <label class="secondary-color w-100 p-2 text-white rounded-2 mb-3">{{ $detailHewan->status_vaksin ?? 'data tidak ada' }}</label>
                    </div>
                </div>

                <div class="row detail-row">
                    <div class="col-12">
                        <h5>Catatan medis hewan</h5>
                        <label class="secondary-color w-100 p-2 text-white rounded-2 mb-3">{{ $detailHewan->catatan_medis ?? 'data tidak ada' }}</label>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary w-30 fw-bold">Kembali</button>
                    <button type="submit" class="btn btn-primary w-30 fw-bold ms-4 mr">Ajukan Adopsi</button>
                </div>
            </div>
        </div>
    </div>

@endsection