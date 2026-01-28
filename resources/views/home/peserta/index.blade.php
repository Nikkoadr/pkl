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
                        <div class="col-md-6 text-md-right mt-2 mt-md-0">
                            <div class="btn-group">
                                @can('admin')
                                    <a href="{{ route('peserta.export') }}"
                                    class="btn btn-primary btn-sm">
                                        <i class="fas fa-file-excel"></i> Export
                                    </a>
                                    <button type="button"
                                            class="btn btn-success btn-sm"
                                            data-toggle="modal"
                                            data-target="#modalImport">
                                        <i class="fas fa-file-import"></i> Import Excel
                                    </button>
                                @endcan
                                <a href="{{ route('peserta.create') }}"
                                class="btn btn-info btn-sm">
                                    <i class="fas fa-user-plus"></i> Tambah Peserta
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="tabelPeserta" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Info (Tahun / NISN / NIS / Email / No Telp / Jenis Kelamin)</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>DUDI</th>
                                <th data-orderable="false" class="text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($peserta as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    <div><b>Tahun:</b> {{ $item->tahun_ajaran->nama_tahun_ajaran ?? '-' }}</div>
                                    <div><b>NISN:</b> {{ $item->nisn ?? '-' }}</div>
                                    <div><b>NIS:</b> {{ $item->nis ?? '-' }}</div>
                                    <div><b>Email:</b> {{ $item->user->email ?? '-' }}</div>
                                    <div><b>No Telp:</b> {{ $item->user->no_telp ?? '-' }}</div>
                                    <div><b>Jenis Kelamin:</b> {{ $item->user->jenis_kelamin ?? '-' }}</div>
                                </td>

                                <td>{{ $item->user->nama ?? '-' }}</td>
                                <td>{{ $item->kelas->nama_kelas ?? '-' }}</td>
                                <td>{{ $item->peserta_pkl->dudi->nama_dudi ?? '-' }}</td>
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
    @include('home.peserta.import')
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
            pageLength: 10,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]]
        });
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
