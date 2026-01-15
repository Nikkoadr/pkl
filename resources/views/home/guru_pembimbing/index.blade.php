@extends('layouts.master')
@section('title', 'Guru Pembimbing')

@section('link')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
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
                                <th>Kompetensi Keahlian</th>
                                <th>DUDI</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pembimbing as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->guru->user->nama }}</td>
                                <td>{{ $item->kompetensi_keahlian->nama_kompetensi }}</td>
                                <td>{{ $item->dudi->nama_dudi }}</td>
                                <td class="text-center">
                                    <a href="{{ route('guru_pembimbing.edit', $item->id) }}"
                                       class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('guru_pembimbing.destroy', $item->id) }}"
                                          method="POST"
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                                class="btn btn-danger btn-sm btn-konfirmasi-hapus">
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

{{-- MODAL TAMBAH --}}
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

                    <div class="form-group">
                        <label>Nama Guru</label>
                        <input type="text"
                               class="form-control"
                               id="nama_guru"
                               placeholder="Ketik nama guru...">
                        <input type="hidden" name="guru_id" id="guru_id">
                    </div>

                    <div class="form-group">
                        <label>Kompetensi Keahlian</label>
                        <select name="kompetensi_keahlian_id"
                                class="form-control" required>
                            <option value="" disabled selected>
                                -- Pilih Kompetensi Keahlian --
                            </option>
                            @foreach ($kompetensi as $k)
                                <option value="{{ $k->id }}">
                                    {{ $k->nama_kompetensi }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <label>Pilih DUDI</label>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm" id="datatable-dudi">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">
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
                                        <input type="checkbox"
                                               name="dudi_id[]"
                                               value="{{ $dudi->id }}">
                                    </td>
                                    <td>{{ $dudi->nama_dudi }}</td>
                                    <td>{{ $dudi->alamat }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary"
                            data-dismiss="modal">Batal</button>
                    <button type="submit"
                            class="btn btn-primary">Simpan</button>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(function () {

    // Datatable utama
    $('#tabel_guru_pembimbing').DataTable({
        responsive: true,
        lengthChange: true,
        autoWidth: false
    });

    // Konfirmasi hapus
    $(document).on('click', '.btn-konfirmasi-hapus', function (e) {
        e.preventDefault();
        let form = $(this).closest('form');

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Data akan dihapus permanen!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonText: 'Batal'
        }).then((r) => {
            if (r.isConfirmed) form.submit();
        });
    });

    let selectedDudi = new Set();
    let dudiTable;

    $('#modalTambah').on('shown.bs.modal', function () {

        selectedDudi.clear();
        $('#checkAll').prop('checked', false);
        $('#guru_id').val('');

        // Autocomplete (aman)
        if ($('#nama_guru').data('ui-autocomplete')) {
            $('#nama_guru').autocomplete('destroy');
        }

        $('#nama_guru').autocomplete({
            source: "/autocomplete/guru",
            minLength: 2,
            select: function (event, ui) {
                $('#nama_guru').val(ui.item.label);
                $('#guru_id').val(ui.item.id);
                return false;
            }
        });

        // Datatable DUDI
        if (!$.fn.DataTable.isDataTable('#datatable-dudi')) {
            dudiTable = $('#datatable-dudi').DataTable({
                pageLength: 10,
                responsive: true
            });
        } else {
            dudiTable = $('#datatable-dudi').DataTable();
        }

        $('#datatable-dudi').off('change').on(
            'change',
            'input[name="dudi_id[]"]',
            function () {
                this.checked
                    ? selectedDudi.add(this.value)
                    : selectedDudi.delete(this.value);
            }
        );

        $('#checkAll').off('click').on('click', function () {
            let checked = this.checked;
            dudiTable.rows({ page: 'current' }).nodes().to$()
                .find('input[name="dudi_id[]"]')
                .each(function () {
                    this.checked = checked;
                    checked
                        ? selectedDudi.add(this.value)
                        : selectedDudi.delete(this.value);
                });
        });

        $('#modalTambah form').off('submit').on('submit', function (e) {
            e.preventDefault();

            if (!$('#guru_id').val()) {
                Swal.fire('Error', 'Pilih guru terlebih dahulu', 'error');
                return;
            }

            if (selectedDudi.size === 0) {
                Swal.fire('Error', 'Pilih minimal satu DUDI', 'error');
                return;
            }

            selectedDudi.forEach(id => {
                $('<input>', {
                    type: 'hidden',
                    name: 'dudi_id[]',
                    value: id
                }).appendTo(this);
            });

            this.submit();
        });
    });

});
</script>

@if (session('success'))
<script>
Swal.fire({
    toast: true,
    position: 'top-end',
    icon: 'success',
    title: @json(session('success')),
    showConfirmButton: false,
    timer: 3000
});
</script>
@endif

@if (session('error'))
<script>
Swal.fire({
    toast: true,
    position: 'top-end',
    icon: 'error',
    title: @json(session('error')),
    showConfirmButton: false,
    timer: 3000
});
</script>
@endif
@endsection
