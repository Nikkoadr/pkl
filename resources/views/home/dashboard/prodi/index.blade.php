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
                    <h1>Dashboard</h1>
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

            <!-- Pie Chart -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Status Peserta PKL</h3>
                </div>
                <div class="card-body text-center">
                    <canvas id="pklPieChart" style="max-width: 300px; max-height: 300px;"></canvas>
                </div>
            </div>
            
        </div>
    </section>
</div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('pklPieChart');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Terserap', 'Belum Terserap'],
            datasets: [{
                data: [{{ $tersarap }}, {{ $belum }}],
                backgroundColor: ['#28a745', '#dc3545'],
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // supaya tetap proporsional
            plugins: {
                legend: { position: 'bottom' },
                title: { display: true, text: 'Distribusi Peserta PKL' }
            }
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
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

