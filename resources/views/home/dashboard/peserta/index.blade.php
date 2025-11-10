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

        {{-- Data Diri Peserta --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Diri Peserta</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>NISN</th>
                        <td>{{ Auth::user()->peserta->nisn ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>NIS</th>
                        <td>{{ Auth::user()->peserta->nis ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>{{ Auth::user()->nama }}</td>
                    </tr>
                    <tr>
                        <th>Tempat, Tanggal Lahir</th>
                        <td>{{ Auth::user()->tempat_lahir }}, {{ \Carbon\Carbon::parse(Auth::user()->tanggal_lahir)->locale('id')->translatedFormat('d F Y')}}</td>
                    </tr>
                    <tr>
                        <th>Kelas</th>
                        <td>{{ Auth::user()->peserta->kelas->nama_kelas ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>DU/DI</th>
                        @if($namaDudi)
                            <td><strong>{{ $namaDudi }}</strong></td>
                        @else
                            <td>Belum Memilih DU/DI : <a href="{{ route('peserta.request_dudi') }}"> Pilih DUDI</a></td>
                        @endif
                    </tr>
                    <tr>
                        <td colspan="2"><a href="{{ route('home.profil') }}" class="btn btn-primary float-right">Ubah</a></td>
                    </tr>
                </table>
            </div>
        </div>

    </div>
</section>

</div>
@endsection
@section('scripts')
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

