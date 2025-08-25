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
                    <table class="table table-bordered table-striped" id="tabel_guru_pembimbing">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Guru</th>
                                <th>DUDI</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pembimbing as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->guru->user->nama }}</td>
                                <td>{{ $item->dudi->nama_dudi }}</td>
                                <td class="text-center">
                                    <a href="{{ route('guru_pembimbing.edit', $item->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('guru_pembimbing.destroy', $item->id) }}" method="POST" class="d-inline form-hapus">
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
    <div class="modal-dialog modal-lg">
        <form action="{{ route('guru_pembimbing.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Guru Pembimbing</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <!-- Nama Guru -->
                    <div class="form-group">
                        <label for="nama_guru">Nama Guru</label>
                        <input type="text" class="form-control" name="nama_guru" id="nama_guru" placeholder="Ketik nama guru...">
                        <input type="hidden" name="guru_id" id="guru_id">
                    </div>

                    <!-- Daftar DUDI -->
                    <label for="dudi_id">Pilih DUDI</label>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm" id="datatable-dudi">
                            <thead>
                                <tr>
                                    <th style="width: 5%; text-align:center;">
                                        <input type="checkbox" id="checkAll">
                                    </th>
                                    <th>Nama DUDI</th>
                                    <th>Alamat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dudiList as $dudi)
                                <tr>
                                    <td class="text-center">
                                        <input type="checkbox" name="dudi_id[]" value="{{ $dudi->id }}">
                                    </td>
                                    <td>{{ $dudi->nama_dudi }}</td>
                                    <td>{{ $dudi->alamat }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary float-right">Simpan</button>
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

    $(function () {
        $("#tabel_guru_pembimbing").DataTable({
            responsive: true,
            lengthChange: true,
            autoWidth: true,
        }).buttons().container().appendTo('#tabel_guru_pembimbing_wrapper .col-md-6:eq(0)');
    });

    $(document).on('click', '.btn-konfirmasi-hapus', function (e) {
        e.preventDefault();
        let form = $(this).closest("form");

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data guru akan dihapus secara permanen!",
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

    let selectedDudi = new Set();

$('#modalTambah').on('shown.bs.modal', function () {
    selectedDudi.clear();
    $('#checkAll').prop('checked', false);

    // Autocomplete nama guru
    $('#nama_guru').autocomplete({
        source: "/autocomplete/guru",
        minLength: 2,
        select: function (event, ui) {
            $('#nama_guru').val(ui.item.label);
            $('#guru_id').val(ui.item.id);
            return false;
        }
    });

    // DataTable DUDI
    if (!$.fn.DataTable.isDataTable('#datatable-dudi')) {
        let dudiTable = $('#datatable-dudi').DataTable({
            pageLength: 10,
            lengthChange: true,
            responsive: true,
        });

        const updateHeaderSelectAll = () => {
            const nodes = $(dudiTable.rows({ page: 'current' }).nodes());
            const inputs = nodes.find('input[name="dudi_id[]"]');
            if (inputs.length === 0) { $('#checkAll').prop('checked', false); return; }
            let allChecked = true;
            inputs.each(function () {
                if (!selectedDudi.has(this.value)) { allChecked = false; return false; }
            });
            $('#checkAll').prop('checked', allChecked);
        };

        $('#datatable-dudi').on('change', 'input[name="dudi_id[]"]', function () {
            const val = this.value;
            if (this.checked) {
                selectedDudi.add(val);
            } else {
                selectedDudi.delete(val);
            }
            updateHeaderSelectAll();
        });

        $('#checkAll').off('click').on('click', function () {
            const isChecked = this.checked;
            const nodes = $(dudiTable.rows({ page: 'current' }).nodes());
            nodes.find('input[name="dudi_id[]"]').each(function () {
                this.checked = isChecked;
                const v = this.value;
                if (isChecked) { selectedDudi.add(v); } else { selectedDudi.delete(v); }
            });
        });

        dudiTable.on('draw', function () {
            const nodes = $(dudiTable.rows({ page: 'current' }).nodes());
            nodes.find('input[name="dudi_id[]"]').each(function () {
                this.checked = selectedDudi.has(this.value);
            });
            updateHeaderSelectAll();
        });

        $('#modalTambah form').on('submit', function (e) {
            e.preventDefault();

            let guruId = $('#guru_id').val();
            if (!guruId) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Silakan pilih guru terlebih dahulu!',
                });
                return false;
            }

            if (selectedDudi.size === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Silakan pilih minimal satu DUDI!',
                });
                return false;
            }

            const $form = $(this);
            $form.find('input[type="hidden"][name="dudi_id[]"]').remove();
            selectedDudi.forEach(function (val) {
                $('<input>').attr({ type: 'hidden', name: 'dudi_id[]', value: val }).appendTo($form);
            });

            this.submit();
        });
    } else {
        $('#datatable-dudi').DataTable().draw(false);
    }
});

});

@if (session('success'))
Swal.fire({
    toast: true,
    position: 'top-end',
    icon: 'success',
    title: @json(session('success')),
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true
});
@endif

@if (session('error'))
Swal.fire({
    toast: true,
    position: 'top-end',
    icon: 'error',
    title: @json(session('error')),
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true
});
@endif
</script>
@endsection
