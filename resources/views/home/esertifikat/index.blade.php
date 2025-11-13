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
                    <table id="dataTable" class="table table-bordered table-striped">
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
                                <th data-orderable="false" class="text-center">Cetak E-Sertifikat</th>
                                <th data-orderable="false" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($esertifikat as $p)
                                @php
                                    $peserta = $p->peserta_pkl->peserta ?? null;
                                    $user = $peserta->user ?? null;
                                    $kelas = $peserta->kelas ?? null;
                                @endphp
                                <tr>
                                    <td><input type="checkbox" class="check-peserta" value="{{ $p->id }}"></td>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $p->nomor_sertifikat ?? '-' }}</td>
                                    <td>{{ $peserta->nisn ?? '-' }}</td>
                                    <td>{{ $user->nama ?? '-' }}</td>
                                    <td>{{ $kelas->nama_kelas ?? '-' }}</td>
                                    <td>{{ $kelas->kompetensi->nama_kompetensi ?? '-' }}</td>
                                    <td>{{ $p->peserta_pkl->dudi->nama_dudi ?? '-' }}</td>
                                    <td>{{ $p->rata_rata_sikap ?? '-' }}</td>
                                    <td>{{ $p->nilai_sidang_pkl ?? '-' }}</td>
                                    <td>{{ $p->nilai_akhir ?? '-' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('cetak.esertifikat_depan', $p->id) }}" 
                                            class="btn btn-info btn-sm m-1" target="_blank">
                                            <i class="fas fa-file-alt"></i> Depan
                                        </a>
                                        <a href="{{ route('cetak.esertifikat_belakang', $p->id) }}" 
                                            class="btn btn-success btn-sm" target="_blank">
                                            <i class="fas fa-envelope-open-text"></i> Belakang
                                        </a>
                                    </td>
                                    <td>
                                        <form action="{{ route('home.esertifikat.destroy', $p->id) }}" method="POST" class="form-delete" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm btn-delete">
                                                <i class="fas fa-trash"></i> Hapus
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

<div class="modal fade" id="modalEsertifikat" tabindex="-1" role="dialog" aria-labelledby="modalEsertifikatLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" style="max-width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Preview E-Sertifikat</h5>
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
    const table = $('#dataTable').DataTable({
        responsive: true,
        lengthChange: true,
        autoWidth: false,
        pageLength: 10
    });

    // Select All checkbox
    $('#selectAll').on('click', function () {
        $('.check-peserta').prop('checked', this.checked);
    });

    // Cetak massal
    function showModalWithIframes(esertifikatType) {
        const selectedIds = $('.check-peserta:checked').map(function () {
            return $(this).val();
        }).get();

        if (selectedIds.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Oops!',
                text: 'Pilih minimal satu peserta terlebih dahulu.',
                confirmButtonText: 'OK'
            });
            return;
        }

        $('#iframeContainer').empty();
        const url = `/home/esertifikat/${esertifikatType}?ids=${selectedIds.join(',')}`;
        $('#iframeContainer').append(`
            <iframe src="${url}" width="100%" height="600px" style="border:1px solid #ccc; margin-bottom:15px;"></iframe>
        `);
        $('#modalEsertifikat').modal('show');
    }

    $('#btnDepan').on('click', function () {
        showModalWithIframes('cetak_depan_massal');
    });

    $('#btnBelakang').on('click', function () {
        showModalWithIframes('cetak_belakang_massal');
    });

    // Delete per baris & massal
    $(document).on('submit', '.form-delete', function(e) {
        e.preventDefault();
        const form = this;

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Sertifikat ini akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    $('#btnDeleteSelected').on('click', function() {
        const selectedIds = $('.check-peserta:checked').map(function () { return $(this).val(); }).get();

        if(selectedIds.length === 0){
            Swal.fire({
                icon: 'warning',
                title: 'Oops!',
                text: 'Pilih minimal satu sertifikat untuk dihapus.',
                confirmButtonText: 'OK'
            });
            return;
        }

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: `Akan menghapus ${selectedIds.length} sertifikat terpilih!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if(result.isConfirmed){
                $.ajax({
                    url: '{{ route("home.esertifikat.destroy_massal") }}',
                    type: 'POST',
                    data: {
                        ids: selectedIds,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res){
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: res.message || 'Sertifikat berhasil dihapus.',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true
                        });
                        setTimeout(() => location.reload(), 2000);
                    },
                    error: function(){
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'error',
                            title: 'Terjadi kesalahan!',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true
                        });
                    }
                });
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
