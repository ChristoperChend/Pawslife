@extends('layout.master')
<style>
    .hero-wrap{
        border-bottom: 1px solid var(--line);
    }
    .hero{
        margin: 0 auto; padding: 36px 12px 18px;
    }

    .card {
        background-color: #ffffff;
        border: 1px solid #dee2e6;
        border-radius: 0.5rem;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        min-height: 300px;
        width: 250px;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.2);
    }

    .card-img-top {   
        object-fit: cover;   
    }
</style>

@section('content')

    <div class="container py-5">
         <div class="hero-wrap">
            <div class="hero">
                <h3 class="mb-1">Selamat Datang, Shelter {{ $shelterDatas->nama_shelter }}!</h3>
                <p>Kelola data hewan Anda di sini. Gunakan tombol di kanan untuk menambah hewan baru.</p>
            </div>
        </div>

        <div class="d-flex justify-content-between ms-3 ">
            <a href="{{ route('shelter.tambahHewan') }}" class="align-self-center px-5;">
                Lihat Semua >>
            </a>
            <a href="{{ route('shelter.tambahHewan') }}">
                <button type="button" class="btn btn-outline-primary me-3">+ Tambah Hewan</button>
            </a>
        </div>

        <div class="row row-cols-5 g-3">
            @foreach ($dataHewan as $hewan)
            <div class="col py-3">
                <div class="card h-100 bg-white shadow-sm">

                    <img src="{{ asset($hewan->foto_hewan) }}" class="card-img-top" alt="{{ $hewan->nama_hewan }}" style="height:200px;">

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title  d-flex align-items-center gap-2">
                            {{ ucfirst($hewan->nama_hewan) }}

                            {{-- jenis_hewan badge --}}
                            <span class="badge " style="height: 18px; font-size: 10px; background-color: rgb(0, 23, 126);">
                                {{ ucfirst($hewan->jenis_hewan) }}
                            </span>

                            {{-- jenis_kelamin icon --}}
                            @if ($hewan->jenis_kelamin === 'jantan')
                                <i class="fa-solid fa-mars" aria-label="Jantan"  style="font-size: 18px; color: rgb(0, 101, 252);"></i>
                            @elseif ($hewan->jenis_kelamin === 'betina')
                                <i class="fa-solid fa-venus" aria-label="Betina" style="font-size: 18px; color: rgb(255, 32, 107);"></i>
                            @endif
                        </h5>
                        <p class="card-text text-muted mb-2">Berat: {{ $hewan->berat }} kg</p>
                        <a href="#" class="btn btn-sm btn-outline-primary mt-auto">Lihat Detail</a>
                    </div>
                </div>
                </div>
            @endforeach
        </div>
    </div>

        
    </div>

@endsection

@if (session('success'))
<script>
  document.addEventListener('DOMContentLoaded', () => {
    Swal.fire({
      toast: true,
      position: 'top-end',
      icon: 'success',
      title: @json(session('success')),
      showConfirmButton: false,
      timer: 2200,
      timerProgressBar: true
    });
  });
</script>
@endif