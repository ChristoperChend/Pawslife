<style>
    .shelter-image {
        width: 600px;
        height: 450px !important;
        border-radius: 10px;
        margin-bottom: 1.5rem;
    }

    .hewan-container {
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
        position: relative;
    }

    .hewan-container h5,
    .hewan-container h6 {
        margin: 2px;
        color: black;
        padding-left: 10px;
    }

    .daftar-hewan {
        width: 250px;
        height: 200px;
    }

    .heart-icon {
        position: absolute;
        top: 25px;
        right: 7px;
        color: black;
        font-size: 28px;
        z-index: 2;
        cursor: pointer;
        transition: color 0.2s;
    }

    .heart-icon.liked {
        color: #ff0000;
    }

    .detail-row div h5 {
        margin-bottom: 0px;
        font-weight: normal !important;
        font-size: 18px;
        margin-bottom: 5px;
    }

    .detail-row {
        margin-bottom: 15px;
    }

    .detail-row label {
        margin-bottom: 0;
        color: black !important;
        background: white !important;
    }
</style>

@extends('layout.master')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-12 col-md-6 text-center">
                <img src="{{ asset('storage/' . $detailShelter->foto_shelter) }}" class="shelter-image img-fluid" alt="Adopter Image">
            </div>

            <div class="col-12 col-md-6">
                <div class="row detail-row">
                    <div class="col-12">
                        <h5>Nama shelter</h5>
                        <label class="border shadow-sm w-100 p-2 text-white rounded-2 mb-3 position-relative">
                            <span>{{ $detailShelter->nama_shelter ?? 'data tidak ada' }}</span>
                        </label>
                    </div>
                </div>

                <div class="row detail-row">
                    <div class="col-12">
                        <h5>No telepon</h5>
                        <label class="border shadow-sm w-100 p-2 text-white rounded-2 mb-3 position-relative">
                            <span>{{ $detailShelter->no_telepon_shelter ?? 'data tidak ada' }}</span>
                        </label>
                    </div>
                </div>

                <div class="row detail-row">
                    <div class="col-12">
                        <h5>Alamat</h5>
                        <label class="border shadow-sm w-100 p-2 text-white rounded-2 mb-3 position-relative">
                            <span>{{ $detailShelter->alamat_shelter ?? 'data tidak ada' }}</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div>
            <h2 class="fw-bold text-center">List Hewan {{ $detailShelter->nama_shelter }}</h2>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 justify-content-start">
                @if (!$listHewan->isEmpty())
                @foreach ($listHewan as $hewan)
                    <div class="col d-flex justify-content-center">
                        <div class="card hewan-container shadow-sm">
                            <span class="heart-icon {{ in_array($hewan->id, $favoritHewanIds) ? 'liked' : '' }}" onclick="toggleHeart(this, {{ $hewan->id }})">
                                <i class="{{ in_array($hewan->id, $favoritHewanIds) ? 'fa-solid' : 'fa-regular' }} fa-heart fa-xl"></i>
                            </span>
                            <img src="{{ asset('storage/' . $hewan->foto_hewan) }}" class="daftar-hewan">
                            <a href="{{ route('adopter.detailHewan', ['id' => $hewan->id]) }}" class="text-decoration-none">
                                <h5 class="pt-2">{{ $hewan->nama_hewan ?? '-' }}</h5>
                                <h6 class="fw-bold mb-3">{{ $hewan->ras ?? '-' }}</h6>
                                <h6>{{ $hewan->status_steril ?? '-' }} | {{ $hewan->status_vaksin ?? '-' }}</h6>
                                <h6 class="pb-2">{{ $hewan->shelter->nama_shelter ?? '-' }}</h6>
                            </a>
                        </div>
                    </div>
                @endforeach
                @else
                    <h4 class="d-flex justify-content-center align-items-center w-100">Tidak ada daftar hewan</h4>
                @endif
            </div>

            @if (!$listHewan->isEmpty())
                <div class="text-end mt-4">
                    <a href="{{ route('adopter.daftarHewan', ['shelter_id' => $detailShelter->id]) }}" class="text-decoration-none cursor fw-bold text-black" style="font-size: 18px;">
                        Lihat semua 
                        <i class="fa-solid fa-chevron-right fa-2xs" style="color: #000000;"></i>
                    </a>
                </div>
            @endif
        </div>
    </div>

    @extends('layout.loading')

    <script>
        function toggleHeart(el, hewanId) {
            document.getElementById('fullscreen-loading').classList.remove('d-none')
            fetch("{{ route('adopter.tambahFavorit') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ hewan_id: hewanId })
            })
            .then(res => res.json())
            .then(res => {
                document.getElementById('fullscreen-loading').classList.add('d-none')
                const icon = el.querySelector('i');
                if (res.status === 'added') {
                    Swal.fire({
                        icon: 'success',
                        title: res.title,
                        text: res.message
                    })
                    icon.classList.remove('fa-regular');
                    icon.classList.add('fa-solid');
                    el.classList.add('liked');
                } else if (res.status === 'removed') {
                    Swal.fire({
                        icon: 'success',
                        title: res.title,
                        text: res.message
                    })
                    icon.classList.remove('fa-solid');
                    icon.classList.add('fa-regular');
                    el.classList.remove('liked');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: res.title,
                        text: res.message
                    })
                }
            });
        }
    </script>
@endsection