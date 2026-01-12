<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Verifikasi Sertifikat PKL</title>

    <link href="https://fonts.googleapis.com/css2?family=Story+Script&family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            display: grid;
            grid-template-columns: 360px 1fr;
            gap: 20px;
        }

        /* PANEL VERIFIKASI */
        .verify-panel {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,.08);
        }

        .verify-title {
            font-weight: 700;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .status-valid {
            background: #e8f9f0;
            color: #0f9d58;
            padding: 12px;
            border-radius: 10px;
            text-align: center;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .info-item {
            margin-bottom: 12px;
            font-size: 14px;
        }

        .info-item span {
            color: #6c757d;
            display: block;
            font-size: 12px;
        }

        .fingerprint {
            font-family: monospace;
            font-size: 11px;
            background: #f1f3f5;
            padding: 10px;
            border-radius: 6px;
            word-break: break-all;
        }

        .login-btn {
            display: block;
            text-align: center;
            background: #4f46e5;
            color: #fff;
            padding: 12px;
            border-radius: 8px;
            margin-top: 20px;
            text-decoration: none;
            font-weight: 600;
        }

        /* SERTIFIKAT */
        .certificate {
            background: #fff;
            border-radius: 12px;
            padding: 50px;
            position: relative;
            box-shadow: 0 10px 30px rgba(0,0,0,.08);
        }

        .cert-border {
            border: 6px double #c9a44c;
            padding: 40px;
        }

        .nomor {
            text-align: right;
            font-size: 13px;
            margin-bottom: 20px;
        }

        .judul {
            text-align: center;
            font-size: 34px;
            font-weight: 700;
            letter-spacing: 2px;
        }

        .subjudul {
            text-align: center;
            margin-top: 8px;
            font-size: 14px;
        }

        .nama {
            font-family: 'Story Script', cursive;
            text-align: center;
            font-size: 48px;
            margin: 30px 0 10px;
        }

        .jurusan {
            text-align: center;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .isi {
            text-align: center;
            font-size: 15px;
            line-height: 1.8;
        }

        .tanggal {
            text-align: center;
            margin-top: 30px;
        }

        .foto {
            width: 110px;
            height: 140px;
            border: 2px solid #000;
            position: absolute;
            top: 60px;
            left: 60px;
        }

        .ttd {
            position: absolute;
            right: 60px;
            bottom: 80px;
            text-align: center;
            font-size: 13px;
        }

        .qr {
            margin: 10px 0;
        }

        .watermark {
            position: absolute;
            inset: 0;
            background: url('{{ asset('assets/dist/img/logo-watermark.png') }}') center no-repeat;
            opacity: .05;
            pointer-events: none;
        }
    </style>
</head>
<body>

<div class="container">

    <!-- PANEL VERIFIKASI -->
    <div class="verify-panel">
        <div class="verify-title">Verifikasi Dokumen Resmi</div>

        <div class="status-valid">✔ DOKUMEN VALID & ASLI</div>

        <div class="info-item">
            <span>Nomor Sertifikat</span>
            {{ $esertifikat->nomor_sertifikat }}
        </div>

        <div class="info-item">
            <span>Tanggal Terbit</span>
            {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
        </div>

        <div class="info-item">
            <span>ID Verifikasi</span>
            {{ sha1($esertifikat->nomor_sertifikat) }}
        </div>

        <div class="info-item">
            <span>Digital Fingerprint (SHA-256)</span>
            <div class="fingerprint">
                {{ hash('sha256', $esertifikat->nomor_sertifikat) }}
            </div>
        </div>

        <a href="{{ route('login') }}" class="login-btn">
            Login ke Sistem Sekolah
        </a>
    </div>

    <!-- SERTIFIKAT -->
    <div class="certificate">
        <div class="watermark"></div>

        <div class="cert-border">

            <div class="foto">
                @if($esertifikat->peserta_pkl->peserta->user->foto_profil)
                    <img src="{{ asset('storage/foto_profil/'.$esertifikat->peserta_pkl->peserta->user->foto_profil) }}"
                         style="width:100%;height:100%;object-fit:cover;">
                @endif
            </div>

            <div class="nomor">
                Nomor : {{ $esertifikat->nomor_sertifikat }}
            </div>

            <div class="judul">SERTIFIKAT PKL</div>
            <div class="subjudul">Diberikan Kepada</div>

            <div class="nama">
                {{ strtoupper($esertifikat->peserta_pkl->peserta->user->nama) }}
            </div>

            <div class="jurusan">
                {{ strtoupper($esertifikat->peserta_pkl->peserta->kelas->kompetensi->nama_kompetensi ?? '-') }}
            </div>

            <div class="isi">
                Telah menyelesaikan <b>Praktik Kerja Lapangan (PKL)</b><br>
                di <b>{{ strtoupper($esertifikat->peserta_pkl->dudi->nama_dudi) }}</b><br>
                Periode:
                {{ \Carbon\Carbon::parse($pengaturan->tanggal_mulai_pkl)->translatedFormat('d F Y') }}
                –
                {{ \Carbon\Carbon::parse($pengaturan->tanggal_selesai_pkl)->translatedFormat('d F Y') }}
            </div>

            <div class="tanggal">
                Ditetapkan di Garut, {{ now()->translatedFormat('d F Y') }}
            </div>

            <div class="ttd">
                Kepala Sekolah<br>
                <div class="qr">
                    {!! QrCode::size(80)->generate(url('esertifikat/scan/'.$esertifikat->nomor_sertifikat)) !!}
                </div>
                <b>{{ $pengaturan->kepala_sekolah }}</b>
            </div>

        </div>
    </div>

</div>
</body>
</html>
