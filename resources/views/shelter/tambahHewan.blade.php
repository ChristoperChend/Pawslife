@extends('layout.master')
<style>
        /* Add custom styling for form inputs */
    .form-control {
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .form-select{
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        transition: all 0.3s ease;
        
    }

    .form-select:focus {
        transform: scale(1.02);
    }


    .form-control:focus {
        transform: scale(1.02);
    }

    form {
        padding: 30px;
        background-color: #f9f9f9;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        max-width: 750px;
        margin: 30px auto;
        border: 2px solid #f1f1f1;
        transition: all 0.3s ease;
    }
    
</style>
@section('content')
    <div class="container py-5">
        <div style="text-align: center">
            <h2 style="font-weight: bold">
                Form Penambahan Hewan
            </h2>
        </div>
        <form action="{{ route('shelter.tambahHewanPost') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="namaHewan" class="form-label">Nama Hewan <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="namaHewan" name="namaHewan" placeholder="Masukkan nama hewan" value="{{ old('namaHewan') }}">
                @error('namaHewan')
                     <small class="text-danger fs-7">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="jenisHewan" class="form-label">Jenis Hewan<span class="text-danger">*</span></label>
                <select class="form-select" name="jenisHewan" id="jenisHewan"  >
                    <option value="" disabled selected hidden>Pilih Jenis Hewan</option>
                    <option value="anjing" {{old('jenisHewan') === 'anjing' ? 'selected' : ''}}>Anjing</option>
                    <option value="kucing" {{old('jenisHewan') === 'kucing' ? 'selected' : ''}}>Kucing</option>
                </select>
                @error('jenisHewan')
                     <small class="text-danger fs-7">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="jeniskelaminHewan" class="form-label">Jenis Kelamin Hewan <span class="text-danger">*</span></label>
                <select class="form-select" name="jenisKelaminHewan" id="jenisKelaminHewan">
                    <option value="" disabled selected hidden>Masukkan Jenis Kelamin Hewan</option>
                    <option value="jantan"  {{old('jenisKelaminHewan') === 'jantan' ? 'selected' : ''}}>Jantan</option>
                    <option value="betina"  {{old('jenisKelaminHewan') === 'betina' ? 'selected' : ''}}>Betina</option>
                </select>
                @error('jeniskelaminHewan')
                     <small class="text-danger fs-7">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="statusVaksinHewan" class="form-label">Status Vaksin Hewan <span class="text-danger">*</span></label>
                <select class="form-select" name="statusVaksinHewan" id="statusVaksinHewan">
                    <option value="" disabled selected hidden>Masukkan Status Vaksin Hewan</option>
                    <option value="sudahVaksin"  {{old('statusVaksinHewan') === 'sudahVaksin' ? 'selected' : ''}}>Sudah di Vaksin</option>
                    <option value="belumVaksin"{{old('statusVaksinHewan') === 'belumVaksin' ? 'selected' : ''}}>Belum di Vaksin</option>
                </select>
                @error('statusVaksinHewan')
                     <small class="text-danger fs-7">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="statusSterilHewan" class="form-label">Status Steril Hewan <span class="text-danger">*</span></label>
                <select class="form-select" name="statusSterilHewan" id="statusSterilHewan">
                    <option value="" disabled selected hidden>Masukkan Status Vaksin Hewan</option>
                    <option value="sudahSteril" {{old('statusSterilHewan') === 'sudahSteril' ? 'selected' : ''}}>Sudah Streril</option>
                    <option value="belumSteril" {{old('statusSterilHewan') === 'belumSteril' ? 'selected' : ''}}>Belum Steril</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="beratHewan" class="form-label">Berat Hewan <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="beratHewan" name="beratHewan" placeholder="Masukkan Berat Hewan">
                @error('beratHewan')
                     <small class="text-danger fs-7">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="rasHewan" class="form-label">Ras Hewan <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="rasHewan" name="rasHewan" placeholder="Masukkan Ras Hewan">
            </div>
            <div class="mb-3">
                <label for="catatanMedisHewan" class="form-label">Catatan Medis</label>
                <input type="text" class="form-control" id="catatanMedisHewan" name="catatanMedisHewan" placeholder="Masukkan Catatan Medis Hewan">
            </div>
            <div class="mb-3">
                <label for="fotoHewan" class="fotoHewan">Foto Hewan <span class="text-danger">*</span></label>
                <input type="file" class="form-control" id="fotoHewan" name="fotoHewan" accept="image/*">
                @error('fotoHewan')
                     <small class="text-danger fs-7">{{ $message }}</small>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            
        </form>
    </div>
@endsection