<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Sistem Informasi Pengelolaan Karyawan</title>
    <style>
        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('/api/placeholder/1200/400');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
        }

        .hero h1 {
            font-weight: bold;
            font-size: 48px;
        }

        .hero p {
            font-size: 24px;
        }

        .feature {
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .feature h2 {
            font-weight: bold;
            font-size: 24px;
        }

        .feature p {
            font-size: 18px;
        }

        .call-to-action {
            padding: 20px;
            background-color: #f7f7f7;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .call-to-action h2 {
            font-weight: bold;
            font-size: 24px;
        }

        .call-to-action p {
            font-size: 18px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Your App</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    @auth
                        @if (Auth::user()->role === \App\Models\User::ROLE_ADMIN)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard') }}">User Dashboard</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Register</a>
                            </li>
                        @endif
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <header class="hero text-center">
        <div class="container">
            <h1 class="display-4">Sistem Informasi Pengelolaan Karyawan</h1>
            <p class="lead">Solusi terpadu untuk manajemen sumber daya manusia yang efisien</p>
        </div>
    </header>

    <main class="container my-5">
        <div class="row">
            <div class="col-md-4">
                <div class="feature">
                    <h2>Efisien</h2>
                    <p>Optimalkan proses HR dengan sistem yang terintegrasi dan mudah digunakan.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature">
                    <h2>Akurat</h2>
                    <p>Kelola data karyawan dengan presisi tinggi dan pelaporan yang akurat.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature">
                    <h2>Aman</h2>
                    <p>Lindungi informasi penting karyawan dengan sistem keamanan terkini.</p>
                </div>
            </div>
        </div>
    </main>

    <section class="bg-light py-5">
        <div class="container text-center">
            <div class="call-to-action">
                <h2>Mulai Sekarang</h2>
                <p>Daftar atau masuk untuk mengakses sistem pengelolaan karyawan</p>
                <a href="{{ route('register') }}" class="btn btn-primary me-2">Daftar</a>
                <a href="{{ route('login') }}" class="btn btn-outline-primary">Masuk</a>
            </div>
        </div>
    </section>

    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2024 Sistem Informasi Pengelolaan Karyawan. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
