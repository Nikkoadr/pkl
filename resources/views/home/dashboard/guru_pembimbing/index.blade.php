@extends('layouts.master')
@section('title', 'Dashboard Guru Pembimbing')
@section('link')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
@endsection
@section('content')

<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard Guru Pembimbing</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Guru Pembimbing</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

<section class="content">
    <div class="container-fluid">

        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Daftar DUDI yang Dibimbing</h3>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-striped" id="dataTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama DUDI</th>
                            <th>Alamat</th>
                            <th>Kontak</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dudis as $dudi)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $dudi->nama_dudi }}</td>
                                <td>{{ $dudi->alamat ?? '-' }}</td>
                                <td>{{ $dudi->kontak ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</section>

</div>

@endsection
@section('scripts')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(function() {
        $('#dataTable').DataTable();
    });
</script>
@endsection
