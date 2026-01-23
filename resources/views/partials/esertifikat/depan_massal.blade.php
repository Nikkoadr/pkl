<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Sertifikat PKL</title>

    <!-- Font Nama -->
    <link href="https://fonts.googleapis.com/css2?family=Story+Script&display=swap" rel="stylesheet">
    <link rel="stylesheet"href="{{ asset('assets/dist/css/styles_sertifikat.css') }}?v={{ filemtime(public_path('assets/dist/css/styles_sertifikat.css')) }}">
    <style>
        .page {
            margin: 0 auto 20px auto;!important
        }
    </style>
</head>
<body>
<div class="print-wrapper">

    @foreach ($data as $row)
        <div class="page">

            <div class="nomor">
                Nomor: {{ $row->nomor_sertifikat
                    ?? '086.' . str_pad($row->id, 3, '0', STR_PAD_LEFT) . '/KET/III.4/AU/F/' . date('Y') }}
            </div>

            <div class="judul">Sertifikat ini diberikan kepada :</div>

            <div class="nama">{{ strtoupper($row->peserta_pkl->peserta->user->nama ?? '-') }}</div>

            <div class="jurusan">
                ({{ strtoupper($row->peserta_pkl->peserta->kelas->kompetensi->nama_kompetensi ?? '-') }})
            </div>

            <div class="isi">
                Yang telah menyelesaikan <br>
                <b>PRAKTIK KERJA LAPANGAN (PKL)</b><br>
                di <b>{{ strtoupper($row->peserta_pkl->dudi->nama_dudi ?? '-') }}</b>
            </div>

            <div class="tanggal">
                dari tanggal
                {{ \Carbon\Carbon::parse($pengaturan->tanggal_mulai_pkl)->locale('id')->translatedFormat('d F Y') }}
                sampai
                {{ \Carbon\Carbon::parse($pengaturan->tanggal_selesai_pkl)->locale('id')->translatedFormat('d F Y') }}
            </div>

            <div class="foto"></div>

@php
$qrSize = 600;

$logoScale = 0.30;

$qrWithLogo = base64_encode(
    QrCode::format('png')
        ->size($qrSize)
        ->margin(1)
        ->errorCorrection('H')
        ->merge(public_path('assets/dist/img/logo_barcode.png'), $logoScale, true)
        ->generate(url('/esertifikat/scan/' . $row->hash))
);
@endphp

<div class="area-ttd">
    <div class="ttd-box">
        <div class="ttd-row">
            <div class="ttd-barcode">
                <img src="data:image/png;base64,{{ $qrWithLogo }}" width="{{ $qrSize }}" height="{{ $qrSize }}" style="image-rendering: pixelated;">
            </div>
            <div class="ttd-text">
                <div class="ttd-atas">
                    Ditandatangani secara elektronik oleh:<br>
                    Kepala Sekolah <br>
                    SMK Muhammadiyah Kandanghaur
                </div>
                <hr>
                <div class="ttd-nama">
                    {{ $pengaturan->kepala_sekolah }}
                </div>
            </div>
        </div>
    </div>
</div>

        </div>
    @endforeach

</div>

<script>
    window.onload = () => window.print();
</script>
</body>
</html>
