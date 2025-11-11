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
                        <h3 class="card-title mb-0">Daftar Logbook</h3>
                    </div>
                    <div class="col-md-6 text-right">
                        @canany(['admin','prodi','guru_pembimbing'])
                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambah">
                                <i class="fas fa-plus"></i> Tambah Nilai
                            </button>

                            {{-- Tombol generate sertifikat massal --}}
                            <form id="formGenerateSertifikat" action="{{ route('esertifikat.generate_massal') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" id="btnGenerateMassal" class="btn btn-success btn-sm" disabled>
                                    <i class="fas fa-certificate"></i> Generate Sertifikat
                                </button>
                            </form>
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
                            <th>Nama Peserta</th>
                            <th>Disiplin</th>
                            <th>Kemajuan</th>
                            <th>Kualitas</th>
                            <th>Inisiatif</th>
                            <th>Perilaku</th>
                            <th>Foto Bukti</th>
                            <th>Sidang</th>
                            <th>Komentar</th>
                            <th data-orderable="false" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($nilai_pkl as $key => $nilai)
                        <tr>
                            <td>
                                <input type="checkbox" name="selected_ids[]" value="{{ $nilai->id }}" form="formGenerateSertifikat" class="row-check">
                            </td>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $nilai->peserta_pkl->peserta->user->nama ?? '-' }}</td>
                            <td>{{ $nilai->nilai_disiplin_kerja }}</td>
                            <td>{{ $nilai->nilai_kemajuan_kerja }}</td>
                            <td>{{ $nilai->nilai_kualitas_kerja }}</td>
                            <td>{{ $nilai->nilai_inisiatif_kreatifitas }}</td>
                            <td>{{ $nilai->nilai_perilaku }}</td>
                            <td>
                                @if($nilai->foto_bukti_nilai_pkl)
                                    <a href="{{ asset('storage/bukti_nilai_pkl/'.$nilai->foto_bukti_nilai_pkl) }}" target="_blank">
                                        <img src="{{ asset('storage/bukti_nilai_pkl/'.$nilai->foto_bukti_nilai_pkl) }}" alt="Foto" width="60">
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $nilai->nilai_sidang_pkl }}</td>
                            <td>{{ $nilai->komentar }}</td>
                            <td class="text-center">
                                <a href="{{ route('nilai_pkl.edit', $nilai->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('nilai_pkl.destroy', $nilai->id) }}" method="POST" class="d-inline form-delete">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger btn-hapus"><i class="fas fa-trash"></i></button>
                                </form>

                                {{-- Tombol generate sertifikat per individu --}}
                                <form action="{{ route('esertifikat.generate', $nilai->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fas fa-certificate"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<!-- Modal Tambah -->
@canany(['admin','prodi','guru_pembimbing'])
<div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{ route('nilai_pkl.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahLabel">Tambah Nilai PKL</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="autocomplete_peserta_pkl">Nama Peserta</label>
                        <input type="text" id="autocomplete_peserta_pkl" class="form-control" placeholder="Ketik nama peserta..." autocomplete="off">
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
                        <label for="foto_bukti_nilai_pkl">Foto Bukti Nilai</label>
                        <div class="custom-file">
                            <input type="file" name="foto_bukti_nilai_pkl" class="custom-file-input @error('foto_bukti_nilai_pkl') is-invalid @enderror" id="foto_bukti_nilai_pkl">
                            <label class="custom-file-label" for="foto_bukti">Pilih file</label>
                            @error('foto_bukti_nilai_pkl')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Nilai Sidang PKL</label>
                        <input type="number" name="nilai_sidang_pkl" class="form-control" min="0" max="100">
                    </div>

                    <div class="form-group">
                        <label>Komentar</label>
                        <textarea name="komentar" class="form-control" rows="2"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
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
        $('#datatable').DataTable();

        $('.form-delete').on('submit', function(e){
            e.preventDefault();
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data yang dihapus tidak bisa dikembalikan!",
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
                text: 'Pastikan semua nilai sudah lengkap. Proses ini tidak dapat dibatalkan!',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, lanjutkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    e.target.submit();
                }
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
