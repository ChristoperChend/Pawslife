@extends('layout.master')

<style>

    .hewan-image {
        width: 100%;
        max-width: 400px;
        height: 400px;
        object-fit: cover;
        border-radius: 12px;
        border: 1px solid #e5e5e5;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
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
    .form-control{
        border-left: 5px solid var(--primary-color) !important;
    }
</style>

@section('content')
<div class="container py-4">
    <div class="text-center mb-4">
        <h2 class="fw-bold fs-3 mb-2">Profil Adopter</h2>
    </div>

    <div class="card border-0 mx-auto" style="max-width: 860px; border-radius: 12px; box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);">
        <div class="card-body p-5">

            <div class="row-12 row-md-6 text-center mb-4">
                    <img src="{{ asset('storage/' . $data->foto_adopter) }}" class="hewan-image" alt="{{ $data->nama_lengkap }}">
                </div>

            <div class="row g-4">
                <div class="col-md-6">
                    <label class="fw-semibold">Nama Lengkap</label>
                    <div class="form-control readonly-field">{{ $data->nama_lengkap }}</div>
                </div>

                <div class="col-md-6">
                    <label class="fw-semibold">Email</label>
                    <div class="form-control readonly-field">{{ $data->pengguna->email ?? '-' }}</div>
                </div>

                <div class="col-md-6">
                    <label class="fw-semibold">Usia (Tahun)</label>
                    <div class="form-control readonly-field">{{ $data->usia }} tahun</div>
                </div>

                <div class="col-md-6">
                    <label class="fw-semibold">Pekerjaan</label>
                    <div class="form-control readonly-field">{{ $data->pekerjaan }}</div>
                </div>

                <div class="col-md-6">
                    <label class="fw-semibold">No. Handphone</label>
                    <div class="form-control readonly-field">{{ $data->no_handphone }}</div>
                </div>

                <div class="col-md-6">
                    <label class="fw-semibold">No. WhatsApp</label>
                    <div class="form-control readonly-field">{{ $data->no_whatsapp }}</div>
                </div>

                <div class="col-md-12">
                    <label class="fw-semibold">Alamat</label>
                    <div class="form-control readonly-field">{{ $data->alamat }}</div>
                </div>

                
            </div>

            <div class="row text-center mt-4">
                <div class="col-md-12">
                    <a href="{{ url()->previous() }}"
                       class="btn btn-primary-color w-100">
                       Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
