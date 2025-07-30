<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen PKL | Praktik Kerja Lapangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .hero-section {
            background: url('https://www.smkmuhkandanghaur.sch.id/assets/website/img/carousel-1.jpg') no-repeat center center;
            background-size: cover;
            height: 90vh;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .feature-box {
            transition: transform 0.3s ease;
        }

        .feature-box:hover {
            transform: translateY(-5px);
        }

        .nav-link {
            font-weight: 500;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Manajemen PKL</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            @if (Route::has('login'))
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav">
                        @auth
                            <li class="nav-item">
                                <a href="{{ url('/home/dashboard') }}" class="nav-link">Dashboard</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="nav-link">Log in</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a href="{{ route('register') }}" class="nav-link">Register</a>
                                </li>
                            @endif
                        @endauth
                    </ul>
                </div>
            @endif
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-overlay"></div>
        <div class="container text-center hero-content">
            <h1 class="display-4 fw-bold">Selamat Datang di Sistem Manajemen PKL</h1>
            <div>
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg me-2">Daftar Sekarang</a>
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">Masuk</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-top py-3 text-center text-muted">
        &copy; {{ date('Y') }} Sistem Manajemen PKL - All rights reserved.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
