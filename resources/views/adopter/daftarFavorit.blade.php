<style>
    .hewan-container {
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
        position: relative;
    }

    .hewan-container h5,
    .hewan-container h6 {
        margin: 2px;
        color: black !important;
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

    h4 {
        min-height: 264px;
    }

    #jenis-hewan:focus,
    #jenis-kelamin-hewan:focus {
        border-color: white !important;
    }

    #jenis-hewan {
        min-width: 150px;
    }

    #jenis-kelamin-hewan {
        min-width: 230px;
    }
    #jenis-hewan-text, #jenis-kelamin-hewan-text {
        display: inline-block;
        min-width: 90px;
        text-align: left;
    }
</style>

@extends('layout.master')

@section('content')

    <div class="container py-5">
        <div class="d-flex justify-content-center mb-4">
            <div class=" border border-2 rounded">
                <div class="btn-group align-items-center">
                    <button class="btn" type="button" id="jenis-hewan" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span id="jenis-hewan-text">Jenis hewan</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-start" id="jenis-hewan-dropdown">
                        <a class="dropdown-item" data-value="kucing">Kucing</a>
                        <a class="dropdown-item" data-value="anjing">Anjing</a>
                    </div>
                    |
                    <button class="btn" type="button" id="jenis-kelamin-hewan" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span id="jenis-kelamin-hewan-text">Jenis kelamin hewan</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-start" id="jenis-kelamin-hewan-dropdown">
                        <a class="dropdown-item" data-value="jantan">Jantan</a>
                        <a class="dropdown-item" data-value="betina">Betina</a>
                    </div>
                    
                    <i class="fa-solid fa-magnifying-glass me-3 cursor" onclick="searchHewan()"></i>
                </div>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 justify-content-start">
            @if (!$listFavorit->isEmpty())
            @foreach ($listFavorit as $favorit)
                <div class="col d-flex justify-content-center">
                    <div class="card hewan-container shadow-sm">
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

    @include('layout.loading')

    <script>
        let selectedJenisHewan = '';
        let selectedJenisKelamin = '';

        document.querySelectorAll('#jenis-hewan-dropdown .dropdown-item').forEach(function(item) {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                document.getElementById('jenis-hewan-text').textContent = this.textContent;
                selectedJenisHewan = this.getAttribute('data-value');
            });
        });

        document.querySelectorAll('#jenis-kelamin-hewan-dropdown .dropdown-item').forEach(function(item) {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                document.getElementById('jenis-kelamin-hewan-text').textContent = this.textContent;
                selectedJenisKelamin = this.getAttribute('data-value');
            });
        });

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
                    .then(() => {
                        location.reload();
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
                    .then(() => {
                        location.reload();
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

        function searchHewan() {
            document.getElementById('fullscreen-loading').classList.remove('d-none')
            var params = [];
            if (selectedJenisHewan) params.push('jenis_hewan=' + encodeURIComponent(selectedJenisHewan));
            if (selectedJenisKelamin) params.push('jenis_kelamin=' + encodeURIComponent(selectedJenisKelamin));
            var url = '{{ route('adopter.daftarFavorit') }}';
            if (params.length > 0) url += '?' + params.join('&');
            window.location.href = url;
        }
    </script>
@endsection