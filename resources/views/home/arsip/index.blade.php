@extends('layouts.master')
@section('title', 'Arsip PKL')

@section('link')
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}">
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Arsip PKL</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card">
                <div class="card-header">
                    <div class="row w-100 align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-0">Daftar Arsip PKL</h5>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table id="tabel_arsip" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width:60px;">No</th>
                                <th>Tahun Ajaran</th>
                                <th class="text-center" data-orderable="false" style="width:180px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tahun_ajaran as $ta)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $ta->nama_tahun_ajaran }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('arsip.export', $ta->id) }}"
                                           class="btn btn-success btn-sm">
                                            <i class="fas fa-file-excel"></i> Download Excel
                                        </a>
                                    </td>
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
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

<script>
$(function () {
    $('#tabel_arsip').DataTable({
        responsive: true,
        lengthChange: true,
        autoWidth: true,
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]]
    });
});
</script>
@endsection
