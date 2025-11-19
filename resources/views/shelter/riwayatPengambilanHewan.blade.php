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
            <h2 class="fw-bold fs-3 mb-2">Daftar Riwayat Pengambilan Hewan Adopter</h2>
            <hr class="w-100 mx-auto text-secondary opacity-25">
        </div>

        @forelse ($data as $item)
            <div class="card border mb-3 rounded-3 overflow-hidden bg-white">
                <div class="d-flex flex-wrap align-items-stretch">

                    <div class="p-3 d-flex align-items-center justify-content-center bg-white" 
                        style="width:140px; min-height:130px;">
                        <img src="{{ asset($item->foto_hewan) }}"
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

                    

                    <div class="p-3 d-flex flex-column justify-content-between bg-white" style="min-width:200px;">
                        <div>
                            <h6 class="fw-bold mb-2">Status</h6>
                            @if($item->status_penyerahan == 'setuju')
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
                                </span>
                            @elseif($item->status_penyerahan == 'tolak')
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
                                    Penyerahan Ditolak
                                </span>
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
            <p>Belum ada riwayat pengambilan hewan adopter.</p>
        </div>
        @endforelse

        <div class="d-flex justify-content-center mt-5 mb-5">
            {{$data->links()}}
        </div>
    </div>
@endsection
