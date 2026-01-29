<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Sertifikat PKL</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/dist/img/about.png') }}">
    <!-- Font Nama -->
    <link href="https://fonts.googleapis.com/css2?family=Story+Script&display=swap" rel="stylesheet">
    <link rel="stylesheet"href="{{ asset('assets/dist/css/styles_sertifikat.css') }}?v={{ filemtime(public_path('assets/dist/css/styles_sertifikat.css')) }}">
</head>
<body>

<div class="page">

    <div class="nomor">
        Nomor : {{ $esertifikat->nomor_sertifikat }}
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
            {{ \Carbon\Carbon::parse($esertifikat->tanggal_mulai_pkl)->locale('id')->translatedFormat('d F Y') }} 
            sampai dengan 
            {{ \Carbon\Carbon::parse($esertifikat->tanggal_selesai_pkl)->locale('id')->translatedFormat('d F Y') }}
        </i>
    </div>

    <div class="foto">
    </div>

        <div class="area-ttd">
            <div class="ttd-box">
                <div class="ttd-row">

        <div class="ttd-barcode">
            <img src="data:image/png;base64,{{ $qrWithLogo }}" width="85" height="85" style="image-rendering: crisp-edges;">
        </div>

                    <div class="ttd-text">
                        <div class="ttd-atas">
                            Ditandatangani secara elektronik oleh:<br>
                            Kepala Sekolah <br>
                            SMK Muhammadiyah Kandanghaur
                        </div>
                        <hr>
                        <div class="ttd-nama">
                            {{ $esertifikat->kepala_sekolah }}
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
