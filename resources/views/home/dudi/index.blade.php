@extends('layouts.master')
@section('title', 'Manajemen DUDI')

@section('link')
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Manajemen DUDI</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="row w-100">
                        <div class="col-md-6 d-flex align-items-center">
                            <h3 class="card-title mb-0">Daftar DUDI</h3>
                        </div>
                        <div class="col-md-6 text-right">
                            @can('admin')
                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalImport">
                                <i class="fas fa-file-import"></i> Import Excel
                            </button>
                            @endcan
                            @canany(['admin', 'prodi'])
                            <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalTambah">
                                <i class="fas fa-plus"></i> Tambah DUDI
                            </button>
                            @endcanany
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table id="tabelDUDI" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama DUDI</th>
                                <th>Alamat</th>
                                <th>Jabatan Pimpinan</th>
                                <th>Nomor Kepegawaian</th>
                                <th>Pimpinan</th>
                                <th>Kuota</th>
                                <th>Kompetensi Keahlian</th>
                                <th data-orderable="false" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dudi as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_dudi }}</td>
                                <td>{{ $item->alamat_dudi }}</td>
                                <td>{{ $item->jabatan_pimpinan }}</td>
                                <td>{{ $item->nomor_kepegawaian }}</td>
                                <td>{{ $item->nama_pimpinan_dudi }}</td>
                                <td>{{ $item->kuota }}</td>
                                <td>{{ $item->kompetensi_keahlian->nama_kompetensi }}</td>
                                <td class="text-center">
                                        <a href="{{ route('surat.permohonan', $item->id) }}" class="btn btn-info btn-sm" target="_blank">
                                            <i class="fas fa-file-alt"></i>
                                        </a>
                                    <a href="{{ route('dudi.edit', $item->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('dudi.destroy', $item->id) }}" method="POST" class="d-inline form-hapus">
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
                </div> <!-- /.card-body -->
            </div> <!-- /.card -->
        </div>
    </section>
</div>
@canany(['admin', 'prodi'])
<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <form action="{{ route('dudi.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title" id="modalTambahLabel">Tambah DUDI</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>
                                Nama DUDI <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nama_dudi" class="form-control @error('nama_dudi') is-invalid @enderror" required>
                            @error('nama_dudi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>Alamat DUDI</label>
                            <input type="text" name="alamat_dudi" class="form-control @error('alamat_dudi') is-invalid @enderror">
                            @error('alamat_dudi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>No. Telp</label>
                            <input type="text" name="no_telp_dudi" class="form-control @error('no_telp_dudi') is-invalid @enderror">
                            @error('no_telp_dudi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>Jabatan Pimpinan</label>
                            <input type="text" name="jabatan_pimpinan" class="form-control @error('jabatan_pimpinan') is-invalid @enderror">
                            @error('jabatan_pimpinan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>Nomor Kepegawaian</label>
                            <input type="text" name="nomor_kepegawaian" class="form-control @error('nomor_kepegawaian') is-invalid @enderror">
                            @error('nomor_kepegawaian')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>Nama Pimpinan</label>
                            <input type="text" name="nama_pimpinan_dudi" class="form-control @error('nama_pimpinan_dudi') is-invalid @enderror">
                            @error('nama_pimpinan_dudi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>
                                Kuota <span class="text-danger">*</span>
                            </label>
                            <input type="number" name="kuota" class="form-control @error('kuota') is-invalid @enderror" required>
                            @error('kuota')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label>
                                Kompetensi Keahlian <span class="text-danger">*</span>
                            </label>
                            <select name="kompetensi_keahlian_id" class="form-control @error('kompetensi_keahlian_id') is-invalid @enderror" required>
                                <option value="" disabled selected>-- Pilih Kompetensi Keahlian --</option>
                                @foreach($kompetensi_keahlian as $komp)
                                    <option value="{{ $komp->id }}">{{ $komp->nama_kompetensi }}</option>
                                @endforeach
                            </select>
                            @error('kompetensi_keahlian_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <small class="text-muted">
                        <span class="text-danger">*</span> Wajib diisi
                    </small>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endcanany
@can('admin')
<!-- Modal Import -->
<div class="modal fade" id="modalImport" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="{{ route('dudi.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import Data DUDI</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="import_dudi">File input</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="import_dudi" name="file" required accept=".xlsx, .xls, .csv">
                                <label class="custom-file-label" for="import_dudi">Choose file</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Import</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endcan

@endsection

@section('scripts')
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script>
$(function () {
    bsCustomFileInput.init();
});
</script>
<script>
    $(function () {
        $("#tabelDUDI").DataTable({
            responsive: true,
            lengthChange: true,
            autoWidth: true,
            buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#tabelDUDI_wrapper .col-md-6:eq(0)');
    });

    // Konfirmasi Hapus
    $(document).on('click', '.btn-konfirmasi-hapus', function (e) {
        e.preventDefault();
        let form = $(this).closest("form");
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data DUDI akan dihapus secara permanen!",
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
