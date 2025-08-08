@extends('layouts.master')
@section('title', 'Logbook PKL')

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
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <h1>Logbook PKL</h1>
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambah">
                <i class="fas fa-plus"></i> Tambah Logbook
            </button>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <table id="tabelLogbook" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>Peserta</th>
                                <th>DUDI</th>
                                <th>Guru Pembimbing</th>
                                <th>Foto</th>
                                <th>Keterangan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logbook as $log)
                            <tr>
                                <td>{{ $log->tanggal }}</td>
                                <td>{{ $log->jam }}</td>
                                <td>{{ $log->peserta->user->nama ?? '-' }}</td>
                                <td>{{ $log->dudi->nama_dudi ?? '-' }}</td>
                                <td>{{ $log->guru_pembimbing->guru->user->nama ?? '-' }}</td>
                                <td>
                                    @if($log->foto_bukti)
                                    <a href="{{ asset('storage/'.$log->foto_bukti) }}" target="_blank">
                                        <img src="{{ asset('storage/'.$log->foto_bukti) }}" alt="Foto" width="60">
                                    </a>
                                    @else
                                    -
                                    @endif
                                </td>
                                <td>{{ $log->keterangan }}</td>
                                <td class="text-center">
                                    <a href="{{ route('logbook.edit', $log->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('logbook.destroy', $log->id) }}" method="POST" class="d-inline form-hapus">
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

{{-- Modal Tambah --}}
<div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{ route('logbook.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Logbook</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body row">
                    <div class="form-group col-md-6">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="jam">Jam</label>
                        <input type="time" name="jam" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="autocomplete_peserta_pkl">Nama Peserta</label>
                        <input type="text" id="autocomplete_peserta_pkl" class="form-control" placeholder="Ketik nama peserta...">
                        <input type="hidden" name="peserta_id" id="peserta_id">
                        <input type="hidden" name="dudi_id" id="dudi_id">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="foto_bukti">Foto Bukti</label>
                        <div class="custom-file">
                        <input type="file" name="foto_bukti" class="custom-file-input" id="foto_bukti">
                        <label class="custom-file-label" for="foto_bukti">Pilih file</label>
                        </div>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="keterangan">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
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
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="{{ asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

<script>
    $(function () {
        $("#tabelLogbook").DataTable({
            responsive: true,
            lengthChange: false,
            autoWidth: false,
            buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#tabelLogbook_wrapper .col-md-6:eq(0)');

        // Autocomplete Peserta
        $("#autocomplete_peserta_pkl").autocomplete({
            source: "/autocomplete/peserta_pkl",
            minLength: 2,
            select: function(event, ui) {
                $('#peserta_id').val(ui.item.peserta_id);
                $('#dudi_id').val(ui.item.dudi_id);
            }
        });

        // Konfirmasi hapus
        $('.btn-konfirmasi-hapus').on('click', function() {
            const form = $(this).closest('form');
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data logbook akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        });
    });
</script>
<script>
$(function () {
    bsCustomFileInput.init();
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
        timer: 3000,
        timerProgressBar: true
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
        timer: 3000,
        timerProgressBar: true
    });
</script>
@endif
@endsection
