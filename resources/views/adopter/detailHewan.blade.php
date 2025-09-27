<style>
    .hewan-image {
        width: 600px;
        height: 450px !important;
        border-radius: 10px;
    }

    .detail-row div h5 {
        margin-bottom: 0px;
        font-weight: normal;
        font-size: 18px;
        margin-bottom: 5px;
    }

    .nama-hewan {
        background: white !important;
    }

    .detail-row {
        margin-bottom: 15px;
    }
    .detail-row label {
        margin-bottom: 0;
        color: black !important;
        background: white !important;
    }

    .mr {
        margin-right: 0.7em !important;
    }

    .ajukan-adopsi {
        text-align: justify;
    }
</style>

@extends('layout.master')

@section('content')

    <div class="container py-5">
        <div class="row">
            <div class="col-12 col-md-6 text-center">
                <img src="{{ asset('storage/' . $detailHewan->foto_hewan) }}" class="hewan-image img-fluid" alt="Hewan Image">
                <label class="border shadow-sm w-75 p-2 mb-3 mt-3 rounded-2 nama-hewan text-black">{{ $detailHewan->nama_hewan ?? 'data tidak ada' }}</label>
            </div>

            <div class="col-12 col-md-6">
                <div class="row detail-row">
                    <div class="col-12">
                        <h5>Nama shelter</h5>
                        <label class="border shadow-sm w-100 p-2 text-white rounded-2 mb-3 d-flex al
                        ign-items-center justify-content-between">
                            {{ $detailHewan->shelter->nama_shelter ?? 'data tidak ada' }}
                            <a href="{{ route('adopter.detailShelter', ['id' => $detailHewan->shelter->id]) }}" class="text-decoration-none cursor">
                                <i class="fa-solid fa-chevron-right fa-2xs" style="color: #000000;"></i>
                            </a>
                        </label>
                    </div>
                </div>

                <div class="row detail-row">
                    <div class="col-12">
                        <h5>Jenis hewan</h5>
                        <label class="border shadow-sm w-100 p-2 text-white rounded-2 mb-3">{{ $detailHewan->jenis_hewan ?? 'data tidak ada' }}</label>
                    </div>
                </div>

                <div class="row detail-row">
                    <div class="col-12">
                        <h5>Ras hewan</h5>
                        <label class="border shadow-sm w-100 p-2 text-white rounded-2 mb-3">{{ $detailHewan->ras ?? 'data tidak ada' }}</label>
                    </div>
                </div>

                <div class="row detail-row">
                    <div class="col-12">
                        <h5>Jenis kelamin hewan</h5>
                        <label class="border shadow-sm w-100 p-2 text-white rounded-2 mb-3">{{ $detailHewan->jenis_kelamin ?? 'data tidak ada' }}</label>
                    </div>
                </div>

                <div class="row detail-row">
                    <div class="col-12">
                        <h5>Berat hewan</h5>
                        <label class="border shadow-sm w-100 p-2 text-white rounded-2 mb-3">{{ $detailHewan->berat ?? 'data tidak ada' }}</label>
                    </div>
                </div>

                <div class="row detail-row">
                    <div class="col-12">
                        <h5>Apakah hewan sudah disteril</h5>
                        <label class="border shadow-sm w-100 p-2 text-white rounded-2 mb-3">{{ $detailHewan->status_steril ?? 'data tidak ada' }}</label>
                    </div>
                </div>

                <div class="row detail-row">
                    <div class="col-12">
                        <h5>Apakah hewan sudah divaksin</h5>
                        <label class="border shadow-sm w-100 p-2 text-white rounded-2 mb-3">{{ $detailHewan->status_vaksin ?? 'data tidak ada' }}</label>
                    </div>
                </div>

                <div class="row detail-row">
                    <div class="col-12">
                        <h5>Catatan medis hewan</h5>
                        <label class="border shadow-sm w-100 p-2 text-white rounded-2 mb-3">{{ $detailHewan->catatan_medis ?? 'data tidak ada' }}</label>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="button" class="btn btn-outline-primary w-30 fw-bold"><a href="{{ route('beranda.adopterBeranda') }}" class="text-decoration-none">Kembali</a></button>
                    <button type="button" class="btn btn-outline-primary w-30 fw-bold ms-4 mr" onclick="ajukanAdopsi()">Ajukan Adopsi</button>
                </div>
            </div>
        </div>
    </div>

    @include('layout.loading')

    <script>
        function ajukanAdopsi() {
            Swal.fire({
                icon: "question",
                title: "Alasan Pengajuan Adopsi",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Selanjutnya",
                cancelButtonText: "Kembali",
                reverseButtons: true,
                width: '800px',
                html: '<div><hr> <h6 class="text-start">Apa alasan anda ingin mengadopsi hewan ini?</h6> <textarea class="form-control" rows="4" id="alasan_adopsi"></textarea> <hr></div>',
                preConfirm: () => {
                    const alasan = document.getElementById('alasan_adopsi').value;
                    if (!alasan) {
                        Swal.showValidationMessage('Alasan wajib diisi!');
                    }
                    return alasan;
                }
            })
            .then((result) => {
                if (result.isConfirmed) {
                    const alasan = result.value;
                    Swal.fire({
                        icon: "question",
                        title: "Percobaan Adopsi",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Setuju",
                        cancelButtonText: "Kembali",
                        reverseButtons: true,
                        width: '800px',
                        html: '<div class="ajukan-adopsi"><hr><h6>Kami menyediakan "Percobaan Adopsi" untuk memastikan kecocokan antara hewan dan calon pengadopsi.</h6><h6>1. Calon pengadopsi diberikan waktu <b>1 minggu</b> untuk mengenal dan merawat hewan yang diadopsi.</h6><h6>2. Jika selama masa percobaan terdapat kendala atau ketidaksesuaian, calon pengadopsi diperbolehkan mengembalikan hewan ke shelter asal tanpa konsekuensi dengan melakukan konfirmasi di <b>Riwayat pengajuan adopsi</b>.</h6><h6>3. Jika <b>TIDAK</b> melakukan konfirmasi setelah melewati <b>1 minggu</b> masa percobaan, maka masa percobaan akan otomatis berakhir.</h6><hr></div>'
                    })
                    .then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('fullscreen-loading').classList.remove('d-none')
                            const data = {
                                adopter_id: '{{ $adopter_id }}',
                                hewan_id: '{{ $detailHewan->id }}',
                                shelter_id: '{{ $detailHewan->shelter->id }}',
                                alasan: alasan
                            }
                            fetch("{{ route('adopter.ajukanAdopsi') }}", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                },
                                body: JSON.stringify(data)
                            })
                            .then(res => res.json())
                            .then(res => {
                                document.getElementById('fullscreen-loading').classList.add('d-none')
                                if (res.success) {
                                    Swal.fire({
                                        icon: "success",
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
            })
        }
    </script>

@endsection