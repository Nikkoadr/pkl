@extends('layouts.master')
@section('title', 'Surat DUDI')

@section('link')
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Daftar Surat DUDI</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-body">
                    <table id="dataTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama DUDI</th>
                                <th>Jumlah Peserta</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dudiList as $index => $dudi)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $dudi->nama_dudi }}</td>
                                <td>{{ $dudi->tempat_pkl_count }}</td>
                                <td class="text-center">
                                    <a href="{{ route('surat.permohonan', $dudi->id) }}" class="btn btn-info btn-sm" target="_blank">
                                        <i class="fas fa-file-alt"></i> Surat Permohonan
                                    </a>
                                    <a href="{{ route('surat.pengantar', $dudi->id) }}" class="btn btn-success btn-sm" target="_blank">
                                        <i class="fas fa-envelope-open-text"></i> Surat Pengantar
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> <!-- /.card-body -->
            </div> <!-- /.card -->
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

<script>
    $(function () {
        $("#dataTable").DataTable({
            responsive: true,
            lengthChange: true,
            autoWidth: false,
            pageLength: 10,
        });
    });
</script>
@endsection
