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

    .detail-field-wrapper {
        display: flex;
        align-items: center;
        justify-content: space-between;
        border: 1px solid #cacaca;
        border-left: 5px solid var(--primary-color);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        border-radius: 8px;
        padding: 10px 15px;
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

    .ajukan-adopsi {
        text-align: justify;
    }
</style>

@extends('layout.master')

@section('content')

    <div class="container py-5">
        <div class="text-center">
            <h2>Detail Hewan</h2>
        </div>

        <div class="card shadow-sm border-0 mx-auto" style="max-width: 900px;">
            <div class="card-body p-5">
                <div class="row-12 row-md-6 text-center mb-4">
                    <img src="{{ asset($detailHewan->foto_hewan) }}" class="hewan-image" alt="{{ $detailHewan->nama_hewan }}">
                </div>
                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="detail-label"><i class="fa-solid fa-house me-1"></i> Nama Shelter</h5>
                        <div class="detail-field-wrapper">
                            <span class="detail-text">{{ $detailHewan->shelter->nama_shelter ?? 'data tidak ada' }}</span>
                            <a href="{{ route('adopter.detailShelter', ['id' => $detailHewan->shelter->id]) }}" class="text-decoration-none cursor">
                                <i class="fa-solid fa-chevron-right fa-2xs" style="color: #000000;"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="detail-label"><i class="fa-solid fa-paw me-1"></i> Nama hewan</h5>
                        <div class="detail-field-wrapper">
                            <span class="detail-text">{{ $detailHewan->nama_hewan ?? 'data tidak ada' }}</span>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="detail-label">
                            @if (strtolower($detailHewan->jenis_hewan) === 'anjing')
                                <i class="fa-solid fa-dog me-1"></i>
                            @elseif (strtolower($detailHewan->jenis_hewan) === 'kucing')
                                <i class="fa-solid fa-cat me-1"></i>
                            @else
                                <i class="fa-solid fa-paw me-1"></i>
                            @endif 
                            Jenis hewan
                        </h5>
                        <div class="detail-field-wrapper">
                            <span class="detail-text">{{ $detailHewan->jenis_hewan ?? 'data tidak ada' }}</span>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="detail-label"><i class="fa-solid fa-tag me-1"></i> Ras hewan</h5>
                        <div class="detail-field-wrapper">
                            <span class="detail-text">{{ $detailHewan->ras ?? 'data tidak ada' }}</span>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="detail-label"><i class="fa-solid {{ $detailHewan->jenis_kelamin == 'jantan' ? 'fa-mars' : 'fa-venus' }} me-1"></i> Jenis kelamin hewan</h5>
                        <div class="detail-field-wrapper">
                            <span class="detail-text">{{ $detailHewan->jenis_kelamin ?? 'data tidak ada' }}</span>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="detail-label"><i class="fa-solid fa-weight-scale me-1"></i> Berat hewan</h5>
                        <div class="detail-field-wrapper">
                            <span class="detail-text">{{ $detailHewan->berat ?? 'data tidak ada' }}</span>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="detail-label"><i class="fa-solid fa-syringe me-1"></i> Apakah hewan sudah disteril</h5>
                        <div class="detail-field-wrapper">
                            <span class="detail-text">{{ $detailHewan->status_steril ?? 'data tidak ada' }}</span>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="detail-label"><i class="fa-solid fa-shield-virus me-1"></i> Apakah hewan sudah divaksin</h5>
                        <div class="detail-field-wrapper">
                            <span class="detail-text">{{ $detailHewan->status_vaksin ?? 'data tidak ada' }}</span>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="detail-label"><i class="fa-solid fa-notes-medical me-1"></i> Catatan medis hewan</h5>
                        <div class="detail-field-wrapper">
                            <span class="detail-text">{{ $detailHewan->catatan_medis ?? 'data tidak ada' }}</span>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-5 gap-3">
                    <a href="{{ route('beranda.adopterBeranda') }}" style="margin-left: 12px;" class="btn btn-kembali">Kembali</a>
                    <button type="button" style="margin-right: 12px" class="btn btn-primary-color" onclick="ajukanAdopsi()">Ajukan Adopsi</button>
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
                },
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
                        html: '<div class="ajukan-adopsi"><div class="text-center text-danger"><label class="fw-bold">* Pengajuan adopsi tidak bisa dibatalkan. *</label></div><hr><h6>Kami menyediakan "Percobaan Adopsi" untuk memastikan kecocokan antara hewan dan calon pengadopsi.</h6><h6>1. Calon pengadopsi diberikan waktu <b>1 minggu</b> untuk mengenal dan merawat hewan yang diadopsi.</h6><h6>2. Jika selama masa percobaan terdapat kendala atau ketidaksesuaian, calon pengadopsi diperbolehkan mengembalikan hewan ke shelter asal tanpa konsekuensi dengan melakukan konfirmasi di <b>Riwayat pengajuan adopsi</b>.</h6><h6>3. Jika <b>TIDAK</b> melakukan konfirmasi setelah melewati <b>1 minggu</b> masa percobaan, maka masa percobaan akan otomatis berakhir dan hewan otomatis diadopsi.</h6><hr></div>',
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
            })
        }
    </script>

@endsection