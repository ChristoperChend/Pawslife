@extends('layout.master')
<style>
    .tolak-btn:hover {
        background-color: #dc3545 !important; 
        color: white !important;   
        transition: all 0.2s ease-in-out;
    }
</style>
    

@section('content')

    <div class="container py-4">
        <div class="text-center my-4">
            <h2 class="fw-bold fs-3 mb-2">Daftar Penyerahan Hewan</h2>
            <hr class="w-100 mx-auto text-secondary opacity-25">
        </div>

        @forelse ($data as $item)
            <div class="card border mb-3 rounded-3 overflow-hidden bg-white">
                <div class="d-flex flex-wrap align-items-stretch">

                    <div class="p-3 d-flex align-items-center justify-content-center bg-white" 
                        style="width:140px; min-height:130px;">
                        <img src="{{ asset('storage/' . $item->foto_hewan) }}"
                            alt="Foto Hewan"
                            class="rounded"
                            style="width:100px; height:100px; object-fit:cover; background:#e5e7eb;">
                    </div>

                    <div class="flex-fill d-flex flex-column justify-content-between border-end bg-white p-3">
                        <div>
                            <h5 class="fw-bold mb-1">{{ $item->nama_hewan ?? 'Nama tidak tersedia' }}</h5>
                            <p class="mb-2 text-muted">Jenis hewan: {{ Str::ucfirst($item->jenis_hewan ?? '-') }}</p>
                        </div>

                        <a href="{{ route('shelter.data.penyerahan.hewan', $item->id) }}" 
                            class="text-primary fw-semibold small text-decoration-none d-inline-flex align-items-center gap-1">
                            <i class="bi bi-info-circle fs-5" style="color: var(--primary-color);"></i>
                            <span style="color: var(--primary-color);">Informasi Lengkap Hewan</span>
                        </a>
                    </div>

                    

                    <div class="p-3 d-flex flex-column justify-content-between bg-white" style="min-width:200px;">
                        <div>
                            <h6 class="fw-bold mb-2">Status</h6>
                            @if($item->status_penyerahan == 'diajukan')
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
                            {{-- @elseif($item->status_penyerahan == 'setuju')
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
                                    Berhasil Diadopsi
                                </span> --}}
                            @endif
                        </div>

                        <a href="{{ route('shelter.adopter.profile', $item->adopter_id) }}" 
                        class="text-primary fw-semibold small text-decoration-none d-inline-flex align-items-center gap-1">
                            <i class="bi bi-info-circle fs-5" style="cursor:pointer; color: var(--primary-color);" title="View Status"></i>
                            <span style="color: var(--primary-color)">Informasi Adopter</span>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center text-muted mt-5">
            <p>Belum ada pengajuan penyerahan hewan.</p>
        </div>
        @endforelse

        <div class="d-flex justify-content-center mt-5 mb-5">
            {{$data->links()}}
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            document.querySelectorAll('.terima-btn').forEach(button => {
                button.addEventListener('click', function(){
                    const penyerahanId = this.dataset.id;

                    Swal.fire({
                        icon: 'question',
                        title: '<h4 style="font-weight:700; font-size:18px; margin-bottom:8px;">Apakah anda yakin menerima penyerahan hewan?</h4>',
                        html: `
                            <p style="font-size:14px; color:#444; margin-bottom:0; line-height:1.4;">
                                Anda harus mengambil hewan peliharaan pada alamat adopter.
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
                                fetch(`/shelter/terima-penyerahan-hewan/${penyerahanId}`, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                })
                                .then(res => res.json())
                                .then(() => {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil!',
                                        text: 'Penyerahan hewan berhasil disetujui.',
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
                })
            });

            document.querySelectorAll('.tolak-btn').forEach(button => {
                button.addEventListener('click', async function() {
                    const id = this.dataset.id;

                    Swal.fire({
                        icon: 'warning',
                        title: '<h4 style="font-weight:700; font-size:18px; margin-bottom:8px;">Apakah anda yakin ingin menolak penyerahan hewan ini?</h4>',
                        html: `
                            <p style="font-size:14px; color:#444; margin-bottom:0; line-height:1.4;">
                                Setelah ditolak, status penyerahan tidak dapat diubah kembali.
                            </p>
                            <div class="swal-buttons mt-3" 
                                style="display:flex; justify-content:center; gap:10px; width:100%; margin-top:18px;">
                                <button type="button" id="btnKembaliTolak" 
                                    class="btn border btn-light fw-semibold px-4 py-2 flex-fill" 
                                    style="width:110px; font-size:14px;">
                                    Kembali
                                </button>
                                <button type="button" id="btnYakinTolak" 
                                    class="btn btn-danger text-white fw-semibold px-4 py-2 flex-fill" 
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
                            const btnKembali = document.getElementById('btnKembaliTolak');
                            const btnYakin = document.getElementById('btnYakinTolak');

                            btnKembali.addEventListener('click', () => Swal.close());

                            btnYakin.addEventListener('click', async () => {
                                Swal.close(); // close the confirmation first
                                try {
                                    const response = await fetch(`/shelter/tolak-penyerahan-hewan/${id}`, {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN':'{{ csrf_token() }}',
                                            'Content-Type':'application/json'
                                        }
                                    });

                                    const result = await response.json();

                                    if (response.ok && result.status === 'success') {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Berhasil!',
                                            text: result.message,
                                            confirmButtonText: 'OK',
                                            confirmButtonColor: '#3085d6'
                                        }).then(() => location.reload());
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Gagal!',
                                            text: result.message || 'Terjadi kesalahan.',
                                            confirmButtonColor: '#d33',
                                            confirmButtonText: 'OK'
                                        });
                                    }
                                } catch (error) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Terjadi kesalahan!',
                                        text: 'Tidak dapat memproses permintaan.',
                                        confirmButtonColor: '#d33',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            });
                        }
                    });
                });
            });

        })
    </script>
@endsection
