<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Sertifikat PKL</title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }

        /* Background abu-abu dan centering */
        body {
            margin: 0;
            padding: 40px 0;
            background-color: #e0e0e0;
            font-family: "Times New Roman", serif;
            display: flex;
            justify-content: center;
            flex-direction: column; /* susun ke bawah */
            align-items: center;    /* tetap rata tengah */
        }

        /* Container halaman sertifikat */
        .page {
            position: relative;
            width: 210mm;
            height: 297mm;
            background: white url('{{ asset("assets/dist/img/sertifikat-bg.jpeg") }}') no-repeat center/cover;
            box-shadow: 0 0 15px rgba(0,0,0,0.25);
            page-break-after: always;
        }
        .page:last-child {
            page-break-after: auto; /* Tidak paksa break di akhir */
        }
        /* Nomor PKL */
        .nomor {
            position: absolute;
            top: 110mm;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 18pt; /* diperbesar */
            font-weight: bold;
        }

        /* Judul */
        .judul {
            position: absolute;
            top: 118mm;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 18pt; /* diperbesar */
        }

        /* Nama Peserta */
        .nama {
            position: absolute;
            top: 132mm;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 28pt; /* lebih besar dan tebal */
            font-weight: bold;
            font-family: cursive;
        }

        /* Jurusan */
        .jurusan {
            position: absolute;
            top: 144mm;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 14pt;
        }

        /* Isi sertifikat */
        .isi {
            position: absolute;
            top: 156mm;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 14pt; /* diperbesar */
        }
        .isi b {
            font-size: 18pt; /* diperbesar untuk "PKL" */
        }
        .isi i {
            font-size: 14pt; /* diperbesar */
        }
        .isi i b {
            font-size: 18pt; /* Nama DUDI lebih besar */
        }

        /* Tanggal */
        .tanggal {
            position: absolute;
            top: 185mm;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 14pt;
            font-style: italic;
        }

        /* Foto */
        .foto {
            position: absolute;
            bottom: 40mm;
            left: 80mm;
            width: 28mm;
            height: 38mm;
            border: 1px solid black;
            background-color: #fff;
        }

        /* Tanda tangan */
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

        /* Print-friendly */
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
        Nomor : {{ '086.' . str_pad($peserta->id, 3, '0', STR_PAD_LEFT) . '/KET/III.4/AU/F/' . date('Y') }}
    </div>

    {{-- Judul --}}
    <div class="judul">Sertifikat ini diberikan Kepada :</div>

    {{-- Nama Peserta --}}
    <div class="nama">{{ strtoupper($peserta->peserta->user->nama) }}</div>

    {{-- Jurusan --}}
    <div class="jurusan">( {{ strtoupper($peserta->peserta->kelas->kompetensi->nama_kompetensi ?? '-') }} )</div>

    {{-- Isi Sertifikat --}}
    <div class="isi">
        Yang telah menyelesaikan <br>
        <b>PRAKTIK KERJA LAPANGAN (PKL)</b><br>
        <i>di <b>{{ strtoupper($peserta->dudi->nama_dudi ?? '-') }}</b></i><br>
        <i>dari tanggal {{ \Carbon\Carbon::parse($pengaturan->tanggal_mulai_pkl)->locale('id')->translatedFormat('j F Y') }} 
        sampai dengan tanggal {{ \Carbon\Carbon::parse($pengaturan->tanggal_selesai_pkl)->locale('id')->translatedFormat('j F Y') }}</i>
    </div>

    {{-- Tanggal --}}
    <div class="tanggal">
        Sertifikat ini diberikan pada tanggal {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('j F Y') }}
    </div>

    {{-- Foto --}}
    <div class="foto"></div>

    {{-- Tanda Tangan --}}
    <div class="ttd">
        Kepala SMK Muhammadiyah <br> Kandanghaur,<br>
        <div class="nama-ttd">{{ $pengaturan->kepala_sekolah }}</div>
    </div>

</div>
<script>
    window.onload = function () {
        window.print();
    };
</script>
</body>
</html>
