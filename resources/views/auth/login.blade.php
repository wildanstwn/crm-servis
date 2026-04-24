<!DOCTYPE html>
<html lang="id">
<head>
    <title>Login | CRM Cahaya Mandiri Audio & Elektronik</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <link rel="icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon">
    
    <link rel="stylesheet" href="{{ asset('assets/fonts/inter/inter.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
    <link rel="stylesheet" href="{{ asset('assets/css/style-preset.css') }}">

    <style>
        .auth-main {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f4f7fa;
        }
        .auth-wrapper {
            width: 100%;
            max-width: 450px;
            padding: 20px;
        }
    </style>
</head>

<body data-pc-preset="preset-1" data-pc-theme="light">
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>

    <div class="auth-main">
        <div class="auth-wrapper">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <a href="#"><img src="{{ asset('assets/images/logo-dark.svg') }}" alt="logo" class="img-fluid mb-3" style="max-width: 60px;"></a>
                        <h4 class="fw-bold">CAHAYA MANDIRI</h4>
                        <p class="text-muted">Audio & Elektronik Servis</p>
                    </div>

                    <h5 class="mb-3 text-center">Silakan Masuk</h5>
                    
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Alamat Email</label>
                            <input type="email" name="email" class="form-control" placeholder="admin@cahayamandiri.com" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kata Sandi</label>
                            <input type="password" name="password" class="form-control" placeholder="******" required>
                        </div>
                        
                        <div class="d-flex mt-1 justify-content-between align-items-center">
                            <div class="form-check">
                                <input class="form-check-input input-primary" type="checkbox" id="remember_me" name="remember">
                                <label class="form-check-label text-muted" for="remember_me">Ingat saya</label>
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="ti ti-login me-2"></i>Masuk
                            </button>
                        </div>
                    </form>

                    <hr class="my-4">
                    <div class="text-center">
                        <small class="text-muted">Akses khusus Admin & Teknisi </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/js/theme.js') }}"></script>
</body>
</html>