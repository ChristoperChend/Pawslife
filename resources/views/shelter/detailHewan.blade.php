@extends('layout.master')

<style>
    .page-header h2 {
        font-weight: 700;
        font-size: 1.9rem;
        margin-bottom: .5rem;
    }

    .pet-photo {
        width: 100%;
        max-width: 400px;
        height: 400px;
        object-fit: cover;
        border-radius: 12px;
        border: 1px solid #e5e5e5;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .card {
        border-radius: 12px;
    }

    .form-control, .form-select {
        border-radius: 8px;
        border-left: 5px solid var(--primary-color) !important;
    }

    .btn {
        border-radius: 8px;
        font-weight: 500;
        padding: 0.6rem 1.4rem;
    }

    .btn-primary-color{
        background: var(--primary-color);
        color: #fff;
        border: none !important;
        min-width: 100px;
    }

    .date-input-wrapper {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), opacity 0.3s ease;
        opacity: 0;
    }

    .date-input-wrapper.show {
        max-height: 100px;
        opacity: 1;
        margin-top: 0.5rem;
    }

    @media (max-width: 768px) {
        .button-group-left,
        .button-group-right {
            width: 100%;
        }
        .button-group-left {
            justify-content: flex-start !important;
            margin-bottom: 0.75rem;
        }
        .button-group-left .btn-kembali {
            flex: 1 0 100%;
            display: block;
            text-align: center;
        }
        .button-group-right {
            justify-content: flex-start !important;
            gap: 0.5rem;
            flex-wrap: wrap;
        }
        .button-group-right .btn {
            flex: 1 0 100%;
        }
        .button-group-right .btn + .btn {
            margin-top: 0.4rem;
        }
    }
</style>

@section('content')
<div class="container py-4">
    <div class="page-header text-center" style="max-width: 860px; margin: 2rem auto;">
        <h2>Detail Hewan</h2>
    </div>

    <div class="card shadow-sm border-0 mx-auto" style="max-width: 900px;">
        <div class="card-body p-5">

            <div class="text-center mb-4">
                <img src="{{ asset('storage/'.$hewan->foto_hewan) }}" 
                     alt="{{ $hewan->nama_hewan }}"  
                     class="pet-photo mb-3">
            </div>

            <form action="{{ route('shelter.perbarui.data.hewan', $hewan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="old_foto_hewan" value="{{ $hewan->foto_hewan }}">
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Hewan <span class="text-danger">*</span></label>
                        <input type="text" name="nama_hewan" class="form-control" 
                            value="{{ old('nama_hewan', $hewan->nama_hewan) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Jenis Hewan <span class="text-danger">*</span></label>
                        <select name="jenis_hewan" class="form-select" required>
                            <option value="" disabled muted>Pilih Jenis Hewan</option>
                            <option value="anjing" {{ $hewan->jenis_hewan == 'anjing' ? 'selected' : '' }}>Anjing</option>
                            <option value="kucing" {{ $hewan->jenis_hewan == 'kucing' ? 'selected' : '' }}>Kucing</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Jenis Kelamin Hewan<span class="text-danger">*</span></label>
                        <select name="jenis_kelamin" class="form-select" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="jantan" {{ $hewan->jenis_kelamin == 'jantan' ? 'selected' : '' }}>Jantan</option>
                            <option value="betina" {{ $hewan->jenis_kelamin == 'betina' ? 'selected' : '' }}>Betina</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Berat Hewan (Kg) <span class="text-danger">*</span></label>
                        <input type="number" step="0.1" name="berat" class="form-control" 
                            value="{{ old('berat', $hewan->berat) }}" required min="0.1">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Status Vaksin <span class="text-danger">*</span></label>
                        <select name="status_vaksin" id="status_vaksin" class="form-select" required>
                            <option value="" disabled muted>Pilih Status</option>
                            <option value="sudah_vaksin" {{ $hewan->status_vaksin == 'sudah_vaksin' ? 'selected' : '' }}>Sudah Vaksin</option>
                            <option value="belum_vaksin" {{ $hewan->status_vaksin == 'belum_vaksin' ? 'selected' : '' }}>Belum Vaksin</option>
                        </select>

                        <div id="wrapper_tanggal_vaksin" class="date-input-wrapper">
                            <label class="form-label fw-semibold mt-2 small text-muted">Tanggal Vaksinasi</label>
                            <input type="date" name="tanggal_vaksin" class="form-control" 
                                   value="{{ old('tanggal_vaksin', $hewan->tanggal_vaksin) }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Status Steril <span class="text-danger">*</span></label>
                        <select name="status_steril" id="status_steril" class="form-select" required>
                            <option value="" disabled muted>Pilih Status</option>
                            <option value="sudah_steril" {{ $hewan->status_steril == 'sudah_steril' ? 'selected' : '' }}>Sudah Steril</option>
                            <option value="belum_steril" {{ $hewan->status_steril == 'belum_steril' ? 'selected' : '' }}>Belum Steril</option>
                        </select>

                        <div id="wrapper_tanggal_steril" class="date-input-wrapper">
                            <label class="form-label fw-semibold mt-2 small text-muted">Tanggal Sterilisasi</label>
                            <input type="date" name="tanggal_steril" class="form-control"
                                   value="{{ old('tanggal_steril', $hewan->tanggal_steril) }}">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Ras Hewan <span class="text-danger">*</span></label>
                        <input type="text" name="ras" class="form-control" 
                            value="{{ old('ras', $hewan->ras) }}" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Catatan Medis <span class="text-danger">*</span></label>
                        <textarea name="catatan_medis" class="form-control" rows="3" required>{{ old('catatan_medis', $hewan->catatan_medis) }}</textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Deskripsi Hewan <span class="text-danger">*</span></label>
                        <textarea name="deskripsi_hewan" class="form-control" rows="3" required>{{ old('deskripsi_hewan', $hewan->deskripsi_hewan) }}</textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Foto Hewan <span class="text-danger">*</span></label>
                        <input type="file" name="foto_hewan" class="form-control" 
                            accept=".jpg,.jpeg,.png" {{ $hewan->foto_hewan ? '' : 'required' }}>
                    </div>
                </div>

                <div class="row mt-4 align-items-center">
                    <div class="col-md-6 d-flex justify-content-start">
                        <a href="{{ route('shelter.data.hewan') }}" class="btn btn-kembali button-group-left" >Kembali</a>
                    </div>

                    <div class="col-md-6 d-flex justify-content-end gap-2 flex-wrap button-group-right">
                        <button type="submit" class="btn btn-primary-color">Simpan</button>
                        <button type="button" id="btnDelete" class="btn btn-merah-color">Hapus</button>
                    </div>
                </div>
            </form>

            <form action="{{ route('shelter.hapus.data.hewan', $hewan->id) }}" 
                method="POST" 
                id="deleteForm" 
                class="d-none">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
</div>


@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', () => {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: @json(session('success')),
            customClass: {
                actions: 'swal-actions-gap',
                icon: 'swal-success-primary',
                confirmButton: 'btn btn-primary-color',
            },
            buttonsStyling: false
        })
    });
</script>
@endif

@if (session('error'))
<script>
  document.addEventListener('DOMContentLoaded', () => {
    Swal.fire({
      icon: 'error',
      title: 'Gagal',
      text: @json(session('error')),
    });
  });
</script>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function(){
        // Date Toggle Logic
        const vaksinSelect = document.getElementById('status_vaksin');
        const vaksinWrapper = document.getElementById('wrapper_tanggal_vaksin');
        const sterilSelect = document.getElementById('status_steril');
        const sterilWrapper = document.getElementById('wrapper_tanggal_steril');

        function toggleDateInput(selectElement, wrapperElement, triggerValue) {
            if(selectElement.value === triggerValue) {
                wrapperElement.classList.add('show');
                wrapperElement.querySelector('input').required = true;
            } else {
                wrapperElement.classList.remove('show');
                const input = wrapperElement.querySelector('input');
                input.required = false;
            }
        }

        toggleDateInput(vaksinSelect, vaksinWrapper, 'sudah_vaksin');
        toggleDateInput(sterilSelect, sterilWrapper, 'sudah_steril');

        vaksinSelect.addEventListener('change', function() {
            toggleDateInput(this, vaksinWrapper, 'sudah_vaksin');
        });

        sterilSelect.addEventListener('change', function() {
            toggleDateInput(this, sterilWrapper, 'sudah_steril');
        });


        // Form Submit Logic
        const form = document.querySelector('form[method="POST"][enctype="multipart/form-data"]');

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Apakah Anda yakin ingin mengubah data hewan?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yakin',
                cancelButtonText: 'Kembali',
                reverseButtons: true,
                buttonsStyling: false, 
                customClass: {
                    popup: 'rounded-3 shadow-sm',
                    icon: 'swal-question-primary',
                    actions: 'd-flex gap-3 justify-content-center',
                    confirmButton: 'btn btn-primary-color me-4',
                    cancelButton: 'btn btn-kembali'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        // Delete Logic
        const deleteBtn = document.getElementById('btnDelete');
        const deleteForm = document.getElementById('deleteForm');
        
        if (deleteBtn && deleteForm) {
            deleteBtn.addEventListener('click', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Data hewan ini akan dihapus secara permanen.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    buttonsStyling: false, 
                    customClass: {
                        popup: 'rounded-3 shadow-sm',
                        icon: 'swal-warning-primary',
                        actions: 'd-flex gap-3 justify-content-center',
                        confirmButton: 'btn btn-merah-color me-4',
                        cancelButton: 'btn btn-kembali'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteForm.submit();
                    }
                });
            });
        }
    });
</script>
@endsection