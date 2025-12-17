@extends('layout.master')

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

@section('content')
    <div class="container py-5">
        <div class="text-center mb-4">
            <h2 class="fw-bold fs-3 mb-2">Data Penyerahan Hewan</h2>
        </div>

        <div class="card shadow-sm border-0 mx-auto" style="max-width: 900px;">
            <div class="card-body p-md-5">
                <div class="row-12 row-md-6 text-center mb-4">
                    <img src="{{ asset('storage/' . $data->foto_hewan) }}" class="hewan-image" alt="{{ $data->nama_hewan }}">
                </div>
                <div class="row mb-4">
                    <div class="col-6">
                        <label class="form-label fw-semibold">Nama hewan</label>
                        <div class="detail-field-wrapper">
                            <span class="detail-text">{{ $data->nama_hewan ?? 'data tidak ada' }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold">Ras hewan</label>
                        <div class="detail-field-wrapper">
                            <span class="detail-text">{{ $data->ras ?? 'data tidak ada' }}</span>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-6">
                        <label class="form-label fw-semibold">Jenis hewan</label>
                        <div class="detail-field-wrapper">
                            <span class="detail-text">{{ $data->jenis_hewan ?? 'data tidak ada' }}</span>
                        </div>
                    </div>

                    <div class="col-6">
                        <label class="form-label fw-semibold">Jenis kelamin hewan</label>
                        <div class="detail-field-wrapper">
                            <span class="detail-text">{{ $data->jenis_kelamin ?? 'data tidak ada' }}</span>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <label class="form-label fw-semibold">Berat hewan (Kg)</label>
                        <div class="detail-field-wrapper">
                            <span class="detail-text">{{ $data->berat ?? 'data tidak ada' }}</span>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12 col-md-6 mb-4 mb-md-0">
                        <label class="form-label fw-semibold">Apakah hewan sudah disteril</label>
                        <div class="detail-field-wrapper">
                            <span class="detail-text">{{ $data->status_steril ?? 'data tidak ada' }}</span>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Tanggal Sterilisasi</label>
                        <div class="detail-field-wrapper">
                            <span class="detail-text">
                                {{ $data->tanggal_steril ? \Carbon\Carbon::parse($data->tanggal_steril)->format('d F Y') : '-' }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12 col-md-6 mb-4 mb-md-0">
                        <label class="form-label fw-semibold">Apakah hewan sudah divaksin</label>
                        <div class="detail-field-wrapper">
                            <span class="detail-text">{{ $data->status_vaksin ?? 'data tidak ada' }}</span>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Tanggal Vaksinasi</label>
                        <div class="detail-field-wrapper">
                            <span class="detail-text">
                                {{ $data->tanggal_vaksin ? \Carbon\Carbon::parse($data->tanggal_vaksin)->format('d F Y') : '-' }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <label class="form-label fw-semibold">Catatan medis hewan</label>
                        <div class="detail-field-wrapper" style="padding: 0px">
                            <textarea class="form-control detail-text" style="padding: 10px 15px;" rows="3" disabled>{{ $data->catatan_medis ?? 'data tidak ada' }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <label class="form-label fw-semibold">Deskripsi hewan</label>
                        <div class="detail-field-wrapper" style="padding: 0px">
                            <textarea class="form-control detail-text" style="padding: 10px 15px;" rows="3" disabled>{{ $data->deskripsi_hewan ?? 'data tidak ada' }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <label class="form-label fw-semibold">Alasan penyerahan hewan</label>
                        <div class="detail-field-wrapper" style="padding: 0px">
                            <textarea class="form-control detail-text" style="padding: 10px 15px;" rows="3" disabled>{{ $data->alasan_penyerahan ?? 'data tidak ada' }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="row text-center mt-4">
                    <div class="col-md-12">
                        <a href="{{ url()->previous() }}" class="btn btn-primary-color w-100">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
