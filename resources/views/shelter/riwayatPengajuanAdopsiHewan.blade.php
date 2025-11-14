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
                    <img src="{{ asset($item->hewan->foto_hewan) }}" 
                         alt="Foto Hewan"
                         class="rounded"
                         style="width:100px; height:100px; object-fit:cover; background:#e5e7eb;">
                </div>

                <div class="flex-fill p-3 border-end d-flex flex-column justify-content-center bg-white">
                    <h5 class="fw-bold mb-1">{{ $item->hewan->nama_hewan ?? 'Nama tidak tersedia' }}</h5>
                    <p class="mb-0 text-muted">Jenis hewan: {{ Str::ucfirst($item->hewan->jenis_hewan ?? '-') }}</p>
                </div>

                
                <div class="p-3 d-flex flex-column justify-content-between bg-white" style="min-width:200px;">
                    <div>
                        <h6 class="fw-bold mb-2">Status</h6>
                        @if($item->status_pengajuan == 'setuju')
                            <div 
                                class="d-inline-flex flex-column align-items-center justify-content-center fw-semibold text-center"
                                style="
                                    background-color: #e8f0fe;
                                    color: #1967d2;
                                    border-radius: 6px;
                                    font-size: 0.9rem;
                                    padding: 6px 12px;
                                    min-width: 170px;
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
                        @elseif($item->status_pengajuan == 'tolak')
                            <span 
                                class="d-inline-flex align-items-center fw-semibold"
                                style="
                                    background-color: #e8f0fe;
                                    color: #1967d2;
                                    border-radius: 6px;
                                    font-size: 0.9rem;
                                    padding: 4px 10px;
                                    min-width: 170px;
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
                                    min-width: 170px;
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
                                    min-width: 170px;
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
@endsection
