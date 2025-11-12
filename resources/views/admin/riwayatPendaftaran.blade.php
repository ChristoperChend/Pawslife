<style>
    .shelter-card-item {
        border-radius: 12px;
        transition: box-shadow 0.3s ease;
        border: 1px solid #dee2e6;
    }

    .shelter-card-item:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
    }

    .foto-shelter {
        flex: 0 0 120px;
        height: 150px;
        overflow: hidden;
    }

    .foto-shelter img {
        width: 100%;
        height: 100%;
        border-radius: 12px;
    }

    .shelter-nama {
        font-size: 1.3rem;
        color: #343a40;
    }

    .shelter-email {
        font-size: 1rem;
        color: #343a40;
    }

    .status-label {
        font-size: 0.9rem;
        color: #6c757d;
    }

    .garis-vertikal-riwayat {
        width: 1px;
        height: 80px;
        background-color: #e9ecef;
    }

    .status-badge {
        font-size: 1rem !important;
        padding: 0.5em 1em !important;
        font-weight: 600 !important;
        min-width: 120px !important;
        display: inline-block !important;
    }
</style>

@extends('layout.master')

@section('content')
    <div class="container py-5">
        <div class="text-atas mb-5">
            <h1 class="fw-bold text-center">Riwayat Pendaftaran Shelter</h1>
            <hr>
        </div>

        @if (!$shelter->isEmpty())
            @foreach ($shelter as $items)
                <div class="card shelter-card-item shadow-lg mb-4">
                    <div class="d-flex p-3 p-md-4">
                        <div class="foto-shelter me-4 me-md-5">
                            <img src="{{ asset('storage/' . $items->foto_shelter) }}" alt="Foto shelter">
                        </div>
                        
                        <div class="flex-grow-1">
                            <p class="mb-0 text-muted small status-label">Nama Shelter</p>
                            <h5 class="fw-bold mb-3 shelter-nama">{{ $items->nama_shelter }}</h5>
                            
                            <p class="mb-0 text-muted small status-label">Email Shelter</p>
                            <h6 class="fw-bold shelter-telepon">{{ $items->pengguna->email }}</h6>
                        </div>

                        <div class="d-flex align-items-center ms-auto info-status-wrapper">
                            <div class="garis-vertikal-riwayat me-4 d-none d-md-block"></div>

                            <div class="text-end status-section">
                                <p class="fw-bold mb-2 status-label">Status Pendaftaran</p>

                                <span class="badge status-badge {{ 
                                    $items->status == 'Diterima' ? 'text-bg-success' : 
                                    ($items->status == 'Ditolak' ? 'text-bg-danger' : 
                                    'text-bg-warning') 
                                }}">
                                    {{ $items->status }}
                                </span>
                                
                                {{-- @if ($items->status_pengajuan == "Masa percobaan")
                                    @php
                                        $updatedAt = \Carbon\Carbon::parse($items->updated_at);
                                        $totalHoursPassed = $updatedAt->diffInHours(now());
                                        $daysPassed = floor($totalHoursPassed / 24); 
                                        $daysRemaining = 7 - $daysPassed;
                                        $daysRemainingDisplay = max(0, $daysRemaining); 
                                    @endphp
                                    <h6 class="fw-bold">
                                            Masa Percobaan Sisa {{ $daysRemainingDisplay }} hari
                                            <i 
                                                class="fa-solid fa-circle-info tooltip-info"
                                                data-bs-toggle="tooltip" 
                                                data-bs-placement="top" 
                                                title="Jika masa percobaan sudah selesai, hewan akan otomatis diadopsi."
                                            ></i>
                                    </h6>
                                    <div class="d-flex gap-2 justify-content-end">
                                        <button 
                                            type="button" 
                                            class="btn btn-outline-danger btn-sm riwayat-btn-aksi" 
                                            onclick="kembalikanHewan({{ $items->hewan->id }})"
                                        >
                                            Kembalikan
                                        </button>
                                        <button 
                                            type="button" 
                                            class="btn btn-success btn-sm riwayat-btn-aksi" 
                                            onclick="adopsiHewan({{ $items->hewan->id }})"
                                        >
                                            Adopsi
                                        </button>
                                    </div>
                                @else
                                    <span class="badge status-badge {{ 
                                        $items->status_pengajuan == 'Diadopsi' ? 'text-bg-success' : 
                                        ($items->status_pengajuan == 'Dikembalikan' ? 'text-bg-danger' : 
                                        'text-bg-warning') 
                                    }}">
                                        {{ $items->status_pengajuan }}
                                    </span>
                                @endif --}}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <h4 class="d-flex justify-content-center align-items-center w-100">Tidak ada riwayat pendaftaran shelter</h4>
        @endif
    </div>

    @include('layout.loading')


@endsection
