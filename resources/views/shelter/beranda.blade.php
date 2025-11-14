@extends('layout.master')
<style>
    .page-header {
        max-width: 960px;
        margin: 24px auto 0;
        text-align: center;
    }
    
    .hero h2{
        font-weight: 800;
        letter-spacing: .3px;
    }
    
    .page-subtitle{
        color: #6b7280;
        font-size: .95rem;
    }

    .hero-wrap{
        max-width: 960px;
        text-align: left;
        margin: 0 auto 24px;
    }
    
    .hero{
        margin: 0 auto; 
        padding: 24px 32px;
        border-radius: 1rem;
        background: white;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
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

    .btn-primary{
        background: var(--primary-color);
        color: #fff;
        border: none !important;
        border-width: 0 !important;
        min-width: 100px;
        border-radius: 50px;
        font-weight: 600;
        padding: 10px 24px;
    }

    .btn-primary:hover{
        transform: translateY(-1px);
        filter: saturate(1.05);
        color: var(--primary-color);
        box-shadow:
            0 10px 22px rgba(96,165,250,.30);
    }
    
    .btn-light {
        background: white;
        color: #2c6ade;
        border: 2px solid #2c6ade;
        border-radius: 50px;
        font-weight: 600;
        padding: 10px 24px;
    }
    
    .btn-light:hover {
        background: #f8fafc;
        border-color: #2c6ade;
        transform: translateY(-1px);
        box-shadow: 0 10px 22px rgba(96,165,250,.30);
    }
</style>

@section('content')

    <div class="container py-5">
         <div class="hero-wrap">
    <div class="hero d-flex align-items-center justify-content-between py-4 px-3" style="background: linear-gradient(135deg, #f2994a, #6dd5ed, #2193b0); border-radius: 1rem; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
        <div class="hero-content">
            <h2 class="mb-2 text-white" style="font-weight: 800; font-size: 2.2rem; letter-spacing: -0.5px;">Selamat Datang, Shelter {{ $shelterDatas->nama_shelter }}!</h2>
            <p class="page-subtitle text-white opacity-90 mb-0" style="font-size: 1.1rem; max-width: 600px;">
                Kelola data hewan Anda di sini. Gunakan tombol di kanan untuk menambah hewan baru.
            </p>
        </div>
        <div class="hero-actions">
            <a href="{{ route('shelter.data.hewan') }}" class="btn btn-light btn-lg me-3" style="border-radius: 50px; font-weight: 600; padding: 10px 24px;">
                Lihat Semua >>
            </a>
            <a href="{{ route('shelter.tambahHewan') }}">
                <button type="button" class="btn btn-primary btn-lg" style="border-radius: 50px; font-weight: 600; padding: 10px 24px; background: #2c6ade; border: none;">
                    + Tambah Hewan
                </button>
            </a>
        </div>
    </div>
</div>

        <div class="d-flex justify-content-between ms-3 ">
            <a href="{{ route('shelter.data.hewan') }}" class="align-self-center px-5;">
                Lihat Semua >>
            </a>
            <a href="{{ route('shelter.tambahHewan') }}">
                <button type="button" class="btn btn-primary primary-color me-3" style="color: white">+ Tambah Hewan</button>
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
                        <a href="{{ route('shelter.detail.hewan', $hewan->id) }}" class="btn btn-sm btn-outline-primary mt-auto">Lihat Detail</a>
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