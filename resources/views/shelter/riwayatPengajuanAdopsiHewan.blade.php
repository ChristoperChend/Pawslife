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
    <div class="text-center my-4">
        <h2 class="fw-bold fs-3 mb-2">Riwayat Pengajuan Adopsi Hewan</h2>
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
                    <img src="{{ asset('storage/'.$item->hewan->foto_hewan) }}" 
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

                
                <div class="p-3 d-flex flex-column justify-content-between bg-white" style="min-width:220px;">
                    <div>
                        <h6 class="fw-bold mb-2">Status</h6>
                        @if($item->status_pengajuan == 'setuju')
                        <div class="d-flex flex-column align-items-center w-100">
                            
                            <div class="badge px-3 py-2 rounded-pill mb-2 shadow-sm w-100" 
                                style="color: var(--primary-color); border: 1px solid var(--primary-color); background-color: #eef2fb;">
                                <i class="bi bi-clock-history me-1"></i> Masa Percobaan
                            </div>

                            @if($item->tanggal_mulai_percobaan && $item->tanggal_akhir_percobaan)
                                <div class="d-flex flex-column align-items-center mb-2">
                                    <small class="text-secondary" style="font-size: 0.75rem; letter-spacing: 0.5px;">PERIODE:</small>
                                    <small class="fw-semibold text-dark" style="font-size: 0.85rem;">
                                        {{ \Carbon\Carbon::parse($item->tanggal_mulai_percobaan)->format('d M') }} 
                                        <span class="text-muted mx-1">&mdash;</span> 
                                        {{ \Carbon\Carbon::parse($item->tanggal_akhir_percobaan)->format('d M Y') }}
                                    </small>
                                </div>
                            @endif

                            <div class="w-100 mt-1 mb-3">
                                <button class="btn btn-merah-color btn-batalkan w-100 fw-semibold"
                                        style="font-size: 0.9rem; padding: 6px 12px;"
                                        data-id="{{ $item->id }}">
                                    Batalkan
                                </button>
                            </div>
                        </div>

                        @elseif($item->status_pengajuan == 'tolak')
                            <div class="badge px-3 py-2 rounded-pill mb-2 shadow-sm w-100" 
                                style="color: #dc3545; border: 1px solid #dc3545; background-color: #ffe8ea;">
                                Pengajuan Ditolak
                            </div>
                        @elseif($item->status_pengajuan == 'dibatalkan')
                            <div class="badge px-3 py-2 rounded-pill mb-2 shadow-sm w-100" 
                                style="color: #dc3545; border: 1px solid #dc3545; background-color: #ffe8ea;">
                                Percobaan Adopsi Batal
                            </div>
                        @elseif($item->status_pengajuan == 'diadopsi')
                            <div class="badge px-3 py-2 rounded-pill mb-2 shadow-sm w-100" 
                                style="color: var(--primary-color); border: 1px solid var(--primary-color); background-color: #eef2fb;">
                                Diadopsi
                            </div>
                        @elseif($item->status_pengajuan == 'dikembalikan')
                            <div class="badge px-3 py-2 rounded-pill mb-2 shadow-sm w-100" 
                                style="color: #dc3545; border: 1px solid #dc3545; background-color: #ffe8ea;">
                                Hewan Dikembalikan
                            </div>
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
            <p>Belum ada riwayat pengajuan adopsi.</p>
        </div>
    @endforelse

    <div class="d-flex justify-content-center mt-5 mb-5">
        {{$data->links()}}
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        document.querySelectorAll('.btn-batalkan').forEach(button => {
            button.addEventListener('click', function() {
                const pengajuanId = this.dataset.id;

                Swal.fire({
                    icon: 'question',
                    html: `
                        <div style="text-align:left; margin-bottom:8px; font-size:15px; color:#333;">
                            Apa alasan anda membatalkan masa percobaan adopsi ini?
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
                    adding: '1.5rem 1.5rem 1rem',
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
                                title: '<h4 style="font-weight:700; font-size:18px; margin-bottom:8px;">Apakah anda yakin membatalkan percobaan adopsi?</h4>',
                                html: `
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
                                        fetch(`/shelter/batalkan-masa-percobaan/${pengajuanId}`, {
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
                                                text: 'Masa percobaan berhasil dibatalkan',
                                                confirmButtonText: 'OK',
                                                customClass: { confirmButton: 'btn btn-primary text-white px-4 fw-semibold', icon: 'swal-success-primary' },
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
                })
            })
        })
    })
</script>
@endsection