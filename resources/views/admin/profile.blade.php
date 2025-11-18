<style>
    .detail-label {
        font-size: 0.95rem;
        font-weight: 500 !important;
        color: #495057 !important;
    }

    .detail-field-wrapper {
        display: flex;
        align-items: center;
        justify-content: space-between;
        border: 1px solid #cacaca;
        border-left: 5px solid var(--primary-color);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        border-radius: 8px;
        padding: 10px 15px;
        position: relative;
        transition: all 0.2s ease;
    }

    .detail-field-wrapper:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
    }

    .detail-text {
        flex-grow: 1;
        color: #212529; 
        font-size: 1rem;
        font-weight: 600;
    }

    .profile-icon {
        font-size: 300px;
        color: #adb5bd;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 50px;
    }
</style>

@extends('layout.master')

@section('content')

    <div class="container py-4">
        <div class="page-header text-center" style="max-width: 860px; margin: 2rem auto;">
            <h2>Profil Admin</h2>
        </div>

        <div class="card shadow-sm border-0 mx-auto" style="max-width: 900px;">
            <div class="card-body p-5">
                <div class="col-md-12 text-center">
                    <i 
                        class="fa-solid fa-circle-user profile-icon" 
                        aria-hidden="true" 
                        title="Foto Profil Pengguna"
                    ></i>
                </div>

                <div class="row g-3">
                    <div class="col-md-12">
                        <h5 class="detail-label"><i class="fa-solid fa-user me-1"></i> Nama Lengkap</h5>
                        <div class="detail-field-wrapper">
                            <span class="detail-text">Administrator</span>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <h5 class="detail-label"><i class="fa-solid fa-envelope me-1"></i> Email</h5>
                        <div class="detail-field-wrapper">
                            <span class="detail-text">{{ $admin->email ?? 'data tidak ada' }}</span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-5">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <a href="#" onclick="confirmLogout(event)" class="btn btn-warning fw-bold btn-logout-custom">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layout.loading')

    <script>
        function confirmLogout(event) {
            event.preventDefault();
            Swal.fire({
                icon: "question",
                title: "Konfirmasi Logout",
                text: "Apakah Anda yakin ingin logout?",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Logout",
                cancelButtonText: "Kembali",
                reverseButtons: true,
                customClass: {
                    actions: 'swal-actions-gap',
                    icon: 'swal-question-primary',
                    confirmButton: 'btn btn-primary-color',
                    cancelButton: 'btn btn-merah-color'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }
    </script>

@endsection