@extends('layouts.master')
@section('title', 'Sidang PKL')

@section('link')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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
            <h1>Sidang PKL</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card">
                <div class="card-header">
                    <div class="row w-100">
                        <div class="col-md-6 d-flex align-items-center">
                            <h3 class="card-title mb-0">Daftar Sidang PKL</h3>
                        </div>
                        <div class="col-md-6 text-right">
                            @canany(['admin', 'prodi'])
                                <button class="btn btn-primary btn-sm"
                                        data-toggle="modal"
                                        data-target="#modalTambah">
                                    <i class="fas fa-plus"></i> Tambah Peserta Sidang PKL
                                </button>
                            @endcanany
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-striped" id="datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Guru Penguji</th>
                                <th>Nama Peserta</th>
                                <th>Kelas</th>
                                <th>DUDI</th>
                                <th>Foto Bukti PKL</th>
                                <th>Semua Nilai PKL</th>
                                <th>Nilai Sidang</th>
                                <th>Nilai Akhir</th>
                                <th>Komentar</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($sidang_pkl as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $item->guru->user->nama ?? '-' }}</td>

                            <td>{{ $item->peserta_pkl->peserta->user->nama ?? '-' }}</td>

                            <td>{{ $item->peserta_pkl->peserta->kelas->nama_kelas ?? '-' }}</td>

                            <td>{{ $item->peserta_pkl->dudi->nama_dudi ?? '-' }}</td>

                            <td class="text-center">
                                @if ($item->peserta_pkl->nilai_pkl->foto_bukti_nilai_pkl)
                                    <a href="{{ asset('storage/bukti_nilai_pkl/'.$item->peserta_pkl->nilai_pkl->foto_bukti_nilai_pkl) }}"
                                    target="_blank">
                                        <img src="{{ asset('storage/bukti_nilai_pkl/'.$item->peserta_pkl->nilai_pkl->foto_bukti_nilai_pkl) }}"
                                            width="60" class="img-thumbnail">
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                    <ul class="mb-0 pl-3">
                                        <li>Disiplin: {{ $item->peserta_pkl->nilai_pkl->nilai_disiplin_kerja ?? '-' }}</li>
                                        <li>Kemajuan: {{ $item->peserta_pkl->nilai_pkl->nilai_kemajuan_kerja ?? '-' }}</li>
                                        <li>Kualitas: {{ $item->peserta_pkl->nilai_pkl->nilai_kualitas_kerja ?? '-' }}</li>
                                        <li>Inisiatif: {{ $item->peserta_pkl->nilai_pkl->nilai_inisiatif_kreatifitas ?? '-' }}</li>
                                        <li>Perilaku: {{ $item->peserta_pkl->nilai_pkl->nilai_perilaku ?? '-' }}</li>
                                    </ul>
                            </td>

                            <td class="text-center">
                                {{ $item->peserta_pkl->nilai_pkl->nilai_sidang_pkl ?? '-' }}
                            </td>
                            <td class="text-center">
                                {{ $item->peserta_pkl->nilai_pkl->nilai_akhir_pkl ?? '-' }}
                            </td>
                            <td>{{ $item->peserta_pkl->nilai_pkl->komentar ?? '-' }}</td>

                            <td class="text-center">
                                <a href="{{ route('sidang_pkl.edit', $item->peserta_pkl->nilai_pkl->id) }}"
                                class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('sidang_pkl.destroy', $item->id) }}"
                                    method="POST"
                                    class="d-inline form-delete">
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

@canany(['admin', 'prodi'])
    <div class="modal fade" id="modalTambah">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('sidang_pkl.store') }}" method="POST">
            @csrf
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Tambah Peserta Sidang PKL</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label>Nama Guru Penguji</label>
                        <input type="text" class="form-control" id="nama_guru"
                               placeholder="Ketik nama guru...">
                        <input type="hidden" name="guru_id" id="guru_id">
                    </div>

                    <label>Pilih Peserta PKL</label>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm" id="datatable-peserta">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">
                                        <input type="checkbox" id="checkAll">
                                    </th>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <th>DUDI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($peserta_pkl as $p)
                                <tr>
                                    <td class="text-center">
                                        <input type="checkbox"
                                            name="peserta_pkl_id[]"
                                              value="{{ $p->id }}">
                                    </td>
                                    <td>{{ $p->peserta->user->nama }}</td>
                                    <td>{{ $p->peserta->kelas->nama_kelas }}</td>
                                    <td>{{ $p->dudi->nama_dudi }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>

            </div>
        </form>
    </div>
</div>
@endcanany
@endsection

@section('scripts')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(function () {

    $('#datatable').DataTable({
        responsive: true,
        autoWidth: false
    });

    // konfirmasi hapus
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

    let selectedPeserta = new Set();
    let pesertaTable;

    $('#modalTambah').on('shown.bs.modal', function () {

        selectedPeserta.clear();
        $('#checkAll').prop('checked', false);
        $('#guru_id').val('');
        $('#nama_guru').val('');

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

        if (!$.fn.DataTable.isDataTable('#datatable-peserta')) {
            pesertaTable = $('#datatable-peserta').DataTable({
                pageLength: 10,
                responsive: true
            });
        } else {
            pesertaTable = $('#datatable-peserta').DataTable();
        }

        $('#datatable-peserta').off('change').on(
            'change',
            'input[name="peserta_pkl_id[]"]',
            function () {
                this.checked
                    ? selectedPeserta.add(this.value)
                    : selectedPeserta.delete(this.value);
            }
        );

        $('#checkAll').off().on('click', function () {
            let checked = this.checked;
            pesertaTable.rows({ page: 'current' }).nodes().to$()
                .find('input[name="peserta_pkl_id[]"]')
                .each(function () {
                    this.checked = checked;
                    checked
                        ? selectedPeserta.add(this.value)
                        : selectedPeserta.delete(this.value);
                });
        });

        $('#modalTambah form').off('submit').on('submit', function (e) {
            e.preventDefault();

            if (!$('#guru_id').val()) {
                Swal.fire('Error', 'Pilih guru terlebih dahulu', 'error');
                return;
            }

            if (selectedPeserta.size === 0) {
                Swal.fire('Error', 'Pilih minimal satu peserta PKL', 'error');
                return;
            }

            selectedPeserta.forEach(id => {
                $('<input>', {
                    type: 'hidden',
                    name: 'peserta_pkl_id[]',
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
