<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Sertifikat PKL</title>

    <!-- Font Nama -->
    <link href="https://fonts.googleapis.com/css2?family=Story+Script&display=swap" rel="stylesheet">

    <style>
        /* ========================
           RESET & PAGE SETTING
        ========================= */
        @page {
            size: A4;
            margin: 0;
        }

        * {
            box-sizing: border-box;
        }

        html, body {
            margin: 0;
            padding: 0;
        }

        body {
            background: #e0e0e0;
            font-family: "Times New Roman", serif;
        }

        /* ========================
           WRAPPER (ANTI FLEX BUG)
        ========================= */
        .print-wrapper {
            display: block;
        }

        /* ========================
           PAGE A4
        ========================= */
        .page {
            position: relative;
            width: 210mm;
            height: 297mm;
            margin: 0 auto 20px auto;
            background: white url("/assets/dist/img/sertifikat-bg.jpeg") no-repeat center / cover;
            box-shadow: 0 0 15px rgba(0,0,0,.25);
            page-break-after: always;
            break-after: page;
        }

        /* ========================
           KONTEN SERTIFIKAT
        ========================= */
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
            font-family: "Story Script";
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
            left: 110mm;
            width: 90mm;
            text-align: center;
            font-size: 14pt;
            line-height: 1.4;
        }

        .qr-ttd {
            width: 28mm;
            margin: 8px auto 0 auto;
        }

        .nama-ttd {
            font-weight: bold;
        }

        /* ========================
           MODE PRINT (WAJIB)
        ========================= */
        @media print {
            body {
                background: white !important;
            }

            .page {
                margin: 0;
                box-shadow: none;
            }
        }
    </style>
</head>

<body>

<div class="print-wrapper">

    @foreach ($data as $row)
        <div class="page">

            <div class="nomor">
                Nomor :
                {{ $row->nomor_sertifikat
                    ?? ('086.' . str_pad($row->id, 3, '0', STR_PAD_LEFT) . '/KET/III.4/AU/F/' . date('Y')) }}
            </div>

            <div class="judul">
                Sertifikat ini diberikan kepada :
            </div>

            <div class="nama">
                {{ strtoupper($row->peserta_pkl->peserta->user->nama ?? '-') }}
            </div>

            <div class="jurusan">
                ( {{ strtoupper($row->peserta_pkl->peserta->kelas->kompetensi->nama_kompetensi ?? '-') }} )
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

            <div class="ttd">
                Kepala <br> SMK Muhammadiyah Kandanghaur
                <div class="qr-ttd">
                    {!! QrCode::size(80)->generate(url('/esertifikat/scan/' . $row->hash)) !!}
                </div>
                <div class="nama-ttd">
                    {{ $pengaturan->kepala_sekolah }}
                </div>
            </div>

        </div>
    @endforeach

</div>

<script>
    window.onload = function () {
        window.print();
    };
</script>

</body>
</html>
