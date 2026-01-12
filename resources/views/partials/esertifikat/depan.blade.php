<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Sertifikat PKL</title>

    <!-- Font Nama -->
    <link href="https://fonts.googleapis.com/css2?family=Story+Script&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/styles_sertifikat.css') }}" />
</head>
<body>

<div class="page">

    <div class="nomor">
        Nomor : {{ $esertifikat->nomor_sertifikat ?? ('086.' . str_pad($esertifikat->id, 3, '0', STR_PAD_LEFT) . '/KET/III.4/AU/F/' . date('Y')) }}
    </div>

    <div class="judul">Sertifikat ini diberikan Kepada :</div>

    <div class="nama">{{ strtoupper($esertifikat->peserta_pkl->peserta->user->nama) }}</div>

    <div class="jurusan">
        ( {{ strtoupper($esertifikat->peserta_pkl->peserta->kelas->kompetensi->nama_kompetensi ?? '-') }} )
    </div>

    <div class="isi">
        Yang telah menyelesaikan <br>
        <b>PRAKTIK KERJA LAPANGAN (PKL)</b><br>
        <i>di <b>{{ strtoupper($esertifikat->peserta_pkl->dudi->nama_dudi ?? '-') }}</b></i><br>
        <i>
            dari tanggal 
            {{ \Carbon\Carbon::parse($pengaturan->tanggal_mulai_pkl)->locale('id')->translatedFormat('d F Y') }} 
            sampai dengan 
            {{ \Carbon\Carbon::parse($pengaturan->tanggal_selesai_pkl)->locale('id')->translatedFormat('d F Y') }}
        </i>
    </div>

    <div class="foto"></div>

    <div class="ttd">
        Kepala <br> SMK Muhammadiyah Kandanghaur,<br>

        <div class="qr-ttd">
            {!! QrCode::size(80)->generate(url('/esertifikat/scan/' . $esertifikat->url_hash)) !!}
        </div>

        <div class="nama-ttd">{{ $pengaturan->kepala_sekolah }}</div>
    </div>

</div>

<script>
    window.onload = () => window.print();
</script>

</body>
</html>
