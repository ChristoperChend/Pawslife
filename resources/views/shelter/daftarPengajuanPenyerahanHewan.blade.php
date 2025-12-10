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
                        <img src="{{ asset('storage/'.$item->foto_hewan) }}"
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
                                {{  Str::ucfirst($item->nama_hewan ?? 'Nama tidak tersedia') }}
                            </span>
                        </p>

                        <p class="mb-0">
                            <span class="text-muted small" style="letter-spacing:.03em;">
                                Jenis hewan:
                            </span>
                            <span class="fw-semibold ms-1">
                                {{ Str::ucfirst($item->jenis_hewan ?? '-') }}
                            </span>
                        </p>

                        <a href="{{ route('shelter.data.penyerahan.hewan', $item->id) }}" 
                            class="text-primary fw-semibold small text-decoration-none d-inline-flex align-items-center gap-1 mt-4">
                            <i class="bi bi-info-circle fs-5" style="color: var(--primary-color);"></i>
                            <span style="color: var(--primary-color);">Informasi Lengkap Hewan</span>
                        </a>
                    </div>

                    

                    <div class="p-3 d-flex flex-column justify-content-between bg-white" style="min-width:220px;">
                        <div>
                            @if($item->status_penyerahan == 'diajukan')
                                <div class="d-flex justify-content-start gap-2 mb-2 mt-4">
                                    <button class="btn btn-primary-color terima-btn w-100" 
                                        data-id="{{ $item->id }}">
                                        Terima
                                    </button>
                                </div>
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
                                Pastikan alamat adopter dekat dengan shelter, sehingga adopter dapat mengantarkan hewan ke shelter.
                            </p>
                            <div class="swal-buttons mt-3" 
                                style="display:flex; justify-content:center; gap:10px; width:100%; margin-top:18px;">
                                <button type="button" id="btnKembaliKonfirmasi" 
                                    class="btn border btn-kembali fw-semibold px-4 py-2 flex-fill" 
                                    style="width:110px; font-size:14px;">
                                    Kembali
                                </button>
                                <button type="button" id="btnYakinKonfirmasi" 
                                    class="btn btn-primary-color text-white fw-semibold px-4 py-2 flex-fill" 
                                    style="width:110px; font-size:14px;">
                                    Yakin
                                </button>
                            </div>
                        `,
                        showConfirmButton: false,
                        showCancelButton: false,
                        width: 420,
                        padding: '1.2rem 1.2rem',
                        customClass: { 
                            popup: 'rounded-3 shadow-sm',
                            icon: 'swal-question-primary'
                        },
                        didOpen: () => {
                            const kembaliKonfirmasi = document.getElementById('btnKembaliKonfirmasi');
                            const yakinKonfirmasi   = document.getElementById('btnYakinKonfirmasi');

                            kembaliKonfirmasi.addEventListener('click', () => Swal.close());

                            yakinKonfirmasi.addEventListener('click', () => {

                                fetch(`{{ url('/shelter/terima-penyerahan-hewan') }}/${penyerahanId}`, {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Accept': 'application/json',
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({}) 
                                })
                                .then(async (response) => {
                                    let data = null;
                                    try {
                                        data = await response.json();
                                    } catch (e) {}

                                    if (!response.ok || !data || data.success === false) {
                                        const msg = data && data.message 
                                            ? data.message 
                                            : 'Penyerahan adopsi gagal disetujui.';
                                        throw new Error(msg);
                                    }

                                    return data;
                                })
                                .then((data) => {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil!',
                                        text: data.message || 'Penyerahan adopsi berhasil disetujui.',
                                        confirmButtonText: 'OK',
                                        buttonsStyling: false,
                                        customClass: { 
                                            icon: 'swal-success-primary',
                                            confirmButton: 'btn btn-primary-color px-4 fw-semibold'
                                        }
                                    }).then(() => location.reload());
                                })
                                .catch((error) => {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Terjadi kesalahan!',
                                        text: error.message || 'Tidak dapat memproses permintaan.',
                                        buttonsStyling: false,
                                        customClass: { 
                                            icon: 'swal-error-primary',
                                            confirmButton: 'btn btn-primary-color px-4 fw-semibold'
                                        }
                                    });
                                });
                            });
                        }
                    });
                });
            });
        })
    </script>
@endsection
