<style>
    .shelter-container {
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
    }

    .shelter-container h5,
    .shelter-container h6 {
        margin: 2px;
        color: white;
        padding-left: 10px;
    }

    .daftar-shelter {
        width: 250px;
        height: 200px;
    }
</style>

@extends('layout.master')

@section('content')
    <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 justify-content-start">
            @foreach ($listShelter as $shelter)
                <a href="" class="col d-flex justify-content-center text-decoration-none">
                    <div class="shelter-container cursor secondary-color">
                        <img src="{{ asset('storage/' . $shelter->foto_shelter) }}" class="daftar-shelter">
                        <h5 class="pt-2">{{ $shelter->nama_shelter ?? '-' }}</h5>
                        <h6 class="fw-bold mb-3">{{ $shelter->alamat_shelter ?? '-' }}</h6>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="d-flex justify-content-center mt-4"> {{ $listShelter->links() }}
    </div>
@endsection
