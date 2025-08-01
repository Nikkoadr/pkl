@extends('layouts.master')
@section('title', 'Manajemen Tempat PKL')

@section('link')
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css" />
<style>
    .ui-autocomplete {
        z-index: 9999 !important;
        background-color: #fff;
        max-height: 200px;
        overflow-y: auto;
        overflow-x: hidden;
        border: 1px solid #ccc;
        font-size: 14px;
    }
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Manajemen Tempat PKL</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="row w-100">
                        <div class="col-md-6 d-flex align-items-center">
                            <h3 class="card-title mb-0">Daftar Tempat PKL</h3>
                        </div>
                        <div class="col-md-6 text-right">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#modalTambah">
                                <i class="fas fa-plus"></i> Tambah Peserta
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table id="tabelTempatPKL" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama DUDI</th>
                                <th>Nama Siswa</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tempat_pkl as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->dudi->nama_dudi ?? '-' }}</td>
                                <td>{{ $item->peserta->user->nama ?? '-' }}</td>
                                <td class="text-center">
                                    <a href="{{ route('tempat_pkl.edit', $item->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('tempat_pkl.destroy', $item->id) }}" method="POST" class="d-inline form-hapus">
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
<div class="modal fade" id="modalTambah">
    <div class="modal-dialog">
        <form action="{{ route('tempat_pkl.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Peserta</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_peserta">Nama Peserta</label>
                        <input type="text" class="form-control @error('peserta_id') is-invalid @enderror" name="nama_peserta" id="nama_peserta" value="{{ old('nama_peserta') }}" placeholder="Ketik nama peserta...">
                        <input type="hidden" name="peserta_id" id="peserta_id" value="{{ old('peserta_id') }}">
                        @error('peserta_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="nama_dudi">Nama DUDI</label>
                        <input type="text" class="form-control" name="nama_dudi" id="nama_dudi" placeholder="Ketik nama DUDI...">
                        <input type="hidden" name="dudi_id" id="dudi_id">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<script>
    $(function () {
        $("#tabelTempatPKL").DataTable({
            responsive: true,
            lengthChange: false,
            autoWidth: false,
            buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#tabelTempatPKL_wrapper .col-md-6:eq(0)');
    });

    // Konfirmasi hapus
    $(document).on('click', '.btn-konfirmasi-hapus', function (e) {
        e.preventDefault();
        let form = $(this).closest("form");

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data akan dihapus secara permanen!",
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

    @if ($errors->any())
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'error',
        title: 'Terjadi kesalahan validasi!',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });
    @endif
</script>
<script>
$('#modalTambah').on('shown.bs.modal', function () {
    $('#nama_peserta').autocomplete({
        source: "/autocomplete/peserta",
        minLength: 2,
        select: function(event, ui) {
            $('#nama_peserta').val(ui.item.label);
            $('#peserta_id').val(ui.item.id);
            return false;
        }
    });

    $('#nama_dudi').autocomplete({
        source: "/autocomplete/dudi",
        minLength: 2,
        select: function(event, ui) {
            $('#nama_dudi').val(ui.item.label);
            $('#dudi_id').val(ui.item.id);
            return false;
        }
    });
});
</script>
@if ($errors->any())
<script>
    $(document).ready(function () {
        $('#modalTambah').modal('show');
    });
</script>
@endif
@endsection
