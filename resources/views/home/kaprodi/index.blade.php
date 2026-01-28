@extends('layouts.master')
@section('title', 'Manajemen Kaprodi')

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
            <h1>Manajemen Kaprodi</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="row w-100">
                        <div class="col-md-6 d-flex align-items-center">
                            <h3 class="card-title mb-0">Daftar Kaprodi</h3>
                        </div>
                        <div class="col-md-6 text-right">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#modalTambah">
                                <i class="fas fa-plus"></i> Tambah Kaprodi
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table id="tabelKaprodi" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Kompetensi Keahlian</th>
                                <th data-orderable="false" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kaprodi as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->guru->user->nama ?? '-' }}</td>
                                <td>{{ $item->kompetensi_keahlian->nama_kompetensi ?? '-' }}</td>
                                <td class="text-center align-middle">
                                    <a href="{{ route('kaprodi.edit', $item->id) }}"
                                    class="btn btn-primary btn-sm mr-1 mb-1">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('kaprodi.destroy', $item->id) }}"
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

{{-- Modal Tambah Kaprodi --}}
<div class="modal fade" id="modalTambah">
    <div class="modal-dialog">
        <form action="{{ route('kaprodi.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kaprodi</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_guru">Nama</label>
                        <input type="text" class="form-control @error('guru_id') is-invalid @enderror" 
                            name="nama_guru" id="nama_guru" value="{{ old('nama_guru') }}" 
                            placeholder="Ketik nama...">
                        <input type="hidden" name="guru_id" id="guru_id" value="{{ old('guru_id') }}">
                        @error('guru_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="nama_kompetensi">Kompetensi Keahlian</label>
                        <input type="text" class="form-control" name="nama_kompetensi" id="nama_kompetensi" placeholder="Ketik kompetensi keahlian...">
                        <input type="hidden" name="kompetensi_keahlian_id" id="kompetensi_keahlian_id">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
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
        $("#tabelKaprodi").DataTable({
            responsive: true,
            lengthChange: true,
            autoWidth: true,
            pageLength: 10,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]]
        });
    });

    // Konfirmasi hapus
    $(document).on('click', '.btn-konfirmasi-hapus', function (e) {
        e.preventDefault();
        let form = $(this).closest("form");

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data Kaprodi akan dihapus secara permanen!",
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

    // Autocomplete modal
    $('#modalTambah').on('shown.bs.modal', function () {
        $('#nama_guru').autocomplete({
            source: "/autocomplete/guru",
            minLength: 2,
            select: function(event, ui) {
                $('#nama_guru').val(ui.item.label);
                $('#guru_id').val(ui.item.id);
                return false;
            }
        });

        $('#nama_kompetensi').autocomplete({
            source: "/autocomplete/kompetensi",
            minLength: 2,
            select: function(event, ui) {
                $('#nama_kompetensi').val(ui.item.label);
                $('#kompetensi_keahlian_id').val(ui.item.id);
                return false;
            }
        });
    });

    @if ($errors->any())
    $(document).ready(function () {
        $('#modalTambah').modal('show');
    });
    @endif
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
@endsection
