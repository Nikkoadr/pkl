@extends('layouts.master')
@section('title', 'Data Nilai PKL')

@section('link')
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Data Nilai PKL</h1>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambah">
                    <i class="fas fa-plus"></i> Tambah Nilai
                </button>
            </div>
            <div class="card-body">
                <table id="datatable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Peserta</th>
                            <th>Disiplin</th>
                            <th>Kemajuan</th>
                            <th>Kualitas</th>
                            <th>Inisiatif</th>
                            <th>Perilaku</th>
                            <th>Sidang</th>
                            <th>Komentar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($nilai_pkl as $key => $nilai)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $nilai->peserta->user->nama ?? '-' }}</td>
                            <td>{{ $nilai->nilai_disiplin_kerja }}</td>
                            <td>{{ $nilai->nilai_kemajuan_kerja }}</td>
                            <td>{{ $nilai->nilai_kualitas_kerja }}</td>
                            <td>{{ $nilai->nilai_inisiatif_kreatifitas }}</td>
                            <td>{{ $nilai->nilai_prilaku }}</td>
                            <td>{{ $nilai->nilai_sidang_pkl }}</td>
                            <td>{{ $nilai->komentar }}</td>
                            <td>
                                <a href="{{ route('nilai-pkl.edit', $nilai->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('nilai-pkl.destroy', $nilai->id) }}" method="POST" class="d-inline form-delete">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger btn-hapus"><i class="fas fa-trash"></i></button>
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
@endsection

@section('scripts')
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

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
    });
</script>
@endsection
