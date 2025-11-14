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

    .btn-logout{
        background-color:#dc3545!important;
        color:#fff!important;
        border:none!important;
        min-width:100px;
        border-radius:8px;
        padding:0.6rem 1.4rem;
        font-weight:500;
        transition:.2s ease;
    }

    .btn-logout:hover{
        transform: translateY(-1px);
        box-shadow:0 6px 18px rgba(255,0,0,.25);
    }

    .preview-wrap{
        display:flex; gap:16px; align-items:center; flex-wrap:wrap;
    }

    .preview-box{
        width: 120px; height: 120px;
        border: 1px dashed #d1d5db;
        border-radius: 12px;
        display:flex; align-items:center; justify-content:center;
        color:#9ca3af; font-size:.9rem; background:#fafafa;
        overflow:hidden;
    }
    
    .preview-box img{ width:100%; height:100%; object-fit:cover; }


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
        <h2>Profil Shelter</h2>
    </div>

    <div class="card shadow-sm border-0 mx-auto" style="max-width: 900px;">
        <div class="card-body p-5">

            

            {{-- Form --}}
            <form action="{{ route('shelter.perbarui.data.shelter', $data->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Gambar Hewan --}}
                <div class="text-center mb-4">
                    <img src="{{ asset('storage/' . $data->foto_shelter) }}" 
                        alt="{{ $data->nama_shelter }}"  
                        class="pet-photo mb-3">
                    <div class="mb-3" style="max-width: 320px; margin: 0 auto;">
                        <label class="form-label fw-semibold">Ganti Foto Shelter</label>
                        <input type="file" name="foto_shelter" class="form-control">
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Nama Shelter <span class="text-danger">*</span></label>
                        <input type="text" name="nama_shelter" class="form-control" 
                            value="{{ old('nama_shelter', $data->nama_shelter) }}" required>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Alamat Shelter <span class="text-danger">*</span></label>
                        <input type="text" name="alamat_shelter" class="form-control" 
                            value="{{ old('alamat_shelter', $data->alamat_shelter) }}" required>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Nomor Telepon Shelter <span class="text-danger">*</span></label>
                        <input type="text" name="no_telepon_shelter" class="form-control" 
                            value="{{ old('no_telepon_shelter', $data->no_telepon_shelter) }}" required>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Deskripsi Shelter <span class="text-danger">*</span></label>
                        <textarea name="deskripsi_shelter" class="form-control" rows="4" placeholder="Masukkan deskripsi shelter anda..." required>{{ old('deskripsi_shelter', $data->deskripsi_shelter) }}</textarea>
                    </div>

                    <div class="col-md-12">
                        <label for="fotoHewan" class="form-label fw-semibold">
                            Dokumen Legal <span class="text-danger">*</span>
                        </label>
                        <div class="preview-wrap">
                            @php
                                use Illuminate\Support\Str;
                                $docRelPath = $data->dokumen_legal ?? null; // e.g. 'uploads/legal/abc.pdf'
                                $docUrl = $docRelPath ? asset('storage/'.$docRelPath) : null;
                            @endphp

                            <div class="preview-box" id="preview">
                                @if ($docUrl)
                                    @if (Str::endsWith(Str::lower($docRelPath), ['.jpg', '.jpeg', '.png', '.gif', '.webp']))
                                        <img src="{{ $docUrl }}" alt="Dokumen Legal">
                                    @elseif (Str::endsWith(Str::lower($docRelPath), ['.pdf']))
                                        <a href="{{ $docUrl }}" target="_blank" class="d-flex flex-column align-items-center justify-content-center text-decoration-none w-100 h-100">
                                            <i class="bi bi-file-earmark-pdf" style="font-size:32px;"></i>
                                            <small class="text-muted text-center px-2">Lihat PDF</small>
                                        </a>
                                    @else
                                        <a href="{{ $docUrl }}" target="_blank" class="d-flex flex-column align-items-center justify-content-center text-decoration-none w-100 h-100">
                                            <i class="bi bi-file-earmark" style="font-size:32px;"></i>
                                            <small class="text-muted text-center px-2">Lihat Dokumen</small>
                                        </a>
                                    @endif
                                @else
                                    Pratinjau
                                @endif
                            </div>

                            <div style="flex:1; min-width:220px">
                                <input type="file" class="form-control" id="dokumen_legal" name="dokumen_legal" accept="image/*">
                                <div class="hint">Format JPG/PNG, maks 3MB.</div>
                                @error('dokumen_legal') <small class="text-danger fs-7">{{ $message }}</small> @enderror
                            </div>
                        </div>
                    </div>

                    
                </div>

                <div class="row mt-4 align-items-center">
                    <div class="col-md-6 d-flex justify-content-start gap-3 flex-wrap">
                        <a href="{{ route('beranda.shelterBeranda') }}" class="btn btn-kembali">Kembali</a>
                        <button type="button" id="btnLogout" class="btn btn-logout">
                            Logout
                        </button>
                    </div>

                    <div class="col-md-6 d-flex justify-content-end gap-2 flex-wrap">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        
                    </div>
                </div>
            </form>

            <form id="logoutForm" method="POST" action="{{ route('logout') }}" class="d-none">
                @csrf
            </form> 

            <form action="{{ route('shelter.hapus.data.hewan', $data->id) }}" 
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
                text: 'Apakah Anda yakin ingin mengubah data shelter?',
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


        // Animal photo preview
        const fileInput = document.getElementById('dokumen_legal');
        const preview = document.getElementById('preview');

        fileInput?.addEventListener('change', (e) => {
            const file = e.target.files?.[0];
            if (!file) { preview.innerHTML = 'Pratinjau'; return; }
            const reader = new FileReader();
            reader.onload = (ev) => {
                preview.innerHTML = '';
                const img = document.createElement('img');
                img.src = ev.target.result;
                img.alt = 'Foto hewan';
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        });

        //logout
        const btnLogout = document.getElementById('btnLogout');
        const logoutForm = document.getElementById('logoutForm');

        if (btnLogout && logoutForm) {
            btnLogout.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            Swal.fire({
                title: 'Apakah Anda yakin ingin logout?',
                text: 'Sesi Anda akan diakhiri.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Logout',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                customClass: { popup: 'rounded-3 shadow-sm' }
            }).then((result) => {
                if (result.isConfirmed) {
                logoutForm.submit();
                }
            });
            });
        }
    });

</script>
@endsection

