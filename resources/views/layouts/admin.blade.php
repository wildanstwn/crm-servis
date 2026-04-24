<!DOCTYPE html>
<html lang="id">
<head>
    <title>@yield('title') | CRM Cahaya Mandiri</title>
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
                <a href="/dashboard" class="b-brand text-primary">
                    <img src="{{ asset('assets/images/logo-dark.svg') }}" class="img-fluid logo-lg" alt="logo">
                    <span class="badge bg-light-primary rounded-pill ms-2 theme-version">CRM v1.0</span>
                </a>
            </div>
            <div class="navbar-content">
                <div class="card pc-user-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <img src="{{ asset('assets/images/user/avatar-1.jpg') }}" alt="user-image" class="user-avtar wid-45 rounded-circle" />
                            </div>
                            <div class="flex-grow-1 ms-3 me-2">
                                <h6 class="mb-0">{{ Auth::user()->name ?? 'Wildan Setiawan' }}</h6>
                                <small>Administrator</small>
                            </div>
                        </div>
                    </div>
                </div>

                <ul class="pc-navbar">
                    <li class="pc-item pc-caption">
                        <label>Navigasi Utama</label>
                    </li>

                    <li class="pc-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                        <a href="/admin/dashboard" class="pc-link">
                            <span class="pc-micon">
                                <i class="ti ti-dashboard f-20"></i>
                            </span>
                            <span class="pc-mtext">Dashboard</span>
                        </a>
                    </li>

                    <li class="pc-item pc-caption"><label>Data Master</label></li>
                    
                    <li class="pc-item {{ request()->is('admin/pelanggan*') ? 'active' : '' }}">
                        <a href="/admin/pelanggan" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-users"></i></span>
                            <span class="pc-mtext">Data Pelanggan</span>
                        </a>
                    </li>
                    
                    <li class="pc-item {{ request()->is('admin/teknisi-list*') ? 'active' : '' }}">
                        <a href="/admin/teknisi-list" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-user-check"></i></span>
                            <span class="pc-mtext">Data Teknisi</span>
                        </a>
                    </li>

                    <li class="pc-item {{ request()->is('admin/suku-cadang*') ? 'active' : '' }}">
                        <a href="/admin/suku-cadang" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-package"></i></span>
                            <span class="pc-mtext">Suku Cadang</span>
                        </a>
                    </li>

                    <li class="pc-item pc-caption"><label>Operasional Servis</label></li>
                    
                    <li class="pc-item {{ request()->is('admin/jadwal*') ? 'active' : '' }}">
                        <a href="/admin/jadwal" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-calendar-event"></i></span>
                            <span class="pc-mtext">Jadwal & Riwayat Unit</span>
                        </a>
                    </li>
                    
                    <li class="pc-item pc-caption"><label>CRM & Loyalitas</label></li>
                    
                    <li class="pc-item {{ request()->is('admin/whatsapp*') ? 'active' : '' }}">
                        <a href="{{ route('admin.notifikasi.index') }}" class="pc-link">
                            <span class="pc-micon text-success"><i class="ti ti-brand-whatsapp"></i></span>
                            <span class="pc-mtext font-weight-bold">Notifikasi Terjadwal</span>
                        </a>
                    </li>
                    <li class="pc-item pc-caption">
                        <label>Laporan</label>
                        <i class="ti ti-chart-bar"></i>
                    </li>
                    <li class="pc-item {{ Request::is('admin/laporan*') ? 'active' : '' }}">
                        <a href="{{ route('admin.laporan.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-file-text text-primary"></i></span>
                            <span class="pc-mtext">Laporan Servis</span>
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
                                    <i class="ti ti-power"></i> <span>Keluar</span>
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
                    <p class="m-0">© 2026 Cahaya Mandiri Audio & Elektronik - Portal Admin</p>
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
    @stack('custom-scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>