@extends('layout.master')

<style>
    :root { --primary-light: #e0e7ff; }

    /* Layout & Headers */
    .page-header { max-width: 860px; margin: 2rem auto; text-align: center; position: relative; z-index: 2; }
    .page-header h2 { font-weight: 800; font-size: 2rem; margin-bottom: .5rem; color: #1f2937; }
    .page-subtitle { color: #6b7280; font-size: 1.05rem; }

    .requirements-card { 
        background: #fff; 
        border: 3px dashed var(--primary-light); 
        border-radius: 1.5rem; 
        position: relative; 
        overflow: hidden; 
        transition: transform 0.3s ease; 
    }

    /* Background Icon */
    .watermark-icon { 
        position: absolute; 
        top: -20px; 
        right: -20px; 
        font-size: 15rem; 
        color: var(--primary-color); 
        opacity: 0.03; 
        transform: rotate(15deg); 
        pointer-events: none; 
        z-index: 0; 
    }

    /* Input Styles */
    .form-control-custom { 
        border: 2px solid #f3f4f6; 
        background: #f9fafb; 
        border-radius: 1rem; 
        padding: 0.8rem 1.2rem; 
        font-size: 0.95rem; 
        resize: none; 
        transition: all 0.2s ease; 
    }
    .form-control-custom:focus { 
        background: #fff; 
        border-color: var(--primary-color); 
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.1); 
        transform: translateY(-2px); 
        outline: none; 
    }

    .label-text { font-weight: 700; color: #4b5563; font-size: 0.9rem; margin-bottom: 0.5rem; display: block; }

    /* Radio Button Custom Styling */
    .form-check-input:checked {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }
    .form-check-label {
        font-weight: 600;
        color: #4b5563;
        cursor: pointer;
    }

    /* Trial Section Transition */
    #trial-duration-wrapper {
        transition: all 0.3s ease-in-out;
        overflow: hidden;
    }
    .hidden-wrapper {
        max-height: 0;
        opacity: 0;
        margin-top: 0 !important;
    }
    .visible-wrapper {
        max-height: 150px;
        opacity: 1;
        margin-top: 1rem !important;
    }

    /* Dynamic Item Animation */
    .requirement-item { 
        position: relative; 
        z-index: 2; 
        opacity: 0; 
        transform: translateX(-20px); 
        animation: slideInRight 0.4s forwards; 
    }
    @keyframes slideInRight { to { opacity: 1; transform: translateX(0); } }

    /* UI Elements */
    .number-badge { 
        width: 32px; 
        height: 32px; 
        background: var(--primary-color); 
        color: white; 
        border-radius: 50%; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        font-weight: 700; 
        font-size: 0.9rem; 
        box-shadow: 0 4px 6px rgba(13, 110, 253, 0.2); 
        flex-shrink: 0; 
    }

    /* Buttons */
    .btn-delete { 
        width: 42px; 
        height: 42px; 
        border: none; 
        background: #fff1f2; 
        color: #fb7185; 
        border-radius: 12px; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        transition: all 0.2s cubic-bezier(0.34, 1.56, 0.64, 1); 
        cursor: pointer; 
    }
    .btn-delete:hover { background: #e11d48; color: white; transform: scale(1.1) rotate(5deg); box-shadow: 0 4px 10px rgba(225, 29, 72, 0.3); }

    .btn-add { 
        width: 100%; 
        padding: 1rem; 
        border: 2px dashed #cbd5e1; 
        background: #f8fafc; 
        color: #64748b; 
        font-weight: 700; 
        border-radius: 1rem; 
        transition: all 0.2s ease; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        gap: 0.5rem; 
        cursor: pointer; 
    }
    .btn-add:hover { border-color: var(--primary-color); color: var(--primary-color); background: #eff6ff; transform: translateY(-2px); }
</style>

@section('content')
    <div class="container py-5">
        <div class="page-header">
            <h2>Persyaratan Adopsi</h2>
            <p class="page-subtitle">Atur kebijakan masa percobaan dan persyaratan adopsi untuk calon adopter.</p>
        </div>

        <div class="card requirements-card shadow-sm mx-auto" style="max-width: 850px;">
            {{-- <i class="fa-solid fa-paw watermark-icon"></i> --}}

            <div class="card-body p-4 p-md-5 position-relative">
                <form action="{{ route('shelter.tambah.persyaratan.adopsi') }}" method="POST" id="requirementsForm">
                    @csrf
                    
                    <div class="mb-5 pb-4 border-bottom">
                        <label class="label-text fs-5 mb-3"><i class="fa-solid fa-clock-rotate-left me-2"></i>Pengaturan Masa Percobaan</label>
                        
                        <div class="alert p-3 mb-4 rounded-3 d-flex gap-3 align-items-start" style="background-color: #f0f9ff; border: 1px solid #bae6fd; ">
                            <i class="fa-solid fa-circle-info mt-1 fs-5" style="color: var(--primary-color);"></i>
                            <div>
                                <strong class="d-block mb-1" style="color: var(--primary-color);">Apa itu Masa Percobaan?</strong>
                                <p class="m-0 small" style="line-height: 1.5; opacity: 0.9;">
                                    Masa percobaan berfungsi bagi adopter untuk mengenal hewan peliharaan baru mereka dengan lebih baik di lingkungan rumah. Jika adopter merasa tidak cocok atau terjadi hal yang mengharuskan pengembalian, maka adopter dapat mengembalikan hewan langsung ke shelter selama periode ini.
                                </p>
                            </div>
                        </div>

                        <div class="d-flex gap-4 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="has_trial" id="trial_no" value="0" checked>
                                <label class="form-check-label" for="trial_no">
                                    Tidak Ada Masa Percobaan
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="has_trial" id="trial_yes" value="1">
                                <label class="form-check-label" for="trial_yes">
                                    Ada Masa Percobaan
                                </label>
                            </div>
                        </div>

                        <div id="trial-duration-wrapper" class="hidden-wrapper">
                            <label class="label-text">Durasi Masa Percobaan (Minimal 14 Hari)</label>
                            <input type="number" 
                                id="trial_duration"
                                name="trial_duration" 
                                class="form-control form-control-custom" 
                                placeholder="Contoh: 14" 
                                min="14">
                        </div>
                    </div>
                    <label class="label-text fs-5 mb-3">Daftar Persyaratan</label>
                    <div id="requirements-container" class="d-flex flex-column gap-4 mb-5"></div>

                    <button type="button" id="btnAdd" class="btn-add mb-4">
                        <i class="fa-solid fa-plus-circle fs-5"></i> 
                        <span>Tambah Persyaratan Baru</span>
                    </button>

                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center border-top pt-4 gap-3">
                        <div class="text-muted fw-bold small bg-light px-3 py-2 rounded-pill">
                            Total: <span id="count-display" class="text-primary">0</span>/25 Syarat
                        </div>
                        <button type="submit" class="btn btn-primary-color px-5 py-2 rounded-pill fw-bold shadow-sm">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    @if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: @json(session('success')),
                customClass: {
                    icon: 'swal-success-primary',
                    confirmButton: 'btn btn-primary-color',
                },
                buttonsStyling: false,
            })
        });
    </script>
    @endif
    
    @if (session('error'))
    <script>
      document.addEventListener('DOMContentLoaded', () => {
        Swal.fire({
          icon: 'error',
          title: 'Gagal',
          text: @json(session('error')),
        });
      });
    </script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('requirements-container');
            const btnAdd = document.getElementById('btnAdd');
            const countDisplay = document.getElementById('count-display');
            const form = document.getElementById('requirementsForm');
            const maxFields = 25;

            // Trial Section
            const trialRadios = document.getElementsByName('has_trial');
            const trialWrapper = document.getElementById('trial-duration-wrapper');
            const trialInput = document.getElementById('trial_duration');
            
            function toggleTrialInput() {
                let isTrial = document.getElementById('trial_yes').checked;
                if (isTrial) {
                    trialWrapper.classList.remove('hidden-wrapper');
                    trialWrapper.classList.add('visible-wrapper');
                    trialInput.setAttribute('required', 'required');
                } else {
                    trialWrapper.classList.remove('visible-wrapper');
                    trialWrapper.classList.add('hidden-wrapper');
                    trialInput.removeAttribute('required');
                }
            }

            trialRadios.forEach(radio => {
                radio.addEventListener('change', toggleTrialInput);
            });

            // INITIAL DATA LOADING
            const existingData = @json($shelterDatas->persyaratan_adopsi ?? []); 
            (existingData.length ? existingData : ['', '', '']).forEach(text => addField(text));

            const savedDuration = @json($shelterDatas->masa_percobaan ?? null);
            if (savedDuration && savedDuration > 0) {
                document.getElementById('trial_yes').checked = true;
                trialInput.value = savedDuration;
            } else {
                document.getElementById('trial_no').checked = true;
            }
            toggleTrialInput();


            // DYNAMIC REQUIREMENTS LOGIC
            container.addEventListener('click', function(e) {
                const deleteBtn = e.target.closest('.btn-delete');
                if (!deleteBtn) return;

                const item = deleteBtn.closest('.requirement-item');
                
                if (container.children.length <= 1) {
                    return Swal.fire({
                        toast: true, position: 'top-end', icon: 'error',
                        title: 'Minimal 1 syarat harus ada', showConfirmButton: false, timer: 2000
                    });
                }

                item.style.transform = 'scale(0.9) translateY(10px)';
                item.style.opacity = '0';
                setTimeout(() => {
                    item.remove();
                    updateUI();
                }, 200);
            });

            // Logic for Add Button
            btnAdd.addEventListener('click', () => {
                if (container.children.length < maxFields) {
                    addField();
                } else {
                    Swal.fire({ 
                        icon: 'warning', title: 'Ups!', 
                        text: 'Jumlah persyaratan maksimal telah tercapai', 
                        confirmButtonColor: 'var(--primary-color)',
                        customClass: { icon: 'swal-warning-primary', confirmButton: 'btn btn-primary-color' },
                        buttonsStyling: false
                    });
                }
            });

            // Logic for Submit Form
            form.addEventListener('submit', function(e){
                e.preventDefault(); 

                const isTrial = document.getElementById('trial_yes').checked;
                const durationVal = parseInt(trialInput.value);

                if (isTrial && (isNaN(durationVal) || durationVal < 14)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Durasi Tidak Valid',
                        text: 'Jika masa percobaan diaktifkan, durasi minimal harus 14 hari.',
                        confirmButtonText: 'Ok',
                        buttonsStyling: false,
                        customClass: { confirmButton: 'btn btn-primary-color' }
                    });
                    return;
                }

                Swal.fire({
                    icon: 'question',
                    title: 'Simpan Perubahan?',
                    text: 'Apakah anda yakin memperbarui daftar persyaratan adopsi?',
                    showCancelButton: true,
                    confirmButtonText: 'Yakin',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    buttonsStyling: false,
                    customClass: {
                        icon: 'swal-question-primary',
                        confirmButton: 'btn btn-primary-color',
                        cancelButton: 'btn btn-kembali me-2'
                    }
                }).then((result) =>{
                    if(result.isConfirmed){
                        form.submit();
                    }
                });
            });

            // Helper Functions
            function addField(value = '') {
                const index = container.children.length + 1;
                const wrapper = document.createElement('div');
                wrapper.className = 'requirement-item d-flex align-items-start gap-3';
                
                wrapper.innerHTML = `
                    <div class="number-badge mt-2">${index}</div>
                    <div class="flex-grow-1">
                        <label class="label-text">Poin Syarat ke-<span class="index-text">${index}</span></label>
                        <textarea name="requirements[]" class="form-control form-control-custom" 
                            placeholder="Contoh: Wajib mengirimkan foto update bulanan" rows="2" required>${value}</textarea>
                    </div>
                    <button type="button" class="btn-delete mt-4" aria-label="Hapus">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                `;
                container.appendChild(wrapper);
                updateUI();
            }

            function updateUI() {
                [...container.children].forEach((item, i) => {
                    const idx = i + 1;
                    item.querySelector('.number-badge').textContent = idx;
                    item.querySelector('.index-text').textContent = idx;
                });

                const total = container.children.length;
                countDisplay.textContent = total;

                const isMax = total >= maxFields;
                btnAdd.style.opacity = isMax ? '0.6' : '1';
                btnAdd.style.cursor = isMax ? 'not-allowed' : 'pointer';
                btnAdd.innerHTML = isMax 
                    ? '<i class="fa-solid fa-ban"></i> <span>Batas Maksimal Tercapai</span>'
                    : '<i class="fa-solid fa-plus-circle fs-5"></i> <span>Tambah Persyaratan Baru</span>';
            }
        });
    </script>
@endsection