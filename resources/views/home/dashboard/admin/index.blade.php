@extends('layouts.master')
@section('title', 'Dashboard')
@section('link')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endsection
@section('content')
<!-- Content Wrapper -->
<div class="content-wrapper">
    <!-- Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard Admin</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Info Box Jumlah DUDI -->
                <div class="col-lg-6 col-12">
                    <div class="info-box shadow-sm">
                        <span class="info-box-icon bg-info"><i class="fas fa-building"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Jumlah DUDI</span>
                            <span class="info-box-number">{{ $jumlahDudi }}</span>
                        </div>
                    </div>
                </div>
                <!-- Info Box Jumlah Peserta -->
                <div class="col-lg-6 col-12">
                    <div class="info-box shadow-sm">
                        <span class="info-box-icon bg-success"><i class="fas fa-users"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Jumlah Peserta</span>
                            <span class="info-box-number">{{ $jumlahPeserta }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grafik Statistik -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header">
                            <h3 class="card-title">Grafik Statistik Peserta per Kompetensi</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="kompetensiChart" height="120"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistik Per Kompetensi Keahlian -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-bordered table-hover table-striped">
                                <thead class="">
                                    <tr>
                                        <th>Kompetensi Keahlian</th>
                                        <th>Sudah Terserap di DUDI</th>
                                        <th>Belum Mendapatkan DUDI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kompetensiStats as $k)
                                        <tr>
                                            <td>{{ $k->nama_kompetensi }}</td>
                                            <td>
                                                <span class="badge badge-success p-2">
                                                    {{ $k->sudah_terserap }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge badge-danger p-2">
                                                    {{ $k->belum_terserap }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if ($kompetensiStats->isEmpty())
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">
                                                Belum ada data kompetensi keahlian
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Statistik -->
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart.js untuk menampilkan grafik per kompetensi
    const ctx = document.getElementById('kompetensiChart').getContext('2d');
    const kompetensiChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($kompetensiStats->pluck('nama_kompetensi')),
            datasets: [
                {
                    label: 'Sudah Terserap',
                    data: @json($kompetensiStats->pluck('sudah_terserap')),
                    backgroundColor: 'rgba(40, 167, 69, 0.8)',
                },
                {
                    label: 'Belum Mendapatkan DUDI',
                    data: @json($kompetensiStats->pluck('belum_terserap')),
                    backgroundColor: 'rgba(220, 53, 69, 0.8)',
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                tooltip: { mode: 'index', intersect: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // SweetAlert
    @if (session('success'))
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    @endif

    @if (session('error'))
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: '{{ session('error') }}',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    @endif

    @if ($errors->any())
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: 'Terdapat {{ $errors->count() }} kesalahan validasi.',
            html: `{!! implode('<br>', $errors->all()) !!}`,
            showConfirmButton: true,
            confirmButtonText: 'Tutup',
            timerProgressBar: true
        });
    @endif
</script>
@endsection
