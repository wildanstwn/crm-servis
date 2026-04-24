<!DOCTYPE html>
<html lang="id">
<head>
    <title>@yield('title') | Teknisi Portal - Cahaya Mandiri</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <link rel="icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon"> 
    
    <link rel="stylesheet" href="{{ asset('assets/fonts/inter/inter.css') }}" id="main-font-link" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}" >
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}" >
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}" >
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}" >
    
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link" >
    <link rel="stylesheet" href="{{ asset('assets/css/style-preset.css') }}" >
    @stack('custom-css')
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-layout="vertical" data-pc-direction="ltr" data-pc-theme="light">
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>

    <nav class="pc-sidebar">
        <div class="navbar-wrapper">
            <div class="m-header">
                <a href="/teknisi/dashboard" class="b-brand text-primary">
                    <img src="{{ asset('assets/images/logo-dark.svg') }}" class="img-fluid logo-lg" alt="logo">
                    <span class="badge bg-light-success rounded-pill ms-2 theme-version">CRM v1.0</span>
                </a>
            </div>
            <div class="navbar-content">
                <div class="card pc-user-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <img src="{{ asset('assets/images/user/avatar-2.jpg') }}" alt="user-image" class="user-avtar wid-45 rounded-circle" />
                            </div>
                            <div class="flex-grow-1 ms-3 me-2">
                                <h6 class="mb-0 text-truncate" style="max-width: 100px;">{{ Auth::user()->name ?? 'Teknisi' }}</h6>
                                <small>Teknisi</small>
                            </div>
                        </div>
                    </div>
                </div>

                <ul class="pc-navbar">
                    <li class="pc-item pc-caption">
                        <label>Navigasi Utama</label>
                    </li>

                    <li class="pc-item {{ request()->is('teknisi/dashboard') ? 'active' : '' }}">
                        <a href="/teknisi/dashboard" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-dashboard f-20"></i></span>
                            <span class="pc-mtext">Beranda</span>
                        </a>
                    </li>

                    <li class="pc-item pc-caption"><label>Pekerjaan Saya</label></li>
                    
                    <li class="pc-item {{ request()->is('teknisi/jadwal*') ? 'active' : '' }}">
                        <a href="{{ route('teknisi.jadwal.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-clipboard-list"></i></span>
                            <span class="pc-mtext">Tugas Aktif</span>
                        </a>
                    </li>

                    <li class="pc-item {{ request()->is('teknisi/riwayat*') ? 'active' : '' }}">
                        <a href="{{ route('teknisi.riwayat.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-history f-20"></i></span>
                            <span class="pc-mtext">Riwayat Selesai</span>
                        </a>
                    </li>

                    <li class="pc-item pc-caption"><label>Gudang</label></li>

                    <li class="pc-item {{ request()->is('teknisi/stok*') ? 'active' : '' }}">
                        <a href="{{ route('teknisi.stok.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-package f-20"></i></span>
                            <span class="pc-mtext">Cek Suku Cadang</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="pc-header">
        <div class="header-wrapper">
            <div class="me-auto pc-mob-drp">
                <ul class="list-unstyled">
                    <li class="pc-h-item pc-sidebar-collapse">
                        <a href="#" class="pc-head-link ms-0" id="sidebar-hide"><i class="ti ti-menu-2"></i></a>
                    </li>
                </ul>
            </div>
            <div class="ms-auto">
                <ul class="list-unstyled">
                    <li class="dropdown pc-h-item header-user-profile">
                        <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button">
                            <img src="{{ asset('assets/images/user/avatar-2.jpg') }}" alt="user-image" class="user-avtar" />
                        </a>
                        <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                            <div class="dropdown-body">
                                <a href="/logout" class="dropdown-item">
                                    <i class="ti ti-power"></i> <span>Keluar Sistem</span>
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <div class="pc-container">
        <div class="pc-content">
            @yield('content')
        </div>
    </div>

    <footer class="pc-footer">
        <div class="footer-wrapper container-fluid">
            <div class="row">
                <div class="col my-1">
                    <p class="m-0">© 2026 Cahaya Mandiri Audio - Portal Teknisi</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/js/theme.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
    
    @stack('scripts')
    @stack('custom-scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    // Cek apakah ada session 'success'
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            timer: 3000,
            showConfirmButton: false
        });
    @endif

    // Cek apakah ada session 'error'
    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "{{ session('error') }}",
        });
    @endif
</script>
</body>
</html>