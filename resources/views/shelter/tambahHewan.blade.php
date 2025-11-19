@extends('layout.master')

<style>
    :root{
        --card-bg: #ffffff;
        --page-bg: #f5f6fb;
        --muted: #6b7280;
    }

    body { background: var(--page-bg); }

    .page-header {
        max-width: 960px;
        margin: 24px auto 0;
        text-align: center;
    }
    .page-header h2{
        font-weight: 800;
        letter-spacing: .3px;
    }
    .page-subtitle{
        color: var(--muted);
        font-size: .95rem;
    }

    
    .card-accent{
        height: 6px;
        background: var(--primary-color);
    }

    .form-control{
        border-left: 5px solid var(--primary-color) !important;
    }

    .form-control, .form-select {
        border-left: 5px solid var(--primary-color) !important;
    }

    .form-card{
        max-width: 960px;
        margin: 24px auto 48px;
        background: var(--card-bg);
        border-radius: 16px;
        border: 1px solid #eef0f4;
        box-shadow:
            0 12px 24px rgba(16, 24, 40, 0.04),
            0 2px 6px rgba(16, 24, 40, 0.04);
        overflow: hidden;
    }

    .form-shell{
        padding: 28px 28px 20px;
    }

    .section-title{
        font-weight: 700;
        font-size: 1rem;
        margin: 8px 0 16px;
        color: #111827;
    }
    .section-divider{
        height: 1px;
        background: #eef0f4;
        margin: 8px 0 20px;
    }

    .label-row{
        display:flex; align-items:center; gap:.5rem;
    }
    
    .req{
        font-size:.7rem;
        padding:.15rem .0rem;
        color:#b91c1c;
        font-weight:700;
    }

    .hint{
        color: var(--muted);
        font-size: .70rem;
        margin-top: 4px;
    }

    .invalid-feedback, .text-danger.fs-7{ font-size: .8rem; }

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

    .form-footer{
        padding: 0 28px 28px;
        display:flex; justify-content:flex-end; gap:12px;
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

    .form-footer .btn.btn-light{
        border-radius: 10px;
        padding: .7rem 1.1rem;
        font-weight: 600;
        min-width: 100px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        color: #111827;
        transition: transform .12s ease, box-shadow .18s ease, filter .12s ease, background .18s ease, color .18s ease, border-color .18s ease;
    }

    .form-footer .btn.btn-light:hover{
        transform: translateY(-1px);
        color: #0f172a;
        border-color: transparent;
        box-shadow:
            0 10px 22px rgba(100,116,139,.18),
            0 3px 10px rgba(148,163,184,.16);
    }
</style>

@section('content')
<div class="container">
    <div class="page-header">
        <h2>Form Penambahan Hewan</h2>
        <p class="page-subtitle">Lengkapi data hewan di bawah ini. Kolom bertanda <strong>*</strong> Wajib diisi.</p>
    </div>

    <div class="form-card">
        <div class="card-accent"></div>

        <form class="form-shell" action="{{ route('shelter.tambahHewanPost') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="section-title">Informasi Dasar</div>
            <div class="section-divider"></div>

            <div class="row g-4">
                <div class="col-md-6">
                    <label for="namaHewan" class="form-label label-row">
                        Nama Hewan <span class="req"> *</span>
                    </label>
                    <input type="text" class="form-control" id="namaHewan" name="namaHewan"
                           placeholder="Masukkan nama hewan" value="{{ old('namaHewan') }}">
                    @error('namaHewan') <small class="text-danger fs-7">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-6">
                    <label for="statusSterilHewan" class="form-label label-row">
                        Status Steril Hewan <span class="req"> *</span>
                    </label>
                    <select class="form-select" name="statusSterilHewan" id="statusSterilHewan">
                        <option value="" disabled selected hidden>Pilih status steril</option>
                        <option value="sudah_steril" {{old('statusSterilHewan') === 'sudah_steril' ? 'selected' : ''}}>Sudah Steril</option>
                        <option value="belum_steril" {{old('statusSterilHewan') === 'belum_steril' ? 'selected' : ''}}>Belum Steril</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="jenisHewan" class="form-label label-row">
                        Jenis Hewan <span class="req"> *</span>
                    </label>
                    <select class="form-select" name="jenisHewan" id="jenisHewan">
                        <option value="" disabled selected hidden>Pilih jenis hewan</option>
                        <option value="anjing" {{old('jenisHewan') === 'anjing' ? 'selected' : ''}}>Anjing</option>
                        <option value="kucing" {{old('jenisHewan') === 'kucing' ? 'selected' : ''}}>Kucing</option>
                    </select>
                    @error('jenisHewan') <small class="text-danger fs-7">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-6">
                    <label for="beratHewan" class="form-label label-row">
                        Berat Hewan <span class="req"> *</span>
                    </label>
                    <input type="text" class="form-control" id="beratHewan" name="beratHewan" placeholder="Masukkan berat hewan">
         
                    @error('beratHewan') <small class="text-danger fs-7">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-6">
                    <label for="jenisKelaminHewan" class="form-label label-row">
                        Jenis Kelamin Hewan <span class="req"> *</span>
                    </label>
                    <select class="form-select" name="jenisKelaminHewan" id="jenisKelaminHewan">
                        <option value="" disabled selected hidden>Pilih jenis kelamin</option>
                        <option value="jantan" {{old('jenisKelaminHewan') === 'jantan' ? 'selected' : ''}}>Jantan</option>
                        <option value="betina" {{old('jenisKelaminHewan') === 'betina' ? 'selected' : ''}}>Betina</option>
                    </select>
                    @error('jenisKelaminHewan') <small class="text-danger fs-7">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-6">
                    <label for="rasHewan" class="form-label label-row">
                        Ras Hewan <span class="req"> *</span>
                    </label>
                    <input type="text" class="form-control" id="rasHewan" name="rasHewan" placeholder="Masukkan ras hewan">
                </div>

                <div class="col-md-6">
                    <label for="statusVaksinHewan" class="form-label label-row">
                        Status Vaksin Hewan <span class="req"> *</span>
                    </label>
                    <select class="form-select" name="statusVaksinHewan" id="statusVaksinHewan">
                        <option value="" disabled selected hidden>Pilih status vaksin</option>
                        <option value="sudah_vaksin" {{old('statusVaksinHewan') === 'sudah_vaksin' ? 'selected' : ''}}>Sudah divaksin</option>
                        <option value="belum_vaksin" {{old('statusVaksinHewan') === 'belum_vaksin' ? 'selected' : ''}}>Belum divaksin</option>
                    </select>
                    @error('statusVaksinHewan') <small class="text-danger fs-7">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-6">
                    <label for="catatanMedisHewan" class="form-label">Catatan Medis <span class="text-muted">(opsional)</span></label>
                    <input type="text" class="form-control" id="catatanMedisHewan" name="catatanMedisHewan"
                           placeholder="Alergi, riwayat sakit, dll.">
                </div>
            </div>

            <div class="section-title mt-4">Foto</div>
            <div class="section-divider"></div>

            <div class="row g-3">
                <div class="col-12">
                    <label for="fotoHewan" class="form-label label-row">
                        Foto Hewan <span class="req"> *</span>
                    </label>
                    <div class="preview-wrap">
                        <div class="preview-box" id="preview">
                            Pratinjau
                        </div>
                        <div style="flex:1; min-width:220px">
                            <input type="file" class="form-control" id="fotoHewan" name="fotoHewan" accept="image/*">
                            <div class="hint">Format JPG/PNG, maks 3MB.</div>
                            @error('fotoHewan') <small class="text-danger fs-7">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('beranda.shelterBeranda') }}" class="btn btn-kembali">Kembali</a>
                <button type="submit" class="btn btn-primary-color" style="color: white">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

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
    // Animal photo preview
    const fileInput = document.getElementById('fotoHewan');
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
</script>
@endsection
