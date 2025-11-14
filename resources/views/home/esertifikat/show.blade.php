<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Sertifikat PKL</title>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
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
            flex-direction: column;
            align-items: center;
        }

        .page {
            position: relative;
            width: 210mm;
            height: 297mm;
            background: white url('{{ asset("assets/dist/img/sertifikat-bg.jpeg") }}') no-repeat center/cover;
            box-shadow: 0 0 15px rgba(0,0,0,0.25);
            page-break-after: always;
        }

        .page:last-child {
            page-break-after: auto;
        }

        .nomor {
            position: absolute;
            top: 110mm;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 18pt;
            font-weight: bold;
        }

        .judul {
            position: absolute;
            top: 118mm;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 18pt;
        }

.nama {
    position: absolute;
    top: 132mm;
    left: 0;
    width: 100%;
    text-align: center;
    font-size: 28pt;
    font-weight: bold;
    font-family: 'Great Vibes';
}
        .jurusan {
            position: absolute;
            top: 144mm;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 14pt;
        }

        .isi {
            position: absolute;
            top: 156mm;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 14pt;
        }

        .isi b {
            font-size: 18pt;
        }

        .isi i {
            font-size: 14pt;
        }

        .isi i b {
            font-size: 18pt;
        }

        .tanggal {
            position: absolute;
            top: 185mm;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 14pt;
            font-style: italic;
        }

        /* Foto peserta */
        .foto {
            position: absolute;
            bottom: 40mm;
            left: 80mm;
            width: 28mm;
            height: 38mm;
            border: 1px solid black;
            background-color: #fff;
        }

        /* Tanda tangan kepala sekolah */
        .ttd {
            position: absolute;
            bottom: 40mm;
            left: 130mm;
            text-align: center;
            font-size: 14pt;
            line-height: 1.4;
        }

        .nama-ttd {
            margin-top: 20mm;
            font-weight: bold;
        }

        @media print {
            body {
                background-color: white !important;
                padding: 0;
                display: block;
            }

            .page {
                box-shadow: none;
                margin: 0 auto;
                background: white !important;
                background-size: contain !important;
                background-repeat: no-repeat !important;
                background-position: center !important;
                page-break-after: always;
            }

            .page:last-child {
                page-break-after: auto;
            }
        }
    </style>
</head>
<body>
<div class="page">

    {{-- Nomor Sertifikat --}}
    <div class="nomor">
        Nomor : {{ $esertifikat->nomor_sertifikat ?? ('086.' . str_pad($esertifikat->id, 3, '0', STR_PAD_LEFT) . '/KET/III.4/AU/F/' . date('Y')) }}
    </div>

    {{-- Judul --}}
    <div class="judul">Sertifikat ini diberikan Kepada :</div>

    {{-- Nama Peserta --}}
    <div class="nama">{{ strtoupper($esertifikat->peserta_pkl->peserta->user->nama) }}</div>

    {{-- Jurusan --}}
    <div class="jurusan">
        ( {{ strtoupper($esertifikat->peserta_pkl->peserta->kelas->kompetensi->nama_kompetensi ?? '-') }} )
    </div>

    {{-- Isi Sertifikat --}}
    <div class="isi">
        Yang telah menyelesaikan <br>
        <b>PRAKTIK KERJA LAPANGAN (PKL)</b><br>
        <i>di <b>{{ strtoupper($esertifikat->peserta_pkl->dudi->nama_dudi ?? '-') }}</b></i><br>
        <i>dari tanggal 
            {{ \Carbon\Carbon::parse($pengaturan->tanggal_mulai_pkl)->locale('id')->translatedFormat('d F Y') }} 
            sampai dengan 
            {{ \Carbon\Carbon::parse($pengaturan->tanggal_selesai_pkl)->locale('id')->translatedFormat('d F Y') }}
        </i>
    </div>

    {{-- Tanggal --}}
    <div class="tanggal">
        Sertifikat ini diberikan pada tanggal {{ \Carbon\Carbon::parse($esertifikat->tanggal_diterbitkan)->locale('id')->translatedFormat('d F Y') }}
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

    {{-- Tanda Tangan --}}
    <div class="ttd">
        Kepala SMK Muhammadiyah <br> Kandanghaur,<br>
        <div class="nama-ttd">{{ $pengaturan->kepala_sekolah }}</div>
    </div>

</div>
</body>
</html>
