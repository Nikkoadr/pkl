@extends('layouts.master')
@section('title', 'Sertifikat PKL')

@section('link')
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}">
@endsection

@section('content')
<div class="content-wrapper">

    {{-- HEADER --}}
    <section class="content-header">
        <div class="container-fluid">
            <h1>Sertifikat PKL</h1>
        </div>
    </section>

    {{-- CONTENT --}}
    <section class="content">
        <div class="container-fluid">
            <div class="card">

                {{-- CARD HEADER --}}
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-0">Daftar Sertifikat PKL</h5>
                        </div>
                        <div class="col-md-6 text-md-right mt-2 mt-md-0">
                            <div class="btn-group">
                                <button class="btn btn-primary btn-sm" id="btnDepan">
                                    <i class="fas fa-file-alt"></i> Cetak Depan
                                </button>
                                <button class="btn btn-success btn-sm" id="btnBelakang">
                                    <i class="fas fa-envelope-open-text"></i> Cetak Belakang
                                </button>
                                <button class="btn btn-danger btn-sm" id="btnDeleteSelected">
                                    <i class="fas fa-trash"></i> Hapus Terpilih
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form method="GET" action="{{ route('esertifikat.index') }}">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Konsentrasi Keahlian</label>
                                <select name="kompetensi" id="kompetensi" class="form-control">
                                    <option value="">-- Semua Konsentrasi --</option>
                                    @foreach ($listKompetensi as $kompetensi)
                                        <option value="{{ $kompetensi->id }}"
                                            {{ request('kompetensi') == $kompetensi->id ? 'selected' : '' }}>
                                            {{ $kompetensi->nama_kompetensi }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Kelas</label>
                                <select name="kelas" id="kelas"
                                    class="form-control"
                                    {{ request('kompetensi') ? '' : 'disabled' }}>
                                    <option value="">-- Semua Kelas --</option>
                                    @foreach ($listKelas as $kelas)
                                        <option value="{{ $kelas->id }}"
                                            {{ request('kelas') == $kelas->id ? 'selected' : '' }}>
                                            {{ $kelas->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <a href="{{ route('esertifikat.index') }}"
                                class="btn btn-secondary btn-block">
                                    <i class="fas fa-sync"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>
                    <table id="tabelEsertifikat" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="selectAll"></th>
                                <th>No</th>
                                <th>Peserta</th>
                                <th>DUDI</th>
                                <th>Nilai</th>
                                <th class="text-center">Cetak</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($esertifikat as $row)
                            <tr id="row-{{ $row->id }}">
                                {{-- Checkbox --}}
                                <td>
                                    <input type="checkbox" class="selectItem" value="{{ $row->id }}">
                                </td>

                                <td>{{ $loop->iteration }}</td>

                                {{-- Peserta --}}
                                <td>
                                    <strong>{{ $row->nama ?? '-' }}</strong><br>
                                    <small class="text-muted">
                                        NISN: {{ $row->nisn ?? '-' }} |
                                        {{ $row->kelas ?? '-' }} |
                                        {{ $row->kompetensi ?? '-' }}
                                    </small>
                                    <div>
                                        <small class="text-muted">
                                            No. Sertifikat: {{ $row->nomor_sertifikat ?? '-' }}
                                        </small>
                                    </div>
                                </td>

                                {{-- DUDI --}}
                                <td>
                                    {{ $row->nama_dudi ?? '-' }}
                                </td>

                                {{-- Nilai --}}
                                <td>
                                    <ul class="mb-0 pl-3">
                                        <li>Rata-rata Sikap: {{ $row->rata_rata_sikap ?? '-' }}</li>
                                        <li>Nilai Sidang: {{ $row->nilai_sidang_pkl ?? '-' }}</li>
                                        <li>Nilai Akhir: {{ $row->nilai_akhir ?? '-' }}</li>
                                    </ul>
                                </td>

                                {{-- Cetak --}}
                                <td class="text-center align-middle">
                                    <a href="{{ route('cetak.esertifikat_depan', $row->id) }}"
                                    class="btn btn-info btn-sm mr-1 mb-1"
                                    target="_blank"
                                    title="Cetak Depan">
                                        <i class="fas fa-file-alt"></i>
                                    </a>
                                    <a href="{{ route('cetak.esertifikat_belakang', $row->id) }}"
                                    class="btn btn-success btn-sm mb-1"
                                    target="_blank"
                                    title="Cetak Belakang">
                                        <i class="fas fa-envelope-open-text"></i>
                                    </a>
                                </td>

                                {{-- Aksi --}}
                                <td class="text-center align-middle">
                                    <form action="{{ route('esertifikat.destroy', $row->id) }}"
                                        method="POST"
                                        class="d-inline form-hapus">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                                class="btn btn-danger btn-sm btn-konfirmasi-hapus mb-1"
                                                title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <form id="formCetakDepan"
                          action="{{ route('cetak.esertifikat-depan-massal') }}"
                          method="POST" target="_blank" hidden>
                        @csrf
                        <input type="hidden" name="ids" id="idsCetakDepan">
                    </form>
                    <form id="formCetakBelakang"
                          action="{{ route('cetak.esertifikat-belakang-massal') }}"
                          method="POST" target="_blank" hidden>
                        @csrf
                        <input type="hidden" name="ids" id="idsCetakBelakang">
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
@if (session('success'))
<script>
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: '{{ session('success') }}',
        showConfirmButton: false,
        timer: 3000
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
        timer: 3000
    });
</script>
@endif
<script>
    $(function () {
        $("#tabelEsertifikat").DataTable({
            responsive: true,
            lengthChange: true,
            autoWidth: true,
            pageLength: 10,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]]
        });
    });
    $(document).on('click', '.btn-konfirmasi-hapus', function (e) {
        e.preventDefault();
        let form = $(this).closest("form");
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data akan dihapus permanen!",
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
    let selectedIds = [];
    $('#selectAll').on('change', function () {
        $('.selectItem').prop('checked', this.checked).trigger('change');
    });
    $(document).on('change', '.selectItem', function () {
        let id = $(this).val();
        if ($(this).is(':checked')) {
            if (!selectedIds.includes(id)) selectedIds.push(id);
        } else {
            selectedIds = selectedIds.filter(item => item !== id);
        }
    });
    $('#btnDeleteSelected').on('click', function () {
        if (selectedIds.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Tidak ada data terpilih',
                text: 'Pilih minimal 1 data.'
            });
            return;
        }
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Semua data terpilih akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then(result => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/home/esertifikat/destroy_massal",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        ids: selectedIds
                    },
                    success: function (res) {
                        if (res.status) {
                            selectedIds.forEach(id => {
                                $('#row-' + id).fadeOut(500, function () {
                                    $(this).remove();
                                });
                            });
                            Swal.fire("Berhasil!", res.message, "success");
                            selectedIds = [];
                            setTimeout(() => location.reload(), 1500);
                        } else {
                            Swal.fire("Gagal!", res.message, "error");
                        }
                    },
                    error: function () {
                        Swal.fire("Gagal!", "Terjadi kesalahan saat menghapus.", "error");
                    }
                });
            }
        });
    });
    $('#btnDepan').on('click', function () {
    if (selectedIds.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Tidak ada data terpilih',
            text: 'Pilih minimal 1 sertifikat.'
        });
        return;
    }
    $('#idsCetakDepan').val(selectedIds.join(','));
    $('#formCetakDepan').submit();
});
$('#btnBelakang').on('click', function () {

    if (selectedIds.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Tidak ada data terpilih',
            text: 'Pilih minimal 1 sertifikat.'
        });
        return;
    }

    $('#idsCetakBelakang').val(selectedIds.join(','));
    $('#formCetakBelakang').submit();
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const kompetensi = document.getElementById('kompetensi');
    const kelas = document.getElementById('kelas');

    kompetensi.addEventListener('change', function () {
        if (this.value) {
            kelas.disabled = false;
        } else {
            kelas.value = '';
            kelas.disabled = true;
        }
    });
});
</script>

@endsection
