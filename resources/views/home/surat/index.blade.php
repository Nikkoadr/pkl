@extends('layouts.master')
@section('title', 'Surat DUDI')

@section('link')
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}">
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Surat DUDI</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card">
                <div class="card-header">
                    <div class="row w-100 align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-0">Daftar Surat DUDI</h5>
                        </div>
                        @can('admin')
                            <div class="col-md-6 text-md-right text-left mt-2 mt-md-0">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-print"></i> Cetak Surat
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#" id="btnKopSurat">
                                            <i class="fas fa-file-contract text-primary"></i> Kop Surat
                                        </a>
                                        <a class="dropdown-item" href="#" id="btnPermohonan">
                                            <i class="fas fa-file-signature text-info"></i> Permohonan
                                        </a>
                                        <a class="dropdown-item" href="#" id="btnPengantar">
                                            <i class="fas fa-paper-plane text-success"></i> Pengantar
                                        </a>
                                        <a class="dropdown-item" href="#" id="btnPenarikan">
                                            <i class="fas fa-sign-out-alt text-danger"></i> Penarikan
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endcan
                    </div>
                </div>

                <div class="card-body">
                    <table id="dataTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th data-orderable="false" style="width:42px;">
                                    <input type="checkbox" id="selectAll">
                                </th>
                                <th style="width:60px;">No</th>
                                <th>Nama DUDI</th>
                                <th>Jumlah Peserta</th>
                                <th class="text-center" data-orderable="false" style="width:220px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dudiList as $dudi)
                                <tr>
                                    <td><input type="checkbox" class="check-dudi" value="{{ $dudi->id }}"></td>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $dudi->nama_dudi }}</td>
                                    <td>{{ $dudi->peserta_pkl_count }}/{{ $dudi->kuota }}</td>
                                    <td class="text-center">
                                        <div class="d-flex flex-column align-items-center gap-2">
                                            <a href="{{ route('surat.kop_surat', $dudi->id) }}" class="btn btn-primary btn-sm w-100" target="_blank">
                                                <i class="fas fa-file-contract"></i> Kop Surat
                                            </a>
                                            <a href="{{ route('surat.permohonan', $dudi->id) }}" class="btn btn-warning btn-sm w-100" target="_blank">
                                                <i class="fas fa-file-signature"></i> Permohonan
                                            </a>
                                            <a href="{{ route('surat.pengantar', $dudi->id) }}" class="btn btn-success btn-sm w-100" target="_blank">
                                                <i class="fas fa-paper-plane"></i> Pengantar
                                            </a>
                                            <a href="{{ route('surat.penarikan', $dudi->id) }}" class="btn btn-danger btn-sm w-100" target="_blank">
                                                <i class="fas fa-sign-out-alt"></i> Penarikan
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            @if ($dudiList->count() === 0)
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>
</div>

<div class="modal fade" id="modalSurat" tabindex="-1" role="dialog" aria-labelledby="modalSuratLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" style="max-width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Preview Surat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="iframeContainer" style="max-height: 80vh; overflow-y: auto;"></div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

<script>
$(function () {
    let table = $('#dataTable').DataTable({
        responsive: true,
        lengthChange: true,
        autoWidth: false,
        pageLength: 10
    });

    $(document).on('click', '#selectAll', function () {
        $('.check-dudi').prop('checked', this.checked);
    });

    $(document).on('click', '.check-dudi', function () {
        const all = $('.check-dudi').length;
        const checked = $('.check-dudi:checked').length;
        $('#selectAll').prop('checked', all > 0 && all === checked);
    });

    function showModalWithIframes(suratType) {
        const selectedIds = $('.check-dudi:checked').map(function () {
            return $(this).val();
        }).get();

        if (selectedIds.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Oops!',
                text: 'Pilih minimal satu DUDI terlebih dahulu.',
                confirmButtonText: 'OK'
            });
            return;
        }

        $('#iframeContainer').empty();

        const url = `/home/${suratType}?ids=${selectedIds.join(',')}`;
        $('#iframeContainer').append(`
            <iframe src="${url}" width="100%" height="600px" style="border:1px solid #ccc; margin-bottom:15px;"></iframe>
        `);

        $('#modalSurat').modal('show');
    }

    $('#btnKopSurat').on('click', function () {
        showModalWithIframes('kop-surat-massal');
    });

    $('#btnPermohonan').on('click', function () {
        showModalWithIframes('permohonan-massal');
    });

    $('#btnPengantar').on('click', function () {
        showModalWithIframes('pengantar-massal');
    });
    $('#btnPenarikan').on('click', function () {
        showModalWithIframes('penarikan-massal');
    });
});
</script>
@endsection
