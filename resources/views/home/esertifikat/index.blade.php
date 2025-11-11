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
            <form id="printForm">
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
                                    <th>NIS</th>
                                    <th>NISN</th>
                                    <th>Nama Peserta</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Konsentrasi Keahlian</th>
                                    <th>Nama DUDI</th>
                                    <th>Nilai Rata-rata</th>
                                    <th>Nilai Sidang</th>
                                    <th data-orderable="false" class="text-center">Cetak E-Sertifikat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($peserta as $index => $p)
                                    <tr>
                                        <td><input type="checkbox" class="check-peserta" value="{{ $p->id }}"></td>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $p->peserta->nis ?? '-' }}</td>
                                        <td>{{ $p->peserta->nisn ?? '-' }}</td>
                                        <td>{{ $p->peserta->user->nama ?? '-' }}</td>
                                        <td>{{ $p->peserta->user->tempat_lahir ?? '-' }},
                                            {{ $p->peserta->user->tanggal_lahir 
                                                    ? \Carbon\Carbon::parse($p->peserta->user->tanggal_lahir)
                                                        ->locale('id')
                                                        ->translatedFormat('d F Y') 
                                                    : '-' 
                                                }} </td>
                                        <td>{{ $p->peserta->kelas->kompetensi->nama_kompetensi ?? '-' }}</td>
                                        <td>{{ $p->dudi->nama_dudi ?? '-' }}</td>
                                        <td>
                                            @if($p->nilai_pkl && $p->nilai_pkl->count() > 0)
                                                {{ number_format($p->nilai_pkl->avg(function($n){
                                                    return ($n->nilai_disiplin_kerja + $n->nilai_kemajuan_kerja + $n->nilai_kualitas_kerja + $n->nilai_inisiatif_kreatifitas + $n->nilai_perilaku) / 5;
                                                }), 2) }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if($p->nilai_pkl && $p->nilai_pkl->count() > 0)
                                                {{ $p->nilai_pkl->avg('nilai_sidang_pkl') }}
                                            @else
                                                -
                                            @endif
                                        </td>
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
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>

<!-- Modal Preview Surat -->
<div class="modal fade" id="modalEsertifikat" tabindex="-1" role="dialog" aria-labelledby="modalEsertifikatLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" style="max-width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Preview Esertifikat</h5>
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
    $('#dataTable').DataTable({
        responsive: true,
        lengthChange: true,
        autoWidth: false,
        pageLength: 10
    });

    $('#selectAll').on('click', function () {
        $('.check-peserta').prop('checked', this.checked);
    });

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

        let pesertaTanpaNilai = [];
        $('.check-peserta:checked').each(function () {
            let row = $(this).closest('tr');
            let nilaiRata = row.find('td').eq(8).text().trim(); 
            let nilaiSidang = row.find('td').eq(9).text().trim();

            if (nilaiRata === '-' || nilaiSidang === '-') {
                let namaPeserta = row.find('td').eq(4).text().trim();
                pesertaTanpaNilai.push(namaPeserta);
            }
        });

        if (pesertaTanpaNilai.length > 0) {
            Swal.fire({
                icon: 'error',
                title: 'Tidak Bisa Mencetak',
                html: 'Peserta berikut belum memiliki nilai:<br><b>' + pesertaTanpaNilai.join(', ') + '</b>',
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
