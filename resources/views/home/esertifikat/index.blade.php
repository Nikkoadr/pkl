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

    <section class="content-header">
        <div class="container-fluid">
            <h1>Sertifikat PKL</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card">
                <div class="card-header">
                    <div class="row w-100 align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-0">Daftar Sertifikat PKL</h5>
                        </div>

                        <div class="col-md-6 text-md-right text-left mt-2 mt-md-0">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary btn-sm" id="btnDepan">
                                    <i class="fas fa-file-alt"></i> Cetak Depan
                                </button>
                                <button type="button" class="btn btn-success btn-sm" id="btnBelakang">
                                    <i class="fas fa-envelope-open-text"></i> Cetak Belakang
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" id="btnDeleteSelected">
                                    <i class="fas fa-trash"></i> Hapus Terpilih
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <table id="tabelEsertifikat" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="selectAll"></th>
                                <th>No</th>
                                <th>Nomor Sertifikat</th>
                                <th>NISN</th>
                                <th>Nama Peserta</th>
                                <th>Kelas</th>
                                <th>Konsentrasi Keahlian</th>
                                <th>Nama DUDI</th>
                                <th>Rata-rata Sikap</th>
                                <th>Nilai Sidang</th>
                                <th>Nilai Akhir</th>
                                <th class="text-center">Cetak E-Sertifikat</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($esertifikat as $row)
                                <tr id="row-{{ $row->id }}">
                                    <td><input type="checkbox" class="selectItem" value="{{ $row->id }}"></td>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $row->nomor_sertifikat ?? '-' }}</td>
                                    <td>{{ $row->nisn ?? '-' }}</td>
                                    <td>{{ $row->nama ?? '-' }}</td>
                                    <td>{{ $row->kelas ?? '-' }}</td>
                                    <td>{{ $row->kompetensi ?? '-' }}</td>
                                    <td>{{ $row->nama_dudi ?? '-' }}</td>
                                    <td>{{ $row->rata_rata_sikap ?? '-' }}</td>
                                    <td>{{ $row->nilai_sidang_pkl ?? '-' }}</td>
                                    <td>{{ $row->nilai_akhir ?? '-' }}</td>

                                    <td class="text-center">
                                        <a href="{{ route('cetak.esertifikat_depan', $row->id) }}"
                                        class="btn btn-info btn-sm m-1" target="_blank">
                                            <i class="fas fa-file-alt"></i> Depan
                                        </a>
                                        <a href="{{ route('cetak.esertifikat_belakang', $row->id) }}"
                                        class="btn btn-success btn-sm" target="_blank">
                                            <i class="fas fa-envelope-open-text"></i> Belakang
                                        </a>
                                    </td>

                                    <td class="text-center">
                                        <form action="{{ route('esertifikat.destroy', $row->id) }}"
                                            method="POST"
                                            class="d-inline form-hapus">
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

    // =============================
    // Hapus Massal
    // =============================
    let selectedIds = [];

    // Select All
    $('#selectAll').on('change', function () {
        $('.selectItem').prop('checked', this.checked).trigger('change');
    });

    // Checkbox Item
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
</script>

@endsection
