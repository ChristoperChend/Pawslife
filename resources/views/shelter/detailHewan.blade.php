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
    }

    .btn {
        border-radius: 8px;
        font-weight: 500;
        padding: 0.6rem 1.4rem;
    }

    .btn-kembali{
        background: var(--primary-color);
        color: #fff;
        border: 1px solid rgba(131, 131, 131, 0.223)!important;
        min-width: 100px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .btn-kembali:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(116, 116, 116, 0.25);
    }

    .btn-primary{
        background: var(--primary-color);
        color: #fff;
        border: none !important;
        border-width: 0 !important;
        min-width: 100px;
    }

    .btn-primary:hover{
        transform: translateY(-1px);
        filter: saturate(1.05);
        color: var(--primary-color);
        box-shadow:
            0 10px 22px rgba(96,165,250,.30);
    }

    .btn-hapus {
        background-color: #dc3545 !important;
        color: #fff !important;
        border: none !important;
        min-width: 100px;
        transition: 0.2s ease;
    }

    .btn-hapus:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(255, 0, 0, 0.25);
    }


    /* Responsive fix agar tombol tidak terlalu rapat di layar kecil */
    @media (max-width: 768px) {
        .button-group-right {
            justify-content: flex-start !important;
            margin-top: 0.75rem;
            gap: 0.5rem;
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

            {{-- Gambar Hewan --}}
            <div class="text-center mb-4">
                <img src="{{ asset($hewan->foto_hewan) }}" 
                     alt="{{ $hewan->nama_hewan }}"  
                     class="pet-photo mb-3">
                {{-- <div class="mb-3" style="max-width: 320px; margin: 0 auto;">
                    <label class="form-label fw-semibold">Ganti Foto Hewan</label>
                    <input type="file" name="foto_hewan" class="form-control">
                </div> --}}
            </div>

            {{-- Form --}}
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
                        <input type="text" name="jenis_hewan" class="form-control" 
                            value="{{ old('jenis_hewan', $hewan->jenis_hewan) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Jenis Kelamin Hewan <span class="text-danger">*</span></label>
                        <select name="jenis_kelamin" class="form-select" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="jantan" {{ $hewan->jenis_kelamin == 'jantan' ? 'selected' : '' }}>Jantan</option>
                            <option value="betina" {{ $hewan->jenis_kelamin == 'betina' ? 'selected' : '' }}>Betina</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Berat Hewan (kg) <span class="text-danger">*</span></label>
                        <input type="number" step="0.1" name="berat" class="form-control" 
                            value="{{ old('berat', $hewan->berat) }}" required min="0.1">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Ras Hewan <span class="text-danger">*</span></label>
                        <input type="text" name="ras" class="form-control" 
                            value="{{ old('ras', $hewan->ras) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Status Steril <span class="text-danger">*</span></label>
                        <select name="status_steril" class="form-select" required>
                            <option value="">Pilih Status</option>
                            <option value="sudahSteril" {{ $hewan->status_steril == 'sudahSteril' ? 'selected' : '' }}>Sudah Steril</option>
                            <option value="belumSteril" {{ $hewan->status_steril == 'belumSteril' ? 'selected' : '' }}>Belum Steril</option>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Status Vaksin <span class="text-danger">*</span></label>
                        <select name="status_vaksin" class="form-select" required>
                            <option value="">Pilih Status</option>
                            <option value="sudahVaksin" {{ $hewan->status_vaksin == 'sudahVaksin' ? 'selected' : '' }}>Sudah Vaksin</option>
                            <option value="belumVaksin" {{ $hewan->status_vaksin == 'belumVaksin' ? 'selected' : '' }}>Belum Vaksin</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Catatan Medis <span class="text-danger">*</span></label>
                        <textarea name="catatan_medis" class="form-control" rows="3" required>{{ old('catatan_medis', $hewan->catatan_medis) }}</textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Foto Hewan <span class="text-danger">*</span></label>
                        <input type="file" name="foto_hewan" class="form-control" 
                            accept=".jpg,.jpeg,.png" {{ $hewan->foto_hewan ? '' : 'required' }}>
                    </div>
                </div>

                <div class="row mt-4 align-items-center">
                    <div class="col-md-6 d-flex justify-content-start">
                        <a href="{{ route('shelter.data.hewan') }}" class="btn btn-kembali">Kembali</a>
                    </div>

                    <div class="col-md-6 d-flex justify-content-end gap-2 flex-wrap">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" id="btnDelete" class="btn btn-hapus">Hapus</button>
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
    });
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
        const form = document.querySelector('form[method="POST"][enctype="multipart/form-data"]');

        form.addEventListener('submit', function(e) {
            //Hentikan submit form otomatis
            e.preventDefault();

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Apakah Anda yakin ingin mengubah data hewan?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yakin',
                cancelButtonText: 'Kembali',
                reverseButtons: true,
                confirmButtonColor: '#0d6efd',
                cancelButtonColor: '#6c757d',
                customClass: {
                    popup: 'rounded-3 shadow-sm'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        const deleteBtn = document.getElementById('btnDelete');
        const deleteForm = document.getElementById('deleteForm');
        
        if (!deleteBtn || !deleteForm) return;

        deleteBtn.addEventListener('click', function (e) {
            console.log('Delete button clicked'); 
            e.preventDefault();

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Data hewan ini akan dihapus secara permanen.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                customClass: {
                    popup: 'rounded-3 shadow-sm'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteForm.submit();
                }
            });
        });
    });
</script>
@endsection

