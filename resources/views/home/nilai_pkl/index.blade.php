@extends('layouts.master')
@section('title', 'Data Nilai PKL')

@section('link')
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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
        <h1>Data Nilai PKL</h1>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <div class="row w-100">
                    <div class="col-md-6 d-flex align-items-center">
                        <h3 class="card-title mb-0">Daftar Nilai PKL</h3>
                    </div>
                    <div class="col-md-6 text-md-right mt-2 mt-md-0">
                        @canany(['admin','prodi','guru_pembimbing'])
                            <div class="btn-group">

                                {{-- TAMBAH NILAI --}}
                                <button type="button"
                                        class="btn btn-primary btn-sm"
                                        data-toggle="modal"
                                        data-target="#modalTambah">
                                    <i class="fas fa-plus"></i> Tambah Nilai
                                </button>

                                {{-- GENERATE SERTIFIKAT MASSAL --}}
                                <form id="formGenerateSertifikat"
                                    action="{{ route('esertifikat.generate_massal') }}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit"
                                            id="btnGenerateMassal"
                                            class="btn btn-success btn-sm"
                                            disabled>
                                        <i class="fas fa-certificate"></i> Generate Sertifikat
                                    </button>
                                </form>

                            </div>
                        @endcanany
                    </div>
                </div>
            </div>

            <div class="card-body">
                <table id="datatable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="checkAll"></th>
                            <th>No</th>
                            <th>Peserta</th>
                            <th>Nilai PKL</th>
                            <th class="text-center">Sidang</th>
                            <th class="text-center" data-orderable="false">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($nilai_pkl as $key => $nilai)
                        <tr>
                            <td>
                                <input type="checkbox"
                                    name="selected_ids[]"
                                    value="{{ $nilai->id }}"
                                    form="formGenerateSertifikat"
                                    class="row-check">
                            </td>

                            <td>{{ $key + 1 }}</td>

                            <td>
                                <strong>
                                    {{ $nilai->peserta_pkl->peserta->user->nama ?? '-' }}
                                </strong><br>

                                <small class="text-muted">
                                    Kelas:
                                    {{ $nilai->peserta_pkl->peserta->kelas->nama_kelas ?? '-' }}
                                </small><br>

                                <small class="text-muted">
                                    DUDI:
                                    {{ $nilai->peserta_pkl->dudi->nama_dudi ?? '-' }}
                                </small>
                            </td>

                            <td>
                                <ul class="mb-0 pl-3">
                                    <li>Disiplin: {{ $nilai->nilai_disiplin_kerja }}</li>
                                    <li>Kemajuan: {{ $nilai->nilai_kemajuan_kerja }}</li>
                                    <li>Kualitas: {{ $nilai->nilai_kualitas_kerja }}</li>
                                    <li>Inisiatif: {{ $nilai->nilai_inisiatif_kreatifitas }}</li>
                                    <li>Perilaku: {{ $nilai->nilai_perilaku }}</li>
                                </ul>
                            </td>

                            <td class="text-center">
                                {{ $nilai->nilai_sidang_pkl }}
                            </td>
                            <td class="text-center align-middle">
                                <div class="d-inline-flex">
                                    <a href="{{ route('nilai_pkl.edit', $nilai->id) }}"
                                    class="btn btn-primary btn-sm mr-1"
                                    title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('nilai_pkl.destroy', $nilai->id) }}"
                                        method="POST"
                                        class="mr-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                                class="btn btn-danger btn-sm btn-konfirmasi-hapus"
                                                title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('esertifikat.generate', $nilai->id) }}"
                                        method="POST">
                                        @csrf
                                        <button class="btn btn-success btn-sm"
                                                title="Generate Sertifikat">
                                            <i class="fas fa-certificate"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </section>
</div>

@canany(['admin','prodi','guru_pembimbing'])
<div class="modal fade" id="modalTambah">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('nilai_pkl.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Tambah Nilai PKL</h5>
                    <button class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label>Nama Peserta</label>
                        <input type="text" id="autocomplete_peserta_pkl" class="form-control" placeholder="Ketik nama..." autocomplete="off">
                        <input type="hidden" name="peserta_pkl_id" id="peserta_pkl_id">
                    </div>

                    <div class="form-group">
                        <label>Nilai Disiplin Kerja</label>
                        <input type="number" name="nilai_disiplin_kerja" class="form-control" required min="0" max="100">
                    </div>

                    <div class="form-group">
                        <label>Nilai Kemajuan Kerja</label>
                        <input type="number" name="nilai_kemajuan_kerja" class="form-control" required min="0" max="100">
                    </div>

                    <div class="form-group">
                        <label>Nilai Kualitas Kerja</label>
                        <input type="number" name="nilai_kualitas_kerja" class="form-control" required min="0" max="100">
                    </div>

                    <div class="form-group">
                        <label>Nilai Inisiatif & Kreatifitas</label>
                        <input type="number" name="nilai_inisiatif_kreatifitas" class="form-control" required min="0" max="100">
                    </div>

                    <div class="form-group">
                        <label>Nilai Perilaku</label>
                        <input type="number" name="nilai_perilaku" class="form-control" required min="0" max="100">
                    </div>

                    <div class="form-group">
                        <label>Foto Bukti Nilai</label>
                        <div class="custom-file">
                            <input type="file" name="foto_bukti_nilai_pkl" id="foto_bukti_nilai_pkl" class="custom-file-input">
                            <label class="custom-file-label">Pilih file</label>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-primary">Simpan</button>
                </div>

            </div>
        </form>
    </div>
</div>
@endcanany
@endsection

@section('scripts')
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="{{ asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

<script>
$(function () {

    // Init DataTable
    $('#datatable').DataTable();

    // Fix: Event delegation untuk konfirmasi delete agar aktif di semua halaman DataTables
    $(document).on('submit', '.form-delete', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                e.target.submit();
            }
        });
    });

    // Autocomplete nama peserta
    $("#autocomplete_peserta_pkl").autocomplete({
        source: "/autocomplete/peserta_pkl",
        minLength: 2,
        select: function(event, ui) {
            $('#peserta_pkl_id').val(ui.item.peserta_pkl_id);
        }
    });

    bsCustomFileInput.init();

    // Checkbox handler
    $('#checkAll').on('click', function() {
        $('.row-check').prop('checked', this.checked);
        toggleGenerateButton();
    });

    $(document).on('change', '.row-check', function() {
        $('#checkAll').prop('checked', $('.row-check:checked').length === $('.row-check').length);
        toggleGenerateButton();
    });

    function toggleGenerateButton() {
        $('#btnGenerateMassal').prop('disabled', $('.row-check:checked').length === 0);
    }

    // Konfirmasi generate massal
    $('#formGenerateSertifikat').on('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Generate Sertifikat?',
            text: 'Pastikan semua nilai sudah lengkap!',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Lanjutkan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) e.target.submit();
        });
    });

});
</script>

{{-- Notifikasi sukses --}}
@if (session('success'))
<script>
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: @json(session('success')),
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });
</script>
@endif

{{-- Notifikasi error --}}
@if (session('error'))
<script>
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'error',
        title: @json(session('error')),
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });
</script>
@endif
@endsection
