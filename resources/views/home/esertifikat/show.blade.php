<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Verifikasi Sertifikat PKL - {{ $esertifikat->nomor_sertifikat }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Story+Script&family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    {{-- CSS Original Sertifikat --}}
    <link rel="stylesheet" href="{{ asset('assets/dist/css/styles_sertifikat.css') }}" />

    <style>
        body {
            margin: 0;
            background: #f4f6f9;
            font-family: 'Inter', sans-serif;
        }

        .wrapper {
            max-width: 1400px;
            margin: 30px auto;
            display: grid;
            grid-template-columns: 380px 1fr;
            gap: 24px;
            padding: 0 20px;
        }

        /* PANEL STATUS KIRI */
        .status-panel {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,.08);
            height: fit-content;
            position: sticky;
            top: 20px;
        }

        .status-header {
            background: #e9f7ef;
            padding: 15px 20px;
            font-weight: 700;
            color: #198754;
            font-size: 14px;
            border-bottom: 1px solid #d1f3e0;
        }

        .status-body { padding: 25px; }

        .icon-valid { text-align: center; margin-bottom: 15px; }
        .icon-valid span {
            display: inline-block;
            width: 56px;
            height: 56px;
            background: #d1f3e0;
            border-radius: 50%;
            line-height: 56px;
            font-size: 28px;
            color: #198754;
        }

        .doc-sah { text-align: center; font-weight: 700; font-size: 20px; color: #1f2937; }
        .doc-desc { text-align: center; font-size: 13px; color: #6b7280; margin-top: 6px; line-height: 1.5; }

        .info { margin-top: 25px; border-top: 1px dashed #e5e7eb; padding-top: 20px; }
        .info-row { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 13px; }
        .info-row span { color: #6b7280; }
        .info-row strong { color: #111827; text-align: right; margin-left: 10px; }

        .box-valid {
            background: #f0fdf4;
            padding: 15px;
            border: 1px solid #bbf7d0;
            border-radius: 10px;
            margin-top: 20px;
            font-size: 13px;
            color: #166534;
        }

        .fingerprint {
            background: #ffffff;
            padding: 10px;
            font-family: 'Monaco', 'Consolas', monospace;
            font-size: 10px;
            border: 1px solid #dcfce7;
            border-radius: 6px;
            word-break: break-all;
            margin-top: 8px;
            color: #15803d;
        }

        .signer {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            margin-top: 20px;
            font-size: 13px;
            border-left: 4px solid #4f46e5;
        }

        .login-btn {
            margin-top: 20px;
            display: block;
            text-align: center;
            background: #4f46e5;
            color: #fff;
            padding: 14px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
        }
        .login-btn:hover { background: #4338ca; }

        /* AREA SERTIFIKAT KANAN */
        .sertifikat-area {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,.08);
            padding: 40px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 800px;
            overflow-x: auto;
        }

        .sertifikat-area .page {
            margin: 0 !important;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<div class="wrapper">

    <div class="status-panel">
        <div class="status-header">VERIFIKASI SISTEM</div>

        <div class="status-body">
            <div class="icon-valid">
                <span>✓</span>
            </div>

            <div class="doc-sah">Dokumen Valid</div>
            <div class="doc-desc">
                Sertifikat ini terdaftar dalam sistem resmi <br>
                <strong>SMK Muhammadiyah Kandanghaur</strong>
            </div>

            <div class="info">
                <div class="info-row">
                    <span>Nama Peserta</span>
                    <strong>{{ strtoupper($esertifikat->peserta_pkl->peserta->user->nama) }}</strong>
                </div>
                <div class="info-row">
                    <span>Nomor Sertifikat</span>
                    <strong>{{ $esertifikat->nomor_sertifikat }}</strong>
                </div>
                <div class="info-row">
                    <span>Tanggal Terbit</span>
                    <strong>{{ \Carbon\Carbon::parse($esertifikat->tanggal_diterbitkan)->translatedFormat('d F Y') }}</strong>
                </div>
            </div>

            <div class="box-valid">
                <strong>Integritas Digital:</strong><br>
                Sidik jari (SHA256) ini membuktikan bahwa data yang Anda lihat asli dari database kami.
                <div class="fingerprint">
                    {{-- Hash ini dibuat dari nomor sertifikat --}}
                    {{ $esertifikat->url_hash }}
                </div>
            </div>

            <div class="signer">
                <strong>Penanda Tangan:</strong><br>
                <strong>{{ $pengaturan->kepala_sekolah }}</strong><br>
                <span style="color: #6b7280; font-size: 12px;">Kepala SMK Muhammadiyah Kandanghaur</span>
            </div>

            <a href="{{ route('login') }}" class="login-btn">
                Login ke Sistem
            </a>
        </div>
    </div>

    <div class="sertifikat-area">
        
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
                Sertifikat ini diberikan pada tanggal {{ \Carbon\Carbon::parse($esertifikat->tanggal_diterbitkan)->locale('id')->translatedFormat('j F Y') }}
            </div>

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
                    {{-- Menggunakan URL HASH SHA256 dari database --}}
                    {!! QrCode::size(80)->generate(url('/esertifikat/scan/' . $esertifikat->url_hash)) !!}
                </div>

                <div class="nama-ttd">{{ $pengaturan->kepala_sekolah }}</div>
            </div>
        </div>

    </div>
</div>

</body>
</html>