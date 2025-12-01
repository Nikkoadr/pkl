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
                            <th class="text-center">Cetak E-Sertifikat</th>
                            <th class="text-center">Aksi</th>
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
                                <td><input type="checkbox" class="selectItem" value="{{ $p->id }}"></td>
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

                                <td class="text-center">
                                    <button type="button" 
                                            class="btn btn-danger btn-sm btn-delete-one"
                                            data-id="{{ $p->id }}">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
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

{{-- HIDDEN FORM MASAL — WAJIB --}}
<form id="massDeleteForm" method="POST" style="display:none;">
    @csrf
</form>

{{-- MODAL CETAK --}}
<div class="modal fade" id="modalEsertifikat" tabindex="-1">
    <div class="modal-dialog modal-xl" style="max-width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Preview E-Sertifikat</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
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
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

<script>
$(function () {

    $('#dataTable').DataTable({
        responsive: true,
        lengthChange: true,
        autoWidth: false,
        pageLength: 10
    });

    // SELECT ALL
    $('#selectAll').on('click', function () {
        $('.selectItem').prop('checked', this.checked);
    });

    // CETAK (modal)
    function showModalWithIframes(type) {
        const ids = $('.selectItem:checked').map(function () {
            return $(this).val();
        }).get();

        if (ids.length === 0) {
            return Swal.fire("Oops!", "Pilih minimal satu sertifikat!", "warning");
        }

        $('#iframeContainer').html(`
            <iframe src="/home/esertifikat/${type}?ids=${ids.join(',')}" 
                    width="100%" height="600px" style="border:1px solid #ccc;"></iframe>
        `);
        $('#modalEsertifikat').modal('show');
    }

    $('#btnDepan').click(() => showModalWithIframes('cetak_depan_massal'));
    $('#btnBelakang').click(() => showModalWithIframes('cetak_belakang_massal'));

    // DELETE SATUAN
    $(document).on("click", ".btn-delete-one", function () {
        const id = $(this).data("id");

        Swal.fire({
            title: "Yakin ingin menghapus?",
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            confirmButtonText: "Ya, hapus!"
        }).then((result) => {
            if (result.isConfirmed) {

                let form = $('#massDeleteForm');
                form.attr('action', '{{ route("home.esertifikat.destroy_massal") }}');
                form.html('@csrf' + `<input type="hidden" name="ids[]" value="${id}">`);
                form.submit();
            }
        });
    });

    // DELETE MASSAL
    $('#btnDeleteSelected').click(function () {
        let selected = $('.selectItem:checked');

        if (selected.length === 0) {
            return Swal.fire("Oops!", "Tidak ada sertifikat dipilih!", "warning");
        }

        Swal.fire({
            title: "Hapus sertifikat terpilih?",
            text: `${selected.length} sertifikat akan dihapus!`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            confirmButtonText: "Ya, hapus!"
        }).then((result) => {
            if (result.isConfirmed) {

                let form = $('#massDeleteForm');
                form.attr('action', '{{ route("home.esertifikat.destroy_massal") }}');
                form.html('@csrf');

                selected.each(function () {
                    form.append(`<input type="hidden" name="ids[]" value="${$(this).val()}">`);
                });

                form.submit();
            }
        });
    });

});
</script>

@if (session('success'))
<script>
Swal.fire({ toast:true, position:'top-end', icon:'success', title:@json(session('success')), timer:3000, showConfirmButton:false });
</script>
@endif

@if (session('error'))
<script>
Swal.fire({ toast:true, position:'top-end', icon:'error', title:@json(session('error')), timer:3000, showConfirmButton:false });
</script>
@endif

@endsection
