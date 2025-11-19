@extends('layout.master')

@section('content')
<style>
    .tolak-btn:hover {
        background-color: #dc3545 !important; 
        color: white !important;   
        transition: all 0.2s ease-in-out;
    }
</style>

<div class="container py-4">
    {{-- Header --}}
    <div class="text-center my-4">
        <h2 class="fw-bold fs-3 mb-2">Daftar Pengajuan Adopsi</h2>
        <hr class="w-100 mx-auto text-secondary opacity-25">
    </div>

    @php
        use Illuminate\Support\Str;
    @endphp

    @forelse ($data as $item)
        <div class="card border mb-3 rounded-3 overflow-hidden bg-white">
            <div class="d-flex flex-wrap align-items-stretch">
                
                <div class="p-3 d-flex align-items-center justify-content-center bg-white" 
                     style="width:140px; min-height:130px;">
                    <img src="{{ asset($item->hewan->foto_hewan) }}" 
                         alt="Foto Hewan"
                         class="rounded"
                         style="width:100px; height:100px; object-fit:cover; background:#e5e7eb;">
                </div>

                <div class="flex-fill p-3 border-end d-flex flex-column justify-content-center bg-white">
                    <p class="mb-1">
                        <span class="text-muted small" style="letter-spacing:.03em;">
                            Nama hewan:
                        </span>
                        <span class="fw-semibold ms-1">
                            {{  Str::ucfirst($item->hewan->nama_hewan ?? 'Nama tidak tersedia') }}
                        </span>
                    </p>

                    <p class="mb-0">
                        <span class="text-muted small" style="letter-spacing:.03em;">
                            Jenis hewan:
                        </span>
                        <span class="fw-semibold ms-1">
                            {{ Str::ucfirst($item->hewan->jenis_hewan ?? '-') }}
                        </span>
                    </p>
                </div>


                
                <div class="p-3 d-flex flex-column justify-content-between bg-white" style="min-width:200px;">
                    <div>
                        <h6 class="fw-bold mb-2">Status</h6>
                        {{-- @if($item->status_pengajuan == 'setuju')
                            <div 
                                class="d-inline-flex flex-column align-items-center justify-content-center fw-semibold text-center"
                                style="
                                    background-color: #e8f0fe;
                                    color: #1967d2;
                                    border-radius: 6px;
                                    font-size: 0.9rem;
                                    padding: 6px 12px;
                                    min-width: 160px;
                                ">
                                <span>Masa Percobaan</span>
                                @if($item->tanggal_mulai_percobaan && $item->tanggal_akhir_percobaan)
                                    <small class="fw-normal mt-1" style="font-size: 0.78rem; color:#3c4043;">
                                        {{ \Carbon\Carbon::parse($item->tanggal_mulai_percobaan)->format('d M Y') }}
                                        –
                                        {{ \Carbon\Carbon::parse($item->tanggal_akhir_percobaan)->format('d M Y') }}
                                    </small>
                                @endif
                            </div>
                        @elseif($item->status_pengajuan == 'ditolak')
                            <span 
                                class="d-inline-flex align-items-center fw-semibold"
                                style="
                                    background-color: #e8f0fe;
                                    color: #1967d2;
                                    border-radius: 6px;
                                    font-size: 0.9rem;
                                    padding: 4px 10px;
                                    min-width: 150px;
                                    justify-content: center;
                                ">
                                Pengajuan Ditolak
                            </span>
                        @elseif($item->status_pengajuan == 'diadopsi')
                            <span 
                                class="d-inline-flex align-items-center fw-semibold"
                                style="
                                    background-color: #e8f0fe;
                                    color: #1967d2;
                                    border-radius: 6px;
                                    font-size: 0.9rem;
                                    padding: 4px 10px;
                                    min-width: 150px;
                                    justify-content: center;
                                ">
                                Diadopsi
                            </span>
                        @elseif($item->status_pengajuan == 'dikembalikan')
                            <span 
                                class="d-inline-flex align-items-center fw-semibold"
                                style="
                                    background-color: #e8f0fe;
                                    color: #1967d2;
                                    border-radius: 6px;
                                    font-size: 0.87rem;
                                    padding: 4px 10px;
                                    min-width: 150px;
                                    justify-content: center;
                                ">
                                Hewan Dikembalikan
                            </span>
                        @else
                            <div class="d-flex justify-content-start gap-2 mb-2">
                                <button class="btn btn-sm fw-semibold px-3 border bg-white text-dark tolak-btn"
                                data-id="{{ $item->id }}">
                                    Tolak
                                </button>

                                <button class="btn btn-sm btn-primary fw-semibold px-3 text-white terima-btn" 
                                    data-id="{{ $item->id }}">
                                    Terima
                                </button>
                            </div>
                        @endif --}}
                        @if ($item->status_pengajuan === 'diajukan' )
                              <div class="d-flex justify-content-start gap-2 mb-2">
                                <button class="btn btn-merah-color tolak-btn"
                                data-id="{{ $item->id }}">
                                    Tolak
                                </button>

                                <button class="btn btn-primary-color terima-btn" 
                                    data-id="{{ $item->id }}">
                                    Terima
                                </button>
                            </div>
                        @endif
                    </div>

                    <a href="{{ route('shelter.adopter.profile', $item->adopter_id) }}" 
                       class="text-primary fw-semibold small text-decoration-none d-inline-flex align-items-center gap-1">
                        <i class="bi bi-info-circle fs-5" style="cursor:pointer; color:#0d6efd;" title="View Status"></i>
                        <span>Informasi Adopter</span>
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center text-muted mt-5">
            <p>Belum ada pengajuan adopsi.</p>
        </div>
    @endforelse

    <div class="d-flex justify-content-center mt-5 mb-5">
        {{$data->links()}}
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
     document.querySelectorAll('.terima-btn').forEach(button => {
        button.addEventListener('click', function () {
            const pengajuanId = this.dataset.id;

            Swal.fire({
                title: '<h4 style="font-weight:700; font-size:20px; margin-bottom:14px;">Alasan konfirmasi pengajuan adopsi</h4>',
                html: `
                    <div style="text-align:left; margin-bottom:8px; font-size:15px; color:#333;">
                        Apa alasan anda menyetujui pengajuan adopsi ini?
                    </div>
                    <textarea id="alasan" class="form-control" 
                        style="width:100%; border-radius:8px; border:1px solid #d1d5db; 
                        padding:10px; font-size:14px; resize:none;" 
                        rows="4" placeholder="Tuliskan alasan anda di sini..."></textarea>

                    <div class="swal-buttons mt-3" 
                        style="display:flex; justify-content:center; gap:12px; width:100%;">
                        <button type="button" id="btnKembali" 
                            class="btn border btn-light fw-semibold px-4 py-2 flex-fill" 
                            style="width:120px;">
                            Kembali
                        </button>
                        <button type="button" id="btnSelanjutnya" 
                            class="btn btn-primary text-white fw-semibold px-4 py-2 flex-fill" 
                            style="width:120px;">
                            Selanjutnya
                        </button>
                    </div>
                `,
                showConfirmButton: false,
                showCancelButton: false,
                width: 480,
                padding: '1.5rem 1.5rem 1rem',
                customClass: { popup: 'rounded-3 shadow-sm' },
                didOpen: () => {
                    const kembali = document.getElementById('btnKembali');
                    const lanjut = document.getElementById('btnSelanjutnya');

                    kembali.addEventListener('click', () => Swal.close());

                    lanjut.addEventListener('click', () => {
                        const alasan = document.getElementById('alasan').value.trim();
                        if (!alasan) {
                            Swal.showValidationMessage('Harap isi alasan terlebih dahulu');
                            return;
                        }

                        Swal.fire({
                            icon: 'question',
                            title: '<h4 style="font-weight:700; font-size:18px; margin-bottom:8px;">Apakah anda yakin menerima pengajuan adopsi?</h4>',
                            html: `
                                <p style="font-size:14px; color:#444; margin-bottom:0; line-height:1.4;">
                                    Anda harus mengantarkan hewan peliharaan pada alamat adopter.
                                </p>
                                <div class="swal-buttons mt-3" 
                                    style="display:flex; justify-content:center; gap:10px; width:100%; margin-top:18px;">
                                    <button type="button" id="btnKembaliKonfirmasi" 
                                        class="btn border btn-light fw-semibold px-4 py-2 flex-fill" 
                                        style="width:110px; font-size:14px;">
                                        Kembali
                                    </button>
                                    <button type="button" id="btnYakinKonfirmasi" 
                                        class="btn btn-primary text-white fw-semibold px-4 py-2 flex-fill" 
                                        style="width:110px; font-size:14px;">
                                        Yakin
                                    </button>
                                </div>
                            `,
                            showConfirmButton: false,
                            showCancelButton: false,
                            width: 420,              
                            padding: '1.2rem 1.2rem', 
                            customClass: { popup: 'rounded-3 shadow-sm' },
                            didOpen: () => {
                                const kembaliKonfirmasi = document.getElementById('btnKembaliKonfirmasi');
                                const yakinKonfirmasi = document.getElementById('btnYakinKonfirmasi');

                                kembaliKonfirmasi.addEventListener('click', () => Swal.close());

                                yakinKonfirmasi.addEventListener('click', () => {
                                    fetch(`/shelter/terima-pengajuan-adopsi/${pengajuanId}`, {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        body: JSON.stringify({ alasan })
                                    })
                                    .then(res => res.json())
                                    .then(() => {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Berhasil!',
                                            text: 'Hewan memasuki tahap percobaan adopsi',
                                            confirmButtonText: 'OK',
                                            customClass: { confirmButton: 'btn btn-primary text-white px-4 fw-semibold' },
                                            buttonsStyling: false
                                        }).then(() => location.reload());
                                    })
                                    .catch(() => {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Terjadi kesalahan!',
                                            text: 'Tidak dapat memproses permintaan.',
                                        });
                                    });
                                });
                            }
                        });
                    });
                }
            });
        });
    });

    document.querySelectorAll('.tolak-btn').forEach(button => {
        button.addEventListener('click', function () {
            const pengajuanId = this.dataset.id;

            Swal.fire({
                title: '<h4 style="font-weight:700; font-size:20px; margin-bottom:14px;">Alasan menolak pengajuan adopsi</h4>',
                html: `
                    <div style="text-align:left; margin-bottom:8px; font-size:15px; color:#333;">
                        Apa alasan anda menolak pengajuan adopsi ini?
                    </div>
                    <textarea id="alasanTolak" class="form-control" 
                        style="width:100%; border-radius:8px; border:1px solid #d1d5db; 
                        padding:10px; font-size:14px; resize:none; outline:none;" 
                        rows="4" placeholder="Tuliskan alasan anda di sini..."></textarea>

                    <div class="swal-buttons mt-3" 
                        style="display:flex; justify-content:center; gap:12px; width:100%;">
                        <button type="button" id="btnKembaliTolak" 
                            class="btn border btn-light fw-semibold px-4 py-2 flex-fill" 
                            style="width:120px;">
                            Kembali
                        </button>
                        <button type="button" id="btnSelanjutnyaTolak" 
                            class="btn btn-primary text-white fw-semibold px-4 py-2 flex-fill" 
                            style="width:120px;">
                            Selanjutnya
                        </button>
                    </div>
                `,
                showConfirmButton: false,
                showCancelButton: false,
                width: 480,
                padding: '1.5rem 1.5rem 1rem',
                customClass: { popup: 'rounded-3 shadow-sm' },
                didOpen: () => {
                    const kembali = document.getElementById('btnKembaliTolak');
                    const lanjut = document.getElementById('btnSelanjutnyaTolak');

                    kembali.addEventListener('click', () => Swal.close());

                    lanjut.addEventListener('click', () => {
                        const alasan = document.getElementById('alasanTolak').value.trim();
                        if (!alasan) {
                            Swal.showValidationMessage('Harap isi alasan terlebih dahulu');
                            return;
                        }

                        // POST request to backend
                        fetch(`/shelter/tolak-pengajuan-adopsi/${pengajuanId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ alasan })
                        })
                        .then(res => res.json())
                        .then(() => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Pengajuan Ditolak',
                                text: 'Pengajuan adopsi telah ditolak.',
                                confirmButtonText: 'OK',
                                customClass: { confirmButton: 'btn btn-dark text-white px-4 fw-semibold' },
                                buttonsStyling: false
                            }).then(() => location.reload());
                        })
                        .catch(() => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi kesalahan!',
                                text: 'Tidak dapat memproses permintaan.',
                            });
                        });
                    });
                }
            });
        });
    });
});
</script>

@endsection
