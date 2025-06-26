<style>
    .hewan-container {
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
        position: relative;
    }

    .hewan-container h5,
    .hewan-container h6 {
        margin: 2px;
        color: white;
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
        color: #fff;
        font-size: 28px;
        z-index: 2;
        cursor: pointer;
        transition: color 0.2s;
    }

    .heart-icon.liked {
        color: #e74c3c;
    }

    h4 {
        min-height: 264px;
    }
</style>

@extends('layout.master')

@section('content')

    <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 justify-content-start">
            @if (!$listFavorit->isEmpty())
            @foreach ($listFavorit as $favorit)
                <div class="col d-flex justify-content-center">
                    <div class="hewan-container secondary-color">
                        <span class="heart-icon {{ in_array($favorit->hewan->id, $favoritHewanIds) ? 'liked' : '' }}" onclick="toggleHeart(this, {{ $favorit->hewan->id }})">
                            <i class="{{ in_array($favorit->hewan->id, $favoritHewanIds) ? 'fa-solid' : 'fa-regular' }} fa-heart fa-xl"></i>
                        </span>
                        <img src="{{ asset('storage/' . $favorit->hewan->foto_hewan) }}" class="daftar-hewan">
                        <a href="{{ route('adopter.detailHewan', ['id' => $favorit->hewan->id]) }}" class="text-decoration-none">
                            <h5 class="pt-2">{{ $favorit->hewan->nama_hewan ?? '-' }}</h5>
                            <h6 class="fw-bold mb-3">{{ $favorit->hewan->ras ?? '-' }}</h6>
                            <h6>{{ $favorit->hewan->status_steril ?? '-' }} | {{ $favorit->hewan->status_vaksin ?? '-' }}</h6>
                            <h6 class="pb-2">{{ $favorit->hewan->shelter->nama_shelter ?? '-' }}</h6>
                        </a>
                    </div>
                </div>
            @endforeach
            @else
                <h4 class="d-flex justify-content-center align-items-center w-100">Tidak ada daftar favorit</h4>
            @endif
        </div>
        <div class="d-flex justify-content-center mt-4"> {{ $listFavorit->links() }}
    </div>

    <script>
        function toggleHeart(el, hewanId) {
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
                const icon = el.querySelector('i');
                if (res.status === 'added') {
                    icon.classList.remove('fa-regular');
                    icon.classList.add('fa-solid');
                    el.classList.add('liked');
                } else {
                    icon.classList.remove('fa-solid');
                    icon.classList.add('fa-regular');
                    el.classList.remove('liked');
                }
            });
        }
    </script>
@endsection