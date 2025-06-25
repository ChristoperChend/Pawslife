<style>
    .hewan-container {
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
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
</style>

@extends('layout.master')

@section('content')
    <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 justify-content-start">
            @foreach ($listHewan as $hewan)
                <a href="{{ route('adopter.detailHewan', ['id' => $hewan->id]) }}" class="col d-flex justify-content-center text-decoration-none">
                    <div class="hewan-container cursor secondary-color">
                        <img src="{{ asset('storage/' . $hewan->foto_hewan) }}" class="daftar-hewan">
                        <h5 class="pt-2">{{ $hewan->nama_hewan ?? '-' }}</h5>
                        <h6 class="fw-bold mb-3">{{ $hewan->ras ?? '-' }}</h6>
                        <h6>{{ $hewan->status_steril ?? '-' }} | {{ $hewan->status_vaksin ?? '-' }}</h6>
                        <h6 class="pb-2">{{ $hewan->shelter->nama_shelter ?? '-' }}</h6>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="d-flex justify-content-center mt-4"> {{ $listHewan->links() }}
    </div>
@endsection
