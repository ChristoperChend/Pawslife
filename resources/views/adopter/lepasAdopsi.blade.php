<style>
    .text-atas li {
        margin-left: 2rem;
        margin-top: 0;

    }

    .text-atas p {
        margin-bottom: 0;
        text-align: justify;
    }

    .hint {
        color: var(--muted);
        font-size: .70rem;
        margin-top: 4px;
    }

    .page-header {
        max-width: 1060px;
        margin: 24px auto 0;
    }
    .page-header h2 {
        font-weight: 800;
        letter-spacing: .3px;
    }

    .form-shell {
        padding: 28px 28px 20px;
    }

    .form-card {
        max-width: 1060px;
        margin: 24px auto 48px;
        background: var(--card-bg);
        border-radius: 16px;
        border: 1px solid #eef0f4;
        box-shadow:
            0 12px 24px rgba(16, 24, 40, 0.04),
            0 2px 6px rgba(16, 24, 40, 0.04);
        overflow: hidden;
    }

    .card-accent {
        height: 6px;
        background: var(--primary-color);
    }

    .section-title {
        font-weight: 700;
        font-size: 1rem;
        margin: 8px 0 16px;
        color: #111827;
    }
    .section-divider {
        height: 1px;
        background: #c8cace;
        margin: 8px 0 0px;
    }

    .preview-box {
        width: 120px; height: 120px;
        border: 1px dashed #d1d5db;
        border-radius: 12px;
        display:flex; align-items:center; justify-content:center;
        color:#9ca3af; font-size:.9rem; background:#fafafa;
        overflow:hidden;
    }

    .preview-wrap {
        display:flex;
        gap:16px;
        align-items:center;
        flex-wrap:wrap;
    }
    
    .preview-box img {
        width:100%;
        height:100%;
        object-fit:cover;
    }

    @media (max-width: 576px) {
    .preview-wrap {
        justify-content: center;
    }
    
    .preview-box {
        margin: 0 auto; 
    }
    
    .preview-wrap > div:last-child {
        min-width: 90% !important;
    }
}
</style>

@extends('layout.master')

@section('content')
    <div class="container py-5">
        <div class="text-atas page-header">
            <h1 class="fw-bold text-center">Ajukan Penyerahan Hewan Peliharaan</h1>
            <hr>

            <h5>Pertimbangan Awal</h5>
            <p class="mb-4">Untuk hewan peliharaan pribadi, pertimbangkan opsi lain terlebih dahulu, seperti mencarikan pemilik baru yang terpercaya dan mampu merawat hewan anda dengan baik.</p>
            
            <h5>Perlengkapan Yang Disarankan</h5>
            <p>Untuk membantu hewan beradaptasi di lingkungan baru, mohon sediakan barang-barang pribadinya jika ada seperti</p>
            <li>Tempat tidur</li>
            <li>Mainan kesayangan</li>
            <li>Makanan favorit atau peralatan makan</li>

            <hr>
        </div>

        <div class="form-card">
            <div class="card-accent"></div>

            <form class="form-shell bg-white" action="{{ route(name: 'adopter.lepasAdopsi') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="section-title">Informasi Dasar</div>
                <div class="section-divider"></div>

                <div class="row g-4">
                    <div class="col-md-6 ">
                        <label for="namaHewan" class="form-label fw-semibold">Nama Hewan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="namaHewan" name="namaHewan" placeholder="Masukkan nama hewan" value="{{ old('namaHewan') }}">
                        @error('namaHewan') <small class="text-danger fs-7">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6 ">
                        <label for="jenisHewan" class="form-label fw-semibold">Jenis Hewan <span class="text-danger">*</span></label>
                        <select class="form-select" name="jenisHewan" id="jenisHewan">
                            <option value="" disabled selected hidden>Pilih Jenis Hewan</option>
                            <option value="anjing" {{old('jenisHewan') === 'anjing' ? 'selected' : ''}}>Anjing</option>
                            <option value="kucing" {{old('jenisHewan') === 'kucing' ? 'selected' : ''}}>Kucing</option>
                        </select>
                        @error('jenisHewan') <small class="text-danger fs-7">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-md-6 ">
                        <label for="jeniskelaminHewan" class="form-label fw-semibold">Jenis Kelamin Hewan <span class="text-danger">*</span></label>
                        <select class="form-select" name="jenisKelaminHewan" id="jenisKelaminHewan">
                            <option value="" disabled selected hidden>Masukkan Jenis Kelamin Hewan</option>
                            <option value="jantan"  {{old('jenisKelaminHewan') === 'jantan' ? 'selected' : ''}}>Jantan</option>
                            <option value="betina"  {{old('jenisKelaminHewan') === 'betina' ? 'selected' : ''}}>Betina</option>
                        </select>
                        @error('jeniskelaminHewan') <small class="text-danger fs-7">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6 ">
                        <label for="statusVaksinHewan" class="form-label fw-semibold">Status Vaksin Hewan <span class="text-danger">*</span></label>
                        <select class="form-select" name="statusVaksinHewan" id="statusVaksinHewan">
                            <option value="" disabled selected hidden>Masukkan Status Vaksin Hewan</option>
                            <option value="sudahVaksin"  {{old('statusVaksinHewan') === 'sudahVaksin' ? 'selected' : ''}}>Sudah Vaksin</option>
                            <option value="belumVaksin"{{old('statusVaksinHewan') === 'belumVaksin' ? 'selected' : ''}}>Belum Vaksin</option>
                        </select>
                        @error('statusVaksinHewan') <small class="text-danger fs-7">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-md-6 ">
                        <label for="statusSterilHewan" class="form-label fw-semibold">Status Steril Hewan <span class="text-danger">*</span></label>
                        <select class="form-select" name="statusSterilHewan" id="statusSterilHewan">
                            <option value="" disabled selected hidden>Masukkan Status Vaksin Hewan</option>
                            <option value="sudahSteril" {{old('statusSterilHewan') === 'sudahSteril' ? 'selected' : ''}}>Sudah Steril</option>
                            <option value="belumSteril" {{old('statusSterilHewan') === 'belumSteril' ? 'selected' : ''}}>Belum Steril</option>
                        </select>
                        @error('statusSterilHewan') <small class="text-danger fs-7">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6 ">
                        <label for="beratHewan" class="form-label fw-semibold">Berat Hewan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="beratHewan" name="beratHewan" placeholder="Masukkan Berat Hewan">
                        @error('beratHewan') <small class="text-danger fs-7">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-md-6 ">
                        <label for="rasHewan" class="form-label fw-semibold">Ras Hewan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="rasHewan" name="rasHewan" placeholder="Masukkan Ras Hewan">
                        @error('rasHewan') <small class="text-danger fs-7">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6 ">
                        <label for="catatanMedisHewan" class="form-label fw-semibold">Catatan Medis <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="catatanMedisHewan" name="catatanMedisHewan" placeholder="Masukkan Catatan Medis Hewan">
                        @error('catatanMedisHewan') <small class="text-danger fs-7">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-md-12">
                        <label for="alasanPenyerahanHewan" class="form-label fw-semibold">Alasan Menyerahkan Hewan <span class="text-danger">*</span></label>
                        <textarea type="text" class="form-control" rows="3" id="alasanPenyerahanHewan" name="alasanPenyerahanHewan" placeholder="Masukkan Alasan Menyerahkan Hewan"></textarea>
                        @error('alasanPenyerahanHewan') <small class="text-danger fs-7">{{ $message }}</small> @enderror
                    </div>
                </div>
                
                <div class="section-title mt-4">Foto</div>
                <div class="section-divider"></div>

                <div class="row g-3">
                    <div class="col-12">
                        <label for="fotoHewan" class="form-label label-row">Foto Hewan <span class="text-danger">*</span></label>
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

                <div class="d-flex justify-content-end mt-4">
                    <button type="button" class="btn btn-primary-color" style="margin-right: 10px" onclick="kirimPenyerahan()">Kirim Penyerahan</button>
                </div>
            </form>
        </div>
    </div>

    @include('layout.loading')

    <script>
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
        
        function kirimPenyerahan() {
            Swal.fire({
                icon: "question",
                title: "Penyerahan Hewan Peliharaan",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yakin",
                cancelButtonText: "Kembali",
                reverseButtons: true,
                text: 'Apakah anda yakin melakukan penyerahan hewan peliharaan anda?',
                customClass: {
                    actions: 'swal-actions-gap',
                    icon: 'swal-question-primary',
                    confirmButton: 'btn btn-primary-color',
                    cancelButton: 'btn btn-merah-color'
                },
                buttonsStyling: false
            })
            .then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('fullscreen-loading').classList.remove('d-none')
                    const formData = new FormData()
                    formData.append('namaHewan', document.getElementById('namaHewan').value)
                    formData.append('jenisHewan', document.getElementById('jenisHewan').value)
                    formData.append('jenisKelaminHewan', document.getElementById('jenisKelaminHewan').value)
                    formData.append('statusVaksinHewan', document.getElementById('statusVaksinHewan').value)
                    formData.append('statusSterilHewan', document.getElementById('statusSterilHewan').value)
                    formData.append('catatanMedisHewan', document.getElementById('catatanMedisHewan').value)
                    formData.append('beratHewan', document.getElementById('beratHewan').value)
                    formData.append('rasHewan', document.getElementById('rasHewan').value)
                    formData.append('alasanPenyerahanHewan', document.getElementById('alasanPenyerahanHewan').value)
                    formData.append('fotoHewan', document.getElementById('fotoHewan').files[0])
                    formData.append('_token', '{{ csrf_token() }}')

                    document.querySelectorAll('.error-validasi1').forEach(e => e.remove())
                    fetch('{{ route('adopter.lepasAdopsi') }}', {
                        method: "POST",
                        headers: {
                            "Accept": "Application/json",
                        },
                        body: formData
                    })
                    .then(res => res.json())
                    .then(res => {
                        document.getElementById('fullscreen-loading').classList.add('d-none')
                        console.log(res)
                        if (res.errors) {
                            for (const key in res.errors) {
                                const input = document.getElementById(key)
                                if (input) {
                                    const div = document.createElement('div')
                                    div.className = 'text-danger mt-1 fs-7 error-validasi1'
                                    div.innerText = res.errors[key][0]
                                    input.parentNode.appendChild(div)
                                }
                            }
                        } else if (res.success) {
                            Swal.fire({
                                icon: 'success',
                                title: res.title,
                                text: res.message,
                                customClass: {
                                    actions: 'swal-actions-gap',
                                    icon: 'swal-success-primary',
                                    confirmButton: 'btn btn-primary-color',
                                },
                                buttonsStyling: false
                            })
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: res.title,
                                text: res.message,
                                customClass: {
                                    actions: 'swal-actions-gap',
                                    confirmButton: 'btn btn-primary-color',
                                },
                                buttonsStyling: false
                            })
                        }
                    })
                }
            })
        }
    </script>
@endsection
