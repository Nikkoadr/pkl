<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen PKL | Praktik Kerja Lapangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body, html {
            margin: 0;
            padding: 0;
        }

        .hero-section {
            background: url('https://www.smkmuhkandanghaur.sch.id/assets/website/img/carousel-1.jpg') no-repeat center center;
            background-size: cover;
            height: 100vh;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
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
            max-width: 800px;
        }

        .hero-content h1 {
            font-size: 3rem;
            font-weight: 700;
        }

        .btn-lg {
            padding: 0.75rem 1.5rem;
            font-size: 1.1rem;
        }

        .nav-link {
            font-weight: 500;
        }
    </style>
</head>
<body>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-overlay"></div>
        <div class="container hero-content">
            <h1 class="display-4 fw-bold">Selamat Datang di Sistem Manajemen PKL</h1>
            <p class="lead mt-3">Platform digital untuk mengelola kegiatan Praktik Kerja Lapangan secara efisien dan terintegrasi.</p>
            <div class="mt-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/home/dashboard') }}" class="btn btn-primary btn-lg me-2">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg me-2">Masuk</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-success btn-lg">Daftar Sekarang</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
