<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Sertifikat PKL - {{ $esertifikat->nomor_sertifikat }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Story+Script&family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/styles_sertifikat.css') }}" />

    <style>
        :root {
            --primary: #4f46e5;
            --success: #198754;
            --bg-body: #f8fafc;
            --text-main: #1e293b;
            --text-muted: #64748b;
        }

        /* PERBAIKAN DASAR: Mencegah elemen meluap keluar layar */
        * { box-sizing: border-box; }

        body { 
            margin: 0; 
            background: var(--bg-body); 
            font-family: 'Inter', sans-serif; 
            color: var(--text-main); 
            line-height: 1.5;
            overflow-x: hidden; /* Mencegah scroll horizontal pada body */
        }

        .wrapper {
            max-width: 1300px;
            margin: 40px auto;
            display: grid;
            grid-template-columns: 360px 1fr;
            gap: 32px;
            padding: 0 20px;
        }

        /* PANEL KIRI: STATUS */
        .status-panel {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            height: fit-content;
            position: sticky;
            top: 20px;
            border: 1px solid #f1f5f9;
        }

        .status-header {
            background: #f0fdf4;
            padding: 18px 25px;
            font-weight: 700;
            color: var(--success);
            font-size: 13px;
            letter-spacing: 0.05em;
            border-bottom: 1px solid #dcfce7;
            border-radius: 16px 16px 0 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .status-body { padding: 30px; }
        .icon-valid { text-align: center; margin-bottom: 20px; }
        .icon-valid span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 64px; height: 64px;
            background: #dcfce7;
            border-radius: 50%;
            font-size: 32px;
            color: var(--success);
            box-shadow: 0 0 0 8px #f0fdf4;
        }

        .doc-sah { text-align: center; font-weight: 800; font-size: 22px; color: #0f172a; }
        .doc-desc { text-align: center; font-size: 14px; color: var(--text-muted); margin-top: 8px; }

        .info { margin-top: 30px; border-top: 1px solid #f1f5f9; padding-top: 25px; }
        .info-row { display: flex; flex-direction: column; margin-bottom: 16px; font-size: 14px; }
        .info-row span { color: var(--text-muted); font-size: 11px; font-weight: 600; text-transform: uppercase; margin-bottom: 4px; }
        .info-row strong { color: #0f172a; font-size: 15px; word-break: break-word; }

        .box-valid {
            background: #f8fafc; padding: 16px;
            border: 1px solid #e2e8f0; border-radius: 12px;
            margin-top: 25px;
        }
        .box-valid strong { font-size: 11px; color: var(--text-muted); text-transform: uppercase; display: block; margin-bottom: 8px; }
        .fingerprint {
            font-family: 'Monaco', 'Consolas', monospace; 
            font-size: 10px;
            word-break: break-all; 
            color: #475569;
            background: #fff;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .login-btn {
            margin-top: 25px; display: block; text-align: center;
            background: var(--primary); color: #fff; padding: 14px;
            border-radius: 10px; text-decoration: none; font-weight: 600;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2);
        }

        /* AREA KANAN: SERTIFIKAT */
        .sertifikat-area { display: flex; flex-direction: column; gap: 40px; }
        .section-label {
            font-weight: 700; font-size: 14px; color: var(--text-muted);
            text-transform: uppercase; display: flex; align-items: center; gap: 10px;
        }
        .section-label::after { content: ""; height: 1px; background: #e2e8f0; flex: 1; }

        .page-shadow {
            background: #fff;
            border-radius: 4px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: fit-content;
            margin: 20px auto;
        }

        /* --- STYLE ASLI SERTIFIKAT BELAKANG --- */
        .back-certificate {
            font-family: "Times New Roman", serif;
            font-size: 12pt;
            background-color: white;
            width: 210mm;
            min-height: 297mm;
            padding: 30px 40px;
            box-sizing: border-box;
            color: #000;
        }
        .back-certificate h3 { margin-bottom: 5px; }
        .back-certificate table { border-collapse: collapse; width: 100%; margin-bottom: 15px; font-size: 12pt; }
        .back-certificate th, .back-certificate td { border: 1px solid black; padding: 4px 6px; vertical-align: middle; }
        .back-certificate th { background-color: #ffcc00; text-align: center; }
        .back-certificate .header-table td { border: none; padding: 2px 4px; }
        .back-certificate .header-table td:first-child { width: 180px; font-weight: bold; }
        .back-certificate .center { text-align: center; }
        .back-certificate .bold { font-weight: bold; }
        .back-certificate .note { font-size: 10pt; font-style: italic; }
        .back-certificate .signature { width: 300px; float: right; margin-top: 40px; text-align: center; font-size: 12pt; }
        .back-certificate .small-table td, .back-certificate .small-table th { font-size: 10pt; padding: 3px 6px; }

        /* RESPONSIVE OPTIMIZATION */
        @media (max-width: 992px) {
            .wrapper { 
                grid-template-columns: 1fr; 
                margin: 20px auto;
            }
            .status-panel { position: relative; top: 0; width: 100%; }
        }

        @media (max-width: 850px) {
            .page-shadow {
                width: 100%;
                background: transparent;
                box-shadow: none;
                display: flex;
                justify-content: center;
                overflow: visible;
            }

            /* Perbaikan Scaling: Menggunakan Zoom agar lebih stabil di HP */
            .page, .back-certificate {
                zoom: 0.42; /* Ukuran zoom disesuaikan otomatis */
                -moz-transform: scale(0.42); /* Support Firefox */
                -moz-transform-origin: top center;
                box-shadow: 0 10px 15px rgba(0,0,0,0.1);
            }
        }

        @media (max-width: 480px) {
            .page, .back-certificate {
                zoom: 0.35;
                -moz-transform: scale(0.35);
            }
            .wrapper { padding: 0 12px; }
            .status-body { padding: 20px; }
            .doc-sah { font-size: 18px; }
            .status-header { padding: 15px; }
        }
    </style>
</head>
<body>

@php
    if (!function_exists('predikat')) {
        function predikat($n) {
            if ($n >= 90) return 'Sangat Kompeten';
            if ($n >= 80) return 'Kompeten';
            if ($n >= 70) return 'Cukup Kompeten';
            return 'Belum Kompeten';
        }
    }
@endphp

<div class="wrapper">
    <div class="status-panel">
        <div class="status-header">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/></svg>
            VERIFIKASI SISTEM
        </div>
        <div class="status-body">
            <div class="icon-valid"><span>✓</span></div>
            <div class="doc-sah">Dokumen Valid</div>
            <div class="doc-desc">Data tersertifikasi oleh SMK Muhammadiyah Kandanghaur</div>

            <div class="info">
                <div class="info-row"><span>Nama Lengkap</span><strong>{{ strtoupper($esertifikat->peserta_pkl->peserta->user->nama) }}</strong></div>
                <div class="info-row"><span>Nomor Sertifikat</span><strong>{{ $esertifikat->nomor_sertifikat }}</strong></div>
                <div class="info-row"><span>Tanggal Terbit</span><strong>{{ \Carbon\Carbon::parse($esertifikat->tanggal_diterbitkan)->translatedFormat('d F Y') }}</strong></div>
            </div>

            <div class="box-valid">
                <strong>Sidik Jari Digital</strong>
                <div class="fingerprint">{{ $esertifikat->url_hash }}</div>
            </div>

            <div class="info" style="border: none; padding-top: 10px;">
                <div class="info-row">
                    <span>Penanda Tangan</span>
                    <strong>{{ $pengaturan->kepala_sekolah }}</strong>
                    <small style="color: var(--text-muted)">Kepala Sekolah</small>
                </div>
            </div>

            <a href="{{ route('login') }}" class="login-btn">Login ke Sistem</a>
        </div>
    </div>

    <div class="sertifikat-area">
        
        <div style="width: 100%">
            <div class="section-label">Halaman Depan</div>
            <div class="page-shadow">
                <div class="page">
                    <div class="nomor">
                        Nomor : {{ $esertifikat->nomor_sertifikat ?? ('086.' . str_pad($esertifikat->id, 3, '0', STR_PAD_LEFT) . '/KET/III.4/AU/F/' . date('Y')) }}
                    </div>
                    <div class="judul">Sertifikat ini diberikan Kepada :</div>
                    <div class="nama">{{ strtoupper($esertifikat->peserta_pkl->peserta->user->nama) }}</div>
                    <div class="jurusan">( {{ strtoupper($esertifikat->peserta_pkl->peserta->kelas->kompetensi->nama_kompetensi ?? '-') }} )</div>
                    <div class="isi">
                        Yang telah menyelesaikan <br>
                        <b>PRAKTIK KERJA LAPANGAN (PKL)</b><br>
                        <i>di <b>{{ strtoupper($esertifikat->peserta_pkl->dudi->nama_dudi ?? '-') }}</b></i><br>
                        <i>dari tanggal {{ \Carbon\Carbon::parse($pengaturan->tanggal_mulai_pkl)->locale('id')->translatedFormat('d F Y') }} sampai dengan {{ \Carbon\Carbon::parse($pengaturan->tanggal_selesai_pkl)->locale('id')->translatedFormat('d F Y') }}</i>
                    </div>
                    <div class="foto">
                        <img src="{{ $esertifikat->peserta_pkl->peserta->user->foto_profil ? asset('storage/foto_profil/' . $esertifikat->peserta_pkl->peserta->user->foto_profil) : asset('assets/dist/img/foto-default.jpeg') }}" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div class="ttd">
                        Kepala SMK Muhammadiyah <br> Kandanghaur,<br>
                        <div class="qr-ttd">
                            {!! QrCode::size(80)->generate(url('/esertifikat/scan/' . $esertifikat->url_hash)) !!}
                        </div>
                        <div class="nama-ttd">{{ $pengaturan->kepala_sekolah }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div style="width: 100%">
            <div class="section-label">Halaman Belakang</div>
            <div class="page-shadow">
                <div class="back-certificate">
                    <h3 class="center bold">PENILAIAN PESERTA PRAKTIK KERJA LAPANGAN (PKL)</h3>
                    <table class="header-table">
                        <tr><td>Konsentrasi Keahlian</td><td>: {{ $esertifikat->peserta_pkl->peserta->kelas->kompetensi->nama_kompetensi }}</td></tr>
                        <tr><td>NISN / NIS</td><td>: {{ $esertifikat->peserta_pkl->peserta->nisn }} / {{ $esertifikat->peserta_pkl->peserta->nis }}</td></tr>
                        <tr><td>Nama Peserta Didik</td><td>: {{ $esertifikat->peserta_pkl->peserta->user->nama }}</td></tr>
                        <tr><td>Tempat PKL</td><td>: {{ $esertifikat->peserta_pkl->dudi->nama_dudi }}</td></tr>
                        <tr><td>Tempat, Tanggal Lahir</td><td>: {{ $esertifikat->peserta_pkl->peserta->user->tempat_lahir }}, {{ \Carbon\Carbon::parse($esertifikat->peserta_pkl->peserta->user->tanggal_lahir)->locale('id')->translatedFormat('d F Y') }}</td></tr>
                    </table>

                    <h3 class="bold">A. NILAI SIKAP</h3>
                    <table>
                        <thead>
                            <tr>
                                <th style="width:30px;">No</th>
                                <th>Aspek Yang Dinilai</th>
                                <th style="width:70px;">Angka</th>
                                <th style="width:120px;">Predikat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td class="center">1</td><td>Disiplin Kerja</td><td class="center">{{ $esertifikat->peserta_pkl->nilai_pkl->nilai_disiplin_kerja }}</td><td class="center">{{ predikat($esertifikat->peserta_pkl->nilai_pkl->nilai_disiplin_kerja) }}</td></tr>
                            <tr><td class="center">2</td><td>Kemajuan Kerja dan Motivasi</td><td class="center">{{ $esertifikat->peserta_pkl->nilai_pkl->nilai_kemajuan_kerja }}</td><td class="center">{{ predikat($esertifikat->peserta_pkl->nilai_pkl->nilai_kemajuan_kerja) }}</td></tr>
                            <tr><td class="center">3</td><td>Kualitas Kerja</td><td class="center">{{ $esertifikat->peserta_pkl->nilai_pkl->nilai_kualitas_kerja }}</td><td class="center">{{ predikat($esertifikat->peserta_pkl->nilai_pkl->nilai_kualitas_kerja) }}</td></tr>
                            <tr><td class="center">4</td><td>Inisiatif dan Kreatifitas</td><td class="center">{{ $esertifikat->peserta_pkl->nilai_pkl->nilai_inisiatif_kreatifitas }}</td><td class="center">{{ predikat($esertifikat->peserta_pkl->nilai_pkl->nilai_inisiatif_kreatifitas) }}</td></tr>
                            <tr><td class="center">5</td><td>Perilaku / Sikap</td><td class="center">{{ $esertifikat->peserta_pkl->nilai_pkl->nilai_perilaku }}</td><td class="center">{{ predikat($esertifikat->peserta_pkl->nilai_pkl->nilai_perilaku) }}</td></tr>
                        </tbody>
                    </table>

                    <h3 class="bold">B. NILAI KOMPETENSI</h3>
                    <table>
                        <thead>
                            <tr>
                                <th style="width:30px;">No</th>
                                <th>Kompetensi yang diuji</th>
                                <th colspan="2" style="background-color:#ffcc00; text-align:center;">Nilai Perolehan</th>
                            </tr>
                            <tr>
                                <th></th><th></th>
                                <th style="width:70px;">Angka</th><th style="width:120px;">Predikat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td class="center">1</td><td>Nilai rata-rata sikap</td><td class="center">{{ number_format($esertifikat->rata_rata, 0) }}</td><td class="center">{{ predikat($esertifikat->rata_rata) }}</td></tr>
                            <tr><td class="center">2</td><td>Nilai sidang laporan PKL</td><td class="center">{{ $esertifikat->peserta_pkl->nilai_pkl->nilai_sidang_pkl }}</td><td class="center">{{ predikat($esertifikat->peserta_pkl->nilai_pkl->nilai_sidang_pkl) }}</td></tr>
                            <tr><td colspan="2" class="bold" style="text-align:right;">Nilai Akhir :</td><td colspan="2" class="center bold">{{ number_format($esertifikat->nilai_akhir, 0) }}</td></tr>
                            <tr><td colspan="2" class="bold" style="text-align:right;">Predikat :</td><td colspan="2" class="center bold">{{ predikat($esertifikat->nilai_akhir) }}</td></tr>
                            <tr><td colspan="4" class="note"><b>Catatan:</b><br>{{ $esertifikat->peserta_pkl->nilai_pkl->komentar }}</td></tr>
                        </tbody>
                    </table>

                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-top: 10px;">
                        <table class="small-table" style="width: 250px; border: 1px solid black; text-align: center;">
                            <thead><tr><th>Nilai</th><th>Predikat</th></tr></thead>
                            <tbody>
                                <tr><td>90 - 100</td><td>Sangat Kompeten</td></tr>
                                <tr><td>80 - 89</td><td>Kompeten</td></tr>
                                <tr><td>70 - 79</td><td>Cukup Kompeten</td></tr>
                                <tr><td>0 - 69</td><td>Belum Kompeten</td></tr>
                            </tbody>
                        </table>
                        <div class="signature">
                            {{ $esertifikat->peserta_pkl->dudi->jabatan_pimpinan ?? 'Kepala / Teknisi / Mekanik,' }}<br />
                            {{ $esertifikat->peserta_pkl->dudi->nama_dudi }}<br /><br /><br /><br /><br />
                            {!! $esertifikat->peserta_pkl->dudi->nama_pimpinan_dudi ? '<strong>' . e($esertifikat->peserta_pkl->dudi->nama_pimpinan_dudi) . '</strong>' : '............................................' !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

</body>
</html>