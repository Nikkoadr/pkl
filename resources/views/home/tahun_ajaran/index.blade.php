@extends('layouts.master')
@section('title', 'Tahun Ajaran')

@section('link')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manajemen Tahun Ajaran</h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Data Table Card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Tahun Ajaran</h3>
                    <div class="card-tools">
                        <a href="{{ route('tahun_ajaran.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Tambah
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <table id="tabel_tahun_ajaran" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 5%">No</th>
                                <th>Status</th>
                                <th>Nama Tahun Ajaran</th>
                                <th data-orderable="false" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-capitalize">{{ $item->status }}</td>
                                    <td>{{ $item->nama_tahun_ajaran }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('tahun_ajaran.edit', $item->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('tahun_ajaran.destroy', $item->id) }}"
                                            method="POST"
                                            class="d-inline form-hapus">
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
@endsection

@section('scripts')
<!-- DataTables Scripts -->
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(function () {
    const table = $('#tabel_tahun_ajaran').DataTable({
        responsive: true,
        lengthChange: true,
        autoWidth: true,
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]]
    });

    $(document).on('click', '.btn-konfirmasi-hapus', function () {
        const form = $(this).closest('form');

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Data yang dihapus tidak dapat dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    // Success Alert
    @if (session('success'))
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: @json(session('success')),
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    @endif

    // Error Alert
    @if (session('error'))
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: @json(session('error')),
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    @endif

    // Validation Errors Alert
    @if ($errors->any())
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: 'Terjadi kesalahan validasi!',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    @endif
});
</script>
@endsection
