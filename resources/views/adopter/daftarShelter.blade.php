<style>
    .shelter-container {
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
    }

    .shelter-container h5,
    .shelter-container h6 {
        margin: 2px;
        color: black;
        padding-left: 10px;
    }

    .daftar-shelter {
        width: 250px;
        height: 200px;
    }

    h4 {
        min-height: 240px;
    }
</style>

@extends('layout.master')

@section('content')
    <div class="container py-5">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 justify-content-start">
            @if (!$listShelter->isEmpty())
                @foreach ($listShelter as $shelter)
                    <a href="" class="col d-flex justify-content-center text-decoration-none">
                        <div class="card shelter-container shadow-sm">
                            <img src="{{ asset('storage/' . $shelter->foto_shelter) }}" class="daftar-shelter">
                            <h5 class="pt-2">{{ $shelter->nama_shelter ?? '-' }}</h5>
                            <h6 class="fw-bold mb-3">{{ $shelter->alamat_shelter ?? '-' }}</h6>
                        </div>
                    </a>
                @endforeach
            @else
                <h4 class="d-flex justify-content-center align-items-center w-100">Tidak ada daftar shelter</h4>
            @endif
        </div>
        <div class="d-flex justify-content-center mt-4"> {{ $listShelter->links() }}
    </div>
@endsection
