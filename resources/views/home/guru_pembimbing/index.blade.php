@extends('layouts.master')
@section('title', 'Guru Pembimbing')

@section('link')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
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
            <h1>Data Guru Pembimbing</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card">
                <div class="card-header">
                    <div class="row w-100">
                        <div class="col-md-6 d-flex align-items-center">
                            <h3 class="card-title mb-0">Daftar Guru Pembimbing</h3>
                        </div>
                        <div class="col-md-6 text-right">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#modalTambah">
                                <i class="fas fa-plus"></i> Tambah Guru Pembimbing
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-striped" id="datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Guru</th>
                                <th>DUDI</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pembimbing as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $row->guru->user->nama }}</td>
                                <td>{{ $row->dudi->nama_dudi }}</td>
                                <td class="text-center">
                                    <a href="{{ route('guru_pembimbing.edit', $row->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('guru_pembimbing.destroy', $row->id) }}" method="POST" class="d-inline form-hapus">
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
                </div>

            </div>
        </div>
    </section>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah">
    <div class="modal-dialog">
        <form action="{{ route('guru_pembimbing.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Guru Pembimbing</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_guru">Nama Guru</label>
                        <input type="text" class="form-control" name="nama_guru" id="nama_guru" placeholder="Ketik nama guru...">
                        <input type="hidden" name="guru_id" id="guru_id">
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
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script>
    $(function() {
        $('#datatable').DataTable();

        $('.btn-konfirmasi-hapus').click(function() {
            let form = $(this).closest('form');
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>

<script>
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
