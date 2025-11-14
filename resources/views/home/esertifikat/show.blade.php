<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Sertifikat PKL</title>

    <!-- Font Nama -->
    <link href="https://fonts.googleapis.com/css2?family=Story+Script&display=swap" rel="stylesheet">

    <style>
        @page {
            size: A4;
            margin: 0;
        }
        body {
            margin: 0;
            padding: 40px 0;
            background-color: #e0e0e0;
            font-family: "Times New Roman", serif;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .page {
            position: relative;
            width: 210mm;
            height: 297mm;
            background: white url('{{ asset("assets/dist/img/sertifikat-bg.jpeg") }}') no-repeat center/cover;
            box-shadow: 0 0 15px rgba(0,0,0,0.25);
        }
        .nomor {
            position: absolute;
            top: 110mm;
            width: 100%;
            text-align: center;
            font-size: 18pt;
            font-weight: bold;
        }
        .judul {
            position: absolute;
            top: 118mm;
            width: 100%;
            text-align: center;
            font-size: 18pt;
        }
        .nama {
            position: absolute;
            top: 132mm;
            width: 100%;
            text-align: center;
            font-size: 30pt;
            font-family: 'Story Script';
        }
        .jurusan {
            position: absolute;
            top: 145mm;
            width: 100%;
            text-align: center;
            font-size: 15pt;
        }
        .isi {
            position: absolute;
            top: 158mm;
            width: 100%;
            text-align: center;
            font-size: 14pt;
        }
        .isi b {
            font-size: 18pt;
        }
        .tanggal {
            position: absolute;
            top: 185mm;
            width: 100%;
            text-align: center;
            font-size: 14pt;
            font-style: italic;
        }
        .foto {
            position: absolute;
            bottom: 40mm;
            left: 80mm;
            width: 28mm;
            height: 38mm;
            border: 1px solid #000;
            background-color: #fff;
        }
        .ttd {
            position: absolute;
            bottom: 40mm;
            left: 130mm;
            text-align: center;
            font-size: 14pt;
            line-height: 1.4;
            width: 60mm;
        }
        .qr-ttd {
            width: 28mm;
            margin: 8px auto 0 auto;
        }
        .nama-ttd {
            font-weight: bold;
        }

        @media print {
            body {
                background-color: white !important;
                padding: 0;
            }
            .page {
                box-shadow: none;
            }
        }
    </style>
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

    <div class="tanggal">
        Sertifikat ini diberikan pada tanggal {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('j F Y') }}
    </div>

    {{-- Foto --}}
    <div class="foto">
    @if($esertifikat->peserta_pkl->peserta->user->foto_profil)
        <img src="{{ asset('storage/foto_profil/' . $esertifikat->peserta_pkl->peserta->user->foto_profil) }}"
            alt="Foto Peserta"
            style="width: 100%; height: 100%; object-fit: cover;">
    @else
        <img src="{{ asset('assets/dist/img/foto-default.jpeg') }}"
            alt="Foto Default"
            style="width: 100%; height: 100%; object-fit: cover;">
    @endif
</div>

    <div class="ttd">
        Kepala SMK Muhammadiyah <br> Kandanghaur,<br>

        <div class="qr-ttd">
            {!! QrCode::size(80)->generate(url('esertifikat/scan/' . urlencode($esertifikat->nomor_sertifikat))) !!}
        </div>

        <div class="nama-ttd">{{ $pengaturan->kepala_sekolah }}</div>
    </div>

</div>

<script>
    window.onload = () => window.print();
</script>

</body>
</html>
