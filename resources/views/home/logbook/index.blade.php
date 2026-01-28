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
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="row w-100">
                        <div class="col-md-6 d-flex align-items-center">
                            <h3 class="card-title mb-0">Daftar Logbook</h3>
                        </div>
                        <div class="col-md-6 text-right">
                        @canany(['admin','prodi','guru_pembimbing'])
                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambah">
                                <i class="fas fa-plus"></i> Tambah Logbook
                            </button>
                        @endcanany
                        @can('peserta')
                            <a href="{{ route('logbook.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Logbook</a>
                            <a href="{{ route('logbook.cetak.rekap') }}" class="btn btn-success btn-sm"><i class="fas fa-print"></i> Cetak Rekap</a>
                        @endcan
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="tabelLogbook" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Peserta</th>
                                <th>DUDI</th>
                                <th>Aktivitas</th>
                                <th data-orderable="false" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logbook as $log)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                {{-- Tanggal & Jam --}}
                                <td>
                                    {{ \Carbon\Carbon::parse($log->tanggal)->format('d-m-Y') }}<br>
                                    <small class="text-muted">{{ $log->jam }}</small>
                                </td>

                                {{-- Peserta & Kelas --}}
                                <td>
                                    <strong>{{ $log->peserta_pkl->peserta->user->nama ?? '-' }}</strong><br>
                                    <small class="text-muted">
                                        {{ $log->peserta_pkl->peserta->kelas->nama_kelas ?? '-' }}
                                    </small>
                                </td>

                                {{-- DUDI --}}
                                <td>
                                    {{ $log->peserta_pkl->dudi->nama_dudi ?? '-' }}
                                </td>

                                {{-- Aktivitas + Bukti --}}
                                <td>
                                    {{ $log->keterangan }}

                                    <div class="mt-1">
                                        <strong>Bukti:</strong>
                                        @if($log->foto_bukti)
                                            <a href="{{ asset('storage/bukti_logbook/'.$log->foto_bukti) }}"
                                            target="_blank">
                                                Lihat
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </div>
                                </td>

                                {{-- Aksi --}}
                                <td class="text-center align-middle">
                                    @can('admin')
                                        <a href="{{ route('logbook.edit', $log->id) }}"
                                        class="btn btn-primary btn-sm mr-1 mb-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endcan

                                    <form action="{{ route('logbook.destroy', $log->id) }}"
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

                </div>
            </div>
        </div>
    </section>
</div>

{{-- Modal Tambah --}}
@canany(['admin','prodi','guru_pembimbing'])
<div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{ route('logbook.store') }}" method="POST" enctype="multipart/form-data" id="formTambahLogbook">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahLabel">Tambah Logbook</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <!-- Tanggal -->
                        <div class="form-group col-md-6">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" required>
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Jam -->
                        <div class="form-group col-md-6">
                            <label for="jam">Jam</label>
                            <input type="time" name="jam" class="form-control @error('jam') is-invalid @enderror" required>
                            @error('jam')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Autocomplete Peserta -->
                        <div class="form-group col-md-12">
                            <label for="autocomplete_peserta_pkl">Nama Peserta</label>
                            <input type="text" id="autocomplete_peserta_pkl" class="form-control" placeholder="Ketik nama peserta...">
                            <input type="hidden" name="peserta_pkl_id" id="peserta_pkl_id" required>
                        </div>

                        <!-- Foto Bukti -->
                        <div class="form-group col-md-12">
                            <label for="foto_bukti">Foto Bukti</label>
                            <div class="custom-file">
                                <input type="file" name="foto_bukti" class="custom-file-input @error('foto_bukti') is-invalid @enderror" id="foto_bukti" required>
                                <label class="custom-file-label" for="foto_bukti">Pilih file</label>
                                @error('foto_bukti')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Keterangan -->
                        <div class="form-group col-md-12">
                            <label for="keterangan">Keterangan</label>
                            <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" rows="3" required></textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
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
<script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="{{ asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

<script>
    $(function () {
        $("#tabelLogbook").DataTable({
            responsive: true,
            lengthChange: true,
            autoWidth: true,
            pageLength: 10,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]]
        });

        // Autocomplete Peserta
        $("#autocomplete_peserta_pkl").autocomplete({
            source: "/autocomplete/peserta_pkl",
            minLength: 2,
            select: function(event, ui) {
                $('#peserta_pkl_id').val(ui.item.peserta_pkl_id);
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
