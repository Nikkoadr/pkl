<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Verifikasi Sertifikat PKL</title>

    <link href="https://fonts.googleapis.com/css2?family=Story+Script&family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            background: #f4f6f9;
            font-family: 'Inter', sans-serif;
        }

        .wrapper {
            max-width: 1300px;
            margin: 30px auto;
            display: grid;
            grid-template-columns: 360px 1fr;
            gap: 24px;
        }

        /* =========================
           PANEL STATUS DOKUMEN
        ========================== */
        .status-panel {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,.08);
        }

        .status-header {
            background: #e9f7ef;
            padding: 12px 16px;
            font-weight: 700;
            color: #198754;
            font-size: 14px;
        }

        .status-body {
            padding: 20px;
        }

        .icon-valid {
            text-align: center;
            margin-bottom: 10px;
        }

        .icon-valid span {
            display: inline-block;
            width: 48px;
            height: 48px;
            background: #d1f3e0;
            border-radius: 50%;
            line-height: 48px;
            font-size: 22px;
            color: #198754;
            font-weight: bold;
        }

        .doc-sah {
            text-align: center;
            font-weight: 700;
            font-size: 18px;
        }

        .doc-desc {
            text-align: center;
            font-size: 13px;
            color: #6c757d;
            margin-top: 4px;
        }

        .info {
            margin-top: 16px;
            font-size: 13px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 6px;
        }

        .info-row span {
            color: #6c757d;
        }

        .box-valid {
            background: #e9f7ef;
            padding: 12px;
            border-radius: 8px;
            margin-top: 16px;
            font-size: 13px;
        }

        .fingerprint {
            background: #f1f3f5;
            padding: 10px;
            font-family: monospace;
            font-size: 11px;
            border-radius: 6px;
            word-break: break-all;
            margin-top: 6px;
        }

        .signer {
            background: #f8f9fa;
            padding: 12px;
            border-radius: 8px;
            margin-top: 16px;
            font-size: 13px;
        }

        .login-btn {
            margin-top: 16px;
            display: block;
            text-align: center;
            background: #4f46e5;
            color: #fff;
            padding: 12px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
        }

        /* =========================
           AREA SERTIFIKAT
        ========================== */
        .sertifikat-area {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,.08);
            padding: 20px;
        }
    </style>
</head>
<body>

<div class="wrapper">

    <!-- =========================
         KIRI : STATUS DOKUMEN
    ========================== -->
    <div class="status-panel">
        <div class="status-header">STATUS DOKUMEN</div>

        <div class="status-body">

            <div class="icon-valid">
                <span>✓</span>
            </div>

            <div class="doc-sah">Dokumen Sah</div>
            <div class="doc-desc">
                Telah ditandatangani secara elektronik (TTE Lokal)
            </div>

            <div class="info">
                <div class="info-row">
                    <span>Nomor Dokumen</span>
                    <strong>{{ $esertifikat->nomor_sertifikat }}</strong>
                </div>
                <div class="info-row">
                    <span>Tanggal Terbit</span>
                    <strong>{{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }}</strong>
                </div>
                <div class="info-row">
                    <span>ID Validasi</span>
                    <strong>{{ substr(sha1($esertifikat->nomor_sertifikat), 0, 8) }}</strong>
                </div>
            </div>

            <div class="box-valid">
                <strong>Status: VALID & UTUH</strong><br>
                ✔ Integritas Data Terverifikasi
                <div class="fingerprint">
                    {{ hash('sha256', $esertifikat->nomor_sertifikat) }}
                </div>
            </div>

            <div class="signer">
                <strong>Informasi Penanda Tangan</strong><br><br>
                {{ $pengaturan->kepala_sekolah }}<br>
                <small>Kepala Sekolah</small><br>
                <small>SMK Muhammadiyah Kandanghaur</small>
            </div>

            <a href="{{ route('login') }}" class="login-btn">
                Login ke Sistem Sekolah
            </a>
        </div>
    </div>

    <!-- =========================
         KANAN : SERTIFIKAT ASLI
         (TIDAK DIUBAH)
    ========================== -->
    <div class="sertifikat-area">

        <h1>bakekok</h1>

    </div>

</div>

</body>
</html>
