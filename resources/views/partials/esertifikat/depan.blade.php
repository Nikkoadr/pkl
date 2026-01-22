<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Sertifikat PKL</title>

    <!-- Font Nama -->
    <link href="https://fonts.googleapis.com/css2?family=Story+Script&display=swap" rel="stylesheet">
    <link rel="stylesheet"href="{{ asset('assets/dist/css/styles_sertifikat.css') }}?v={{ filemtime(public_path('assets/dist/css/styles_sertifikat.css')) }}">
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

        <div class="area-ttd">
            <div class="ttd-box">
                <div class="ttd-row">
        @php
        $qrWithLogo = base64_encode(
            QrCode::format('png')
                ->size(220)
                ->margin(1)
                ->errorCorrection('H')
                ->merge(public_path('assets/dist/img/logo_barcode.png'), 0.25, true)
                ->generate(url('/esertifikat/scan/' . $esertifikat->hash))
        );
        @endphp

        <div class="ttd-barcode">
            <img src="data:image/png;base64,{{ $qrWithLogo }}" width="85" height="85" style="image-rendering: crisp-edges;">
        </div>

                    <div class="ttd-text">
                        <div class="ttd-atas">
                            Ditandatangani secara elektronik oleh:<br>
                            Kepala Sekolah <br>
                            SMK Muhammadiyah Kandanghaur
                        </div>

                        <div class="ttd-nama">
                            {{ $pengaturan->kepala_sekolah }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>

<script>
    window.onload = () => window.print();
</script>

</body>
</html>
