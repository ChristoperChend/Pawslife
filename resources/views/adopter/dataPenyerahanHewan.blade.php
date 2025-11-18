@extends('layout.master')

<style>
    .detail-field-wrapper {
        display: flex;
        align-items: center;
        justify-content: space-between;
        border: 1px solid #cacaca;
        border-left: 5px solid var(--primary-color);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        border-radius: 8px;
        padding: 7px 10px;
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
        font-weight: 400;
    }
</style>

@section('content')
<div class="container py-5">
    <div class="text-center mb-4">
        <h2 class="fw-bold fs-3 mb-2">Data Penyerahan Hewan</h2>
    </div>

    <div class="card border-0 mx-auto" style="max-width: 860px; border-radius: 12px; box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);">
        <div class="card-body p-5">

            <div class="text-center mb-4">
                <img src="{{ asset($data->foto_hewan) }}" 
                    alt="{{$data->nama_hewan }}"
                    class="img-fluid rounded shadow-sm"
                    style="width: 230px; height: 230px; object-fit: cover;">
            </div>

            <div class="row g-4">
                <div class="col-md-6">
                    <h5 class="detail-label">Nama hewan</h5>
                    <div class="detail-field-wrapper">
                        <span class="detail-text">{{ $data->nama_hewan ?? 'data tidak ada' }}</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <h5 class="detail-label">Ras hewan</h5>
                    <div class="detail-field-wrapper">
                        <span class="detail-text">{{ $data->ras ?? 'data tidak ada' }}</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <h5 class="detail-label">Status vaksin</h5>
                    <div class="detail-field-wrapper">
                        <span class="detail-text">{{ $data->status_vaksin ?? 'data tidak ada' }}</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <h5 class="detail-label">Status steril</h5>
                    <div class="detail-field-wrapper">
                        <span class="detail-text">{{ $data->status_steril ?? 'data tidak ada' }}</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <h5 class="detail-label">Jenis hewan</h5>
                    <div class="detail-field-wrapper">
                        <span class="detail-text">{{ $data->jenis_hewan ?? 'data tidak ada' }}</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <h5 class="detail-label">Jenis kelamin hewan</h5>
                    <div class="detail-field-wrapper">
                        <span class="detail-text">{{ $data->jenis_kelamin ?? 'data tidak ada' }}</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <h5 class="detail-label">Catatan medis hewan</h5>
                    <div class="detail-field-wrapper">
                        <span class="detail-text">{{ $data->catatan_medis ?? 'data tidak ada' }}</span>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <h5 class="detail-label">Berat hewan</h5>
                    <div class="detail-field-wrapper">
                        <span class="detail-text">{{ $data->berat ?? 'data tidak ada' }} kg</span>
                    </div>
                </div>
                
                <div class="col-md-12">
                    <h5 class="detail-label">Alasan penyerahan hewan</h5>
                    <div class="detail-field-wrapper">
                        <span class="detail-text">{{ $data->alasan_penyerahan ?? 'data tidak ada' }}</span>
                    </div>
                </div>
            </div>

            <div class="row text-center mt-4">
                <div class="col-md-12">
                    <a href="{{ url()->previous() }}"
                        class="btn btn-kembali">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
