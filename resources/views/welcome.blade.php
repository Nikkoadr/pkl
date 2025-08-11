<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Manajemen PKL | Praktik Kerja Lapangan</title>

        <!-- Meta SEO -->
        <meta name="description" content="Sistem Manajemen PKL SMK Muhammadiyah Kandanghaur untuk mempermudah pengelolaan Praktik Kerja Lapangan secara digital dan terintegrasi.">

        <!-- Favicon -->
        <link rel="icon" href="https://www.smkmuhkandanghaur.sch.id/assets/favicon.ico" type="image/x-icon">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

        <style>
        .carousel-item {
            height: 100vh;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .carousel-overlay {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(2px);
            z-index: 1;
        }

        .hero-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: white;
            z-index: 2;
        }

        .hero-content h1 {
            font-size: 3rem;
            font-weight: 700;
        }

        .hero-content p {
            font-size: 1.25rem;
            margin-top: 10px;
        }

        .btn-lg {
            padding: 0.75rem 1.5rem;
            font-size: 1.1rem;
        }
        </style>
    </head>
    <body>

<div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="2000">
    <div class="carousel-inner">

        <!-- Slide 1 -->
        <div class="carousel-item active" style="background-image: url('{{ asset('assets/dist/img/bg1.jpeg') }}')">
        <div class="carousel-overlay"></div>
        <div class="hero-content container">
            <h1>Selamat Datang di Sistem Manajemen PKL</h1>
            <p>Kelola kegiatan PKL secara mudah, efisien, dan terintegrasi.</p>
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
        </div>

        <!-- Slide 2 -->
        <div class="carousel-item" style="background-image: url('{{ asset('assets/dist/img/bg2.jpeg') }}')">
        <div class="carousel-overlay"></div>
        <div class="hero-content container">
            <h1>Selamat Datang di Sistem Manajemen PKL</h1>
            <p>Kelola kegiatan PKL secara mudah, efisien, dan terintegrasi.</p>
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
        </div>
        <!-- Slide 3 -->
        <div class="carousel-item" style="background-image: url('{{ asset('assets/dist/img/bg3.jpeg') }}')">
        <div class="carousel-overlay"></div>
        <div class="hero-content container">
            <h1>Selamat Datang di Sistem Manajemen PKL</h1>
            <p>Kelola kegiatan PKL secara mudah, efisien, dan terintegrasi.</p>
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
        </div>
        <!-- Slide 4 -->
        <div class="carousel-item" style="background-image: url('{{ asset('assets/dist/img/bg4.jpeg') }}')">
        <div class="carousel-overlay"></div>
        <div class="hero-content container">
            <h1>Selamat Datang di Sistem Manajemen PKL</h1>
            <p>Kelola kegiatan PKL secara mudah, efisien, dan terintegrasi.</p>
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
        </div>

    </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
