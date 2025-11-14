@extends('layout.master')

<style>
    .btn-kembali {
        background: var(--primary-color) !important;
        color: white !important;
        border: 1px solid rgba(131, 131, 131, 0.223) !important;
        min-width: 100px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        border-radius: 8px;
        font-weight: 500;
        padding: 0.6rem 1.4rem;
        transition: all 0.2s ease-in-out;
        text-decoration: none;
    }

    .btn-kembali:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(116, 116, 116, 0.25);
    }

    .readonly-field {
        background: #fff !important;
        border: 1px solid #d1d5db !important;
        border-radius: 6px;
        color: #111827;
        font-weight: 500;
        padding: 0.55rem 0.9rem;
        box-shadow: none !important;
    }
</style>

@section('content')
<div class="container py-4">
    <div class="text-center mb-4">
        <h2 class="fw-bold fs-3 mb-2">Data Penyerahan Hewan</h2>
    </div>

    <div class="card border-0 mx-auto" style="max-width: 860px; border-radius: 12px; box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);">
        <div class="card-body p-5">

            <div class="text-center mb-4">
                <img src="{{ asset('storage/' . $data->foto_hewan) }}" 
                     alt="{{ $data->nama_hewan }}"
                     class="img-fluid rounded shadow-sm"
                     style="width: 230px; height: 230px; object-fit: cover;">
            </div>

            <div class="row g-4">
                <div class="col-md-6">
                    <label class="fw-semibold">Nama Hewan</label>
                    <div class="form-control readonly-field">{{ $data->nama_hewan }}</div>
                </div>

                <div class="col-md-6">
                    <label class="fw-semibold">Ras</label>
                    <div class="form-control readonly-field">{{ $data->ras }}</div>
                </div>

                <div class="col-md-6">
                    <label class="fw-semibold">Status Vaksin</label>
                    <div class="form-control readonly-field">{{ $data->status_vaksin ?? '-' }}</div>
                </div>

                <div class="col-md-6">
                    <label class="fw-semibold">Status Steril</label>
                    <div class="form-control readonly-field">{{ $data->status_steril }}</div>
                </div>

                <div class="col-md-6">
                    <label class="fw-semibold">Jenis Hewan</label>
                    <div class="form-control readonly-field">{{ $data->jenis_hewan }}</div>
                </div>

                <div class="col-md-6">
                    <label class="fw-semibold">Jenis Kelamin</label>
                    <div class="form-control readonly-field">{{ $data->jenis_kelamin }}</div>
                </div>

                <div class="col-md-6">
                    <label class="fw-semibold">Catatan Medis</label>
                    <div class="form-control readonly-field">{{ $data->catatan_medis ?? '-' }}</div>
                </div>
                
                <div class="col-md-6">
                    <label class="fw-semibold">Berat</label>
                    <div class="form-control readonly-field">{{ $data->berat }}</div>
                </div>
                
                <div class="col-md-12">
                    <label class="fw-semibold">Alasan Penyerahan</label>
                    <div class="form-control readonly-field">{{ $data->alasan_penyerahan ?? '-' }}</div>
                </div>
            </div>

            <div class="row text-center mt-4">
                <div class="col-md-12">
                    <a href="{{ url()->previous() }}"
                       class="btn btn-kembali w-100">
                       Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
