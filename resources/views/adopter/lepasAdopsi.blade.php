<style>
    .text-atas li {
        margin-left: 2rem;
        margin-top: 0;

    }

    .text-atas p {
        margin-bottom: 0;
        text-align: justify;
    }
</style>

@extends('layout.master')

@section('content')
    <div class="container py-5">
        <div class="text-atas">
            <h1 class="fw-bold text-center">Ajukan Penyerahan Hewan Peliharaan</h1>
            <hr>

            <h5>Pertimbangan Awal</h5>
            <p class="mb-4">1. Untuk hewan peliharaan pribadi, pertimbangkan opsi lain terlebih dahulu, seperti mencarikan pemilik baru yang terpercaya dan mampu merawat hewan anda dengan baik.</p>
            
            <h5>Perlengkapan Yang Disarankan</h5>
            <p>1. Untuk membantu hewan beradaptasi di lingkungan baru, mohon sediakan barang-barang pribadinya jika ada seperti</p>
            <li>Tempat tidur</li>
            <li>Mainan kesayangan</li>
            <li>Makanan favorit atau peralatan makan</li>

            <hr>
        </div>

        <form action="{{ route(name: 'adopter.lepasAdopsi') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="fotoHewan" class="fotoHewan">Foto Hewan <span class="text-danger">*</span></label>
                <input type="file" class="form-control" id="fotoHewan" name="fotoHewan" accept="image/*">
            </div>

            <div class="mb-3">
                <label for="namaHewan" class="form-label">Nama Hewan <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="namaHewan" name="namaHewan" placeholder="Masukkan nama hewan" value="{{ old('namaHewan') }}">
            </div>

            <div class="mb-3">
                <label for="jenisHewan" class="form-label">Jenis Hewan<span class="text-danger">*</span></label>
                <select class="form-select" name="jenisHewan" id="jenisHewan"  >
                    <option value="" disabled selected hidden>Pilih Jenis Hewan</option>
                    <option value="anjing" {{old('jenisHewan') === 'anjing' ? 'selected' : ''}}>Anjing</option>
                    <option value="kucing" {{old('jenisHewan') === 'kucing' ? 'selected' : ''}}>Kucing</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="jeniskelaminHewan" class="form-label">Jenis Kelamin Hewan <span class="text-danger">*</span></label>
                <select class="form-select" name="jenisKelaminHewan" id="jenisKelaminHewan">
                    <option value="" disabled selected hidden>Masukkan Jenis Kelamin Hewan</option>
                    <option value="jantan"  {{old('jenisKelaminHewan') === 'jantan' ? 'selected' : ''}}>Jantan</option>
                    <option value="betina"  {{old('jenisKelaminHewan') === 'betina' ? 'selected' : ''}}>Betina</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="statusVaksinHewan" class="form-label">Status Vaksin Hewan <span class="text-danger">*</span></label>
                <select class="form-select" name="statusVaksinHewan" id="statusVaksinHewan">
                    <option value="" disabled selected hidden>Masukkan Status Vaksin Hewan</option>
                    <option value="sudahVaksin"  {{old('statusVaksinHewan') === 'sudahVaksin' ? 'selected' : ''}}>Sudah di Vaksin</option>
                    <option value="belumVaksin"{{old('statusVaksinHewan') === 'belumVaksin' ? 'selected' : ''}}>Belum di Vaksin</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="statusSterilHewan" class="form-label">Status Steril Hewan <span class="text-danger">*</span></label>
                <select class="form-select" name="statusSterilHewan" id="statusSterilHewan">
                    <option value="" disabled selected hidden>Masukkan Status Vaksin Hewan</option>
                    <option value="sudahSteril" {{old('statusSterilHewan') === 'sudahSteril' ? 'selected' : ''}}>Sudah di Steril</option>
                    <option value="belumSteril" {{old('statusSterilHewan') === 'belumSteril' ? 'selected' : ''}}>Belum di Steril</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="beratHewan" class="form-label">Berat Hewan <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="beratHewan" name="beratHewan" placeholder="Masukkan Berat Hewan">
            </div>

            <div class="mb-3">
                <label for="rasHewan" class="form-label">Ras Hewan <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="rasHewan" name="rasHewan" placeholder="Masukkan Ras Hewan">
            </div>
            
            <div class="mb-3">
                <label for="catatanMedisHewan" class="form-label">Catatan Medis</label>
                <input type="text" class="form-control" id="catatanMedisHewan" name="catatanMedisHewan" placeholder="Masukkan Catatan Medis Hewan">
            </div>
            
            <div class="mb-5">
                <label for="alasanPenyerahanHewan" class="form-label">Alasan Menyerahkan Hewan</label>
                <input type="text" class="form-control" id="alasanPenyerahanHewan" name="alasanPenyerahanHewan" placeholder="Masukkan Alasan Menyerahkan Hewan">
            </div>

            <div class="d-flex justify-content-end mt-4">
                <button type="button" class="btn btn-outline-primary w-30 fw-bold" onclick="kirimPenyerahan()">Kirim Penyerahan</button>
            </div>
        </form>
    </div>

    @include('layout.loading')

    <script>
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
                text: 'Apakah anda yakin melakukan penyerahan hewan peliharaan anda?'
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
                                text: res.message
                            })
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: res.title,
                                text: res.message
                            })
                        }
                    })
                }
            })
        }
    </script>
@endsection
