@extends('layouts.master')
@section('title', 'Manajemen Peserta')

@section('link')
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Manajemen Peserta</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center w-100">
                        <h3 class="card-title mb-2 mb-md-0">Daftar Peserta</h3>
                        
                        <div class="d-flex flex-column flex-md-row align-items-md-center gap-2">
                            @can('admin')
                                <button class="btn btn-sm btn-success mr-2" data-toggle="modal" data-target="#modalImport">
                                    <i class="fas fa-file-import"></i> Import Excel
                                </button>
                            @endcan
                            <a href="{{ route('peserta.create') }}" class="btn btn-info btn-sm">
                                <i class="fas fa-user-plus"></i> Tambah Peserta
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table id="tabelPeserta" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tahun Ajaran</th>
                                <th>NISN</th>
                                <th>NIS</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Kelas</th>
                                <th data-orderable="false" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($peserta as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->tahun_ajaran->nama_tahun_ajaran ?? '-' }}</td>
                                <td>{{ $item->nisn ?? '-' }}</td>
                                <td>{{ $item->nis ?? '-' }}</td>
                                <td>{{ $item->user->nama ?? '-' }}</td>
                                <td>{{ $item->user->email ?? '-' }}</td>
                                <td>{{ $item->kelas->nama_kelas ?? '-' }}</td>
                                <td class="text-center">
                                    <a href="{{ route('peserta.edit', $item->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('peserta.destroy', $item->id) }}" method="POST" class="d-inline form-hapus">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm btn-konfirmasi-hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
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

@can('admin')
<div class="modal fade" id="modalImport" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="{{ route('peserta.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import Data User</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="import_user">File input</label>
                        <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="import_user" name="file" required accept=".xlsx, .xls, .csv">
                            <label class="custom-file-label" for="import_user">Choose file</label>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Import</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endcan
@endsection

@section('scripts')
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

<script>
    $(function () {
        $("#tabelPeserta").DataTable({
            responsive: true,
            lengthChange: true,
            autoWidth: true,
            // buttons: [
            //     {
            //         extend: 'copyHtml5',
            //         text: '<i class="fas fa-copy"></i> Copy',
            //         className: 'btn btn-secondary btn-sm'
            //     },
            //     {
            //         extend: 'excelHtml5',
            //         text: '<i class="fas fa-file-excel"></i> Excel',
            //         className: 'btn btn-success btn-sm'
            //     },
            //     {
            //         extend: 'csvHtml5',
            //         text: '<i class="fas fa-file-csv"></i> CSV',
            //         className: 'btn btn-info btn-sm'
            //     },
            //     {
            //         extend: 'pdfHtml5',
            //         text: '<i class="fas fa-file-pdf"></i> PDF',
            //         className: 'btn btn-danger btn-sm'
            //     },
            //     {
            //         extend: 'print',
            //         text: '<i class="fas fa-print"></i> Print',
            //         className: 'btn btn-primary btn-sm'
            //     }
            // ],
        }).buttons().container().appendTo('#tabelPeserta_wrapper .col-md-6:eq(0)');
    });

    $(document).on('click', '.btn-konfirmasi-hapus', function (e) {
        e.preventDefault();
        let form = $(this).closest("form");

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data peserta akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
</script>

@if (session('success'))
<script>
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: '{{ session('success') }}',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });
</script>
@endif

@if ($errors->any())
<script>
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'error',
        title: 'Terjadi kesalahan validasi!',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });
</script>
@endif
<script>
$(function () {
    bsCustomFileInput.init();
});
</script>
@endsection
