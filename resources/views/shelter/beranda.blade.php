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
        max-width: 1355px;
        margin: 0 auto 24px; 
        text-align: left;
        margin: 0 auto 24px;

    }
    
    .hero{
        margin: 0 auto; 
        width: 100%;
        padding: 24px 32px;
        border-radius: 1rem;
        background: white;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
                min-height: 180px;
    }

    .hero-title {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 600px;
    font-size: 1.8rem;
    font-weight: bold;
    line-height: 1.3;
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

   .hero-card {
        min-height: 180px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 2rem 1.5rem;
    }



    .hero-card .btn-outline-light {
        background: rgba(255,255,255,0.15);
        border-color: white !important;
        color: white !important;
        backdrop-filter: blur(10px);
    }

    .hero-card .btn-outline-light:hover {
        background: rgba(255,255,255,0.25) !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(255,255,255,0.2);
    }

    .hero-card .btn-primary {
        background: var(--primary-color);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
    }

    .hero-card .btn-primary:hover {
        /* background: #255cb5; */
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(44, 106, 222, 0.4);
    }
</style>

@section('content')

    <div class="container py-5">
        <div class="hero-wrap col-12">
            <div class="hero-card position-relative overflow-hidden rounded-4 shadow-sm" 
                style="background: linear-gradient(135deg, #2c6ade, #71dff7); padding: 2rem 1.5rem;">

                <!-- Gradient Overlay for Text Readability -->
                <div class="position-absolute top-0 start-0 w-100 h-100 opacity-80" 
                    style="background: linear-gradient(to bottom, rgba(0,0,0,0.1), transparent);"></div>

                <div class="hero-content position-relative z-2 d-flex flex-column align-items-start justify-content-center gap-2">
                    <h2 class="text-white fw-bold mb-0 lh-base" style="font-size: 1.8rem; max-width: 600px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                        Selamat Datang, {{ $shelterDatas->nama_shelter }}!
                    </h2>
                    <p class="text-white opacity-90 mb-0" style="font-size: 1.1rem; max-width: 600px; line-height: 1.5;">
                        Kelola data hewan Anda di sini. Gunakan tombol di kanan untuk melihat semua daftar hewan dan menambah hewan baru.
                    </p>
                </div>

                <div class="hero-actions position-relative z-2 d-flex gap-3 ms-auto">
                    <a href="{{ route('shelter.data.hewan') }}" class="btn btn-outline-light btn-lg px-4 py-2 rounded-pill fw-semibold" style="transition: all 0.3s ease; border-width: 2px;">
                        Lihat Semua Hewan
                    </a>
                    <a href="{{ route('shelter.tambahHewan') }}" class="btn btn-primary btn-lg px-4 py-2 rounded-pill fw-semibold" style="transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(44, 106, 222, 0.3);">
                        + Tambah Hewan
                    </a>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end ms-3 ">
            {{-- <a href="{{ route('shelter.data.hewan') }}" class="align-self-center px-5;">
                Lihat Semua Hewan
            </a>
            <a href="{{ route('shelter.tambahHewan') }}">
                <button type="button" class="btn btn-primary primary-color me-3" style="color: white">+ Tambah Hewan</button>
            </a> --}}
        </div>

        <div class="row row-cols-5 g-3">
            @foreach ($dataHewan as $hewan)
             @php
                $isDog = str_contains($hewan->jenis_hewan, 'anjing');
                $isCat = str_contains($hewan->jenis_hewan, 'kucing');
            @endphp
            <div class="col py-3 d-flex justify-content-center">
                <div class="card h-100 bg-white shadow-sm">

                    <img src="{{ asset($hewan->foto_hewan) }}" class="card-img-top" alt="{{ $hewan->nama_hewan }}" style="height:200px;">

                    <div class="card-body d-flex flex-column text-center">
                        <h5 class="card-title mb-3" style="display: flex; justify-content: center; align-items: center; gap: 0.4rem;">
                            {{ $hewan->nama_hewan }}
                            <i class="fa-solid {{ $isDog ? 'fa-bone' : 'fa-paw' }}"></i>
                        </h5>
                        <a href="{{ route('shelter.detail.hewan', $hewan->id) }}" class="btn-primary-color" style="text-decoration:none; text-align: center;">Lihat Detail</a>
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