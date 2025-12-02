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

    .form-control, .form-select {
        border-radius: 8px;
        border-left: 5px solid var(--primary-color) !important;
    }


    @media (max-width: 768px) {
        .button-group-left,
        .button-group-right {
            width: 100%;
        }

        .button-group-left {
            justify-content: flex-start !important;
            margin-bottom: 0.75rem;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .button-group-right {
            justify-content: flex-start !important;
            margin-top: 0.75rem;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .button-group-left .btn,
        .button-group-right .btn {
            flex: 1 0 100%;
            text-align: center;
        }

        .button-group-left .btn + .btn,
        .button-group-right .btn + .btn {
            margin-top: 0.4rem;
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
            <form action="{{ route('shelter.perbarui.data.shelter', $data->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

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

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Bank <span class="text-danger">*</span></label>
                        <select name="nama_bank" class="form-select" required>
                            <option value="" disabled {{ old('nama_bank', $data->nama_bank) ? '' : 'selected' }}>Pilih Bank</option>
                            
                            @php
                                $bankPopuler = ['BCA', 'Bank Mandiri', 'BRI', 'BNI', 'BSI (Syariah)', 'CIMB Niaga'];

                                $bankLainnya = [
                                    'Allo Bank', 'Bank Aceh Syariah', 'Bank Aladin Syariah', 'Bank Artha Graha', 
                                    'Bank BJB', 'Bank BJB Syariah', 'Bank BTPN / Jenius', 'Bank Banten', 
                                    'Bank Bengkulu', 'Bank Bohai', 'Bank Bukopin', 'Bank Bumi Arta', 
                                    'Bank Capital', 'Bank Chinatrust', 'Bank DBS Indonesia', 'Bank Danamon', 
                                    'Bank DKI', 'Bank Ganesha', 'Bank HSBC Indonesia', 'Bank ICBC Indonesia', 
                                    'Bank Ina Perdana', 'Bank Index Selindo', 'Bank Jago', 'Bank Jasa Jakarta', 
                                    'Bank Jateng', 'Bank Jatim', 'Bank Jambi', 'Bank Kalbar', 'Bank Kalsel', 
                                    'Bank Kalteng', 'Bank Kaltimtara', 'Bank Keb Hana', 'Bank Lampung', 
                                    'Bank Maluku Malut', 'Bank Maspion', 'Bank Mayapada', 'Bank Maybank Indonesia', 
                                    'Bank Mayora', 'Bank Mega', 'Bank Mega Syariah', 'Bank Mestika', 
                                    'Bank Muamalat', 'Bank Multiarta Sentosa', 'Bank NTB Syariah', 'Bank NTT', 
                                    'Bank Nagari', 'Bank Nationalnobu', 'Bank Neo Commerce', 'Bank OCBC NISP', 
                                    'Bank Of India Indonesia', 'Bank Papua', 'Bank Panin', 'Bank Panin Dubai Syariah', 
                                    'Bank Permata', 'Bank QNB Indonesia', 'Bank Resona Perdania', 
                                    'Bank Riau Kepri', 'Bank SBI Indonesia', 'Bank Shinhan Indonesia', 
                                    'Bank Sinarmas', 'Bank Sulselbar', 'Bank Sulteng', 'Bank Sultra', 
                                    'Bank Sumsel Babel', 'Bank Sumut', 'Bank UOB Indonesia', 'Bank Victoria', 
                                    'Bank Victoria Syariah', 'Bank Woori Saudara', 'Bank Yudha Bhakti', 
                                    'Citibank', 'Digibank', 'JTrust Bank', 'SeaBank', 'Standard Chartered'
                                ];
                                
                                sort($bankLainnya);
                                
                                $semuaBank = array_merge($bankPopuler, $bankLainnya);
                            @endphp

                            @foreach($semuaBank as $bank)
                                <option value="{{ $bank }}" {{ old('nama_bank', $data->nama_bank) == $bank ? 'selected' : '' }}>
                                    {{ $bank }}
                                </option>
                            @endforeach

                            {{-- Opsi Lainnya --}}
                            <option value="Lainnya" {{ old('nama_bank', $data->nama_bank) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nomor Rekening <span class="text-danger">*</span></label>
                        <input type="text" name="nomor_rekening" class="form-control" 
                            placeholder="Masukkan nomor rekening bank anda..."
                            value="{{ old('nomor_rekening', $data->nomor_rekening) }}" required>
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
                                $docRelPath = $data->dokumen_legal ?? null;
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
                    <div class="col-md-6 d-flex justify-content-start gap-3 flex-wrap button-group-left">
                        <a href="{{ route('beranda.shelterBeranda') }}" class="btn btn-kembali">Kembali</a>
                        <button type="button" id="btnLogout" class="btn btn-merah-color">
                            Logout
                        </button>
                    </div>

                    <div class="col-md-6 d-flex justify-content-end gap-2 flex-wrap button-group-right">
                        <button type="submit" class="btn btn-primary-color">Simpan</button>
                        
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
        customClass: {
                actions: 'swal-actions-gap',
                icon: 'swal-success-primary',
                confirmButton: 'btn btn-primary-color',
            },
        buttonsStyling: false,
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
            e.preventDefault();

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Apakah Anda yakin ingin mengubah data shelter?',
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
                logoutForm.submit();
                }
            });
            });
        }
    });

</script>
@endsection

