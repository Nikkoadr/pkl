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
                        <div class="col-md-6 text-right">
                            <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambah">
                                <i class="fas fa-plus"></i> Tambah DUDI
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table id="tabelDUDI" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama DUDI</th>
                                <th>Alamat</th>
                                <th>Pimpinan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dudi as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_dudi }}</td>
                                <td>{{ $item->alamat_dudi }}</td>
                                <td>{{ $item->nama_pimpinan_dudi }}</td>
                                <td class="text-center">
                                    <a href="{{ route('dudi.edit', $item->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('dudi.destroy', $item->id) }}" method="POST" class="d-inline form-hapus">
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

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <form action="{{ route('dudi.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-secondary">
                    <h5 class="modal-title">Tambah DUDI</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body row">
                    <div class="form-group col-md-12">
                        <label>Nama DUDI</label>
                        <input type="text" name="nama_dudi" class="form-control" required>
                    </div>
                    <div class="form-group col-md-12">
                        <label>Alamat DUDI</label>
                        <input type="text" name="alamat_dudi" class="form-control">
                    </div>
                    <div class="form-group col-md-12">
                        <label>No. Telp</label>
                        <input type="text" name="no_telp_dudi" class="form-control">
                    </div>
                    <div class="form-group col-md-12">
                        <label>Nomor Kepegawaian</label>
                        <input type="text" name="nomor_kepegawaian" class="form-control">
                    </div>
                    <div class="form-group col-md-12">
                        <label>Nama Pimpinan</label>
                        <input type="text" name="nama_pimpinan_dudi" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
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

<script>
    $(function () {
        $("#tabelDUDI").DataTable({
            responsive: true,
            lengthChange: false,
            autoWidth: false,
            buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#tabelDUDI_wrapper .col-md-6:eq(0)');
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
@endsection
