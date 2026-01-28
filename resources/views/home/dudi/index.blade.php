@extends('layouts.master')
@section('title', 'Manajemen DUDI')

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
            <h1>Manajemen DUDI</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="row w-100">
                        <div class="col-md-6 d-flex align-items-center">
                            <h3 class="card-title mb-0">Daftar DUDI</h3>
                        </div>
                            <div class="col-md-6 text-md-right mt-2 mt-md-0">
                                <div class="btn-group">
                                    @can('admin')
                                        <a href="{{ route('dudi.export') }}"
                                        class="btn btn-primary btn-sm">
                                            <i class="fas fa-file-excel"></i> Export
                                        </a>
                                        <button type="button"
                                                class="btn btn-info btn-sm"
                                                data-toggle="modal"
                                                data-target="#modalImport">
                                            <i class="fas fa-file-import"></i> Import DUDI
                                        </button>
                                    @endcan

                                    @canany(['admin','prodi'])
                                        <button type="button"
                                                class="btn btn-success btn-sm"
                                                data-toggle="modal"
                                                data-target="#modalTambah">
                                            <i class="fas fa-plus"></i> Tambah DUDI
                                        </button>
                                    @endcanany
                                </div>
                            </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="tabel_dudi" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama DUDI</th>
                                <th>Info DUDI</th>
                                <th>Kuota</th>
                                <th>Kompetensi Keahlian</th>
                                <th data-orderable="false" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dudi as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    <strong>{{ $item->nama_dudi }}</strong>
                                </td>

                                <td>
                                    <div>
                                        <strong>Pimpinan:</strong> {{ $item->nama_pimpinan_dudi }}
                                    </div>
                                    <div>
                                        <strong>Jabatan:</strong> {{ $item->jabatan_pimpinan }}
                                    </div>
                                    <div>
                                        <strong>No. Kepegawaian:</strong> {{ $item->nomor_kepegawaian }}
                                    </div>
                                    <div>
                                        <strong>Alamat:</strong> {{ $item->alamat_dudi }}
                                    </div>
                                </td>

                                <td class="text-center">
                                    {{ $item->kuota }}
                                </td>

                                <td>
                                    {{ $item->kompetensi_keahlian->nama_kompetensi }}
                                </td>
                                <td class="text-center align-middle">
                                    <a href="{{ route('surat.booking', $item->id) }}"
                                    class="btn btn-info btn-sm mr-1 mb-1"
                                    target="_blank">
                                        <i class="fas fa-file-alt"></i>
                                    </a>

                                    <a href="{{ route('dudi.edit', $item->id) }}"
                                    class="btn btn-primary btn-sm mr-1 mb-1">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('dudi.destroy', $item->id) }}"
                                        method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                                class="btn btn-danger btn-sm btn-konfirmasi-hapus mb-1">
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
@canany(['admin', 'prodi'])
@include('home.dudi.create')
@endcanany
@can('admin')
@include('home.dudi.import')
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
    bsCustomFileInput.init();
});
</script>
<script>
    $(function () {
        $("#tabel_dudi").DataTable({
            responsive: true,
            lengthChange: true,
            autoWidth: true,
            pageLength: 10,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]]
        });
    });

    // Konfirmasi Hapus
    $(document).on('click', '.btn-konfirmasi-hapus', function (e) {
        e.preventDefault();
        let form = $(this).closest("form");
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data DUDI akan dihapus secara permanen!",
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
@endsection
