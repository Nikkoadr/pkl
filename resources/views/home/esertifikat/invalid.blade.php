<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Tidak Valid / Tidak Ditemukan</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/dist/img/about.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --danger: #dc3545; /* Merah untuk Invalid */
            --bg-body: #f8fafc;
            --text-main: #1e293b;
            --text-muted: #64748b;
        }

        * { box-sizing: border-box; }

        body { 
            margin: 0; 
            background: var(--bg-body); 
            font-family: 'Inter', sans-serif; 
            color: var(--text-main); 
            line-height: 1.5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .status-panel {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            max-width: 450px;
            width: 100%;
            border: 1px solid #fee2e2;
            overflow: hidden;
        }

        .status-header {
            background: #fef2f2;
            padding: 18px 25px;
            font-weight: 700;
            color: var(--danger);
            font-size: 13px;
            letter-spacing: 0.05em;
            border-bottom: 1px solid #fecaca;
            display: flex;
            align-items: center;
            gap: 8px;
            text-transform: uppercase;
        }

        .status-body { padding: 40px 30px; text-align: center; }
        
        .icon-invalid { margin-bottom: 25px; }
        .icon-invalid span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 80px; height: 80px;
            background: #fef2f2;
            border-radius: 50%;
            font-size: 40px;
            color: var(--danger);
            box-shadow: 0 0 0 10px #fff5f5;
            border: 2px solid #fecaca;
        }

        .doc-status { font-weight: 800; font-size: 24px; color: #0f172a; margin-bottom: 10px; }
        .doc-desc { font-size: 15px; color: var(--text-muted); margin-bottom: 30px; }

        .warning-box {
            background: #fff5f5;
            border-radius: 12px;
            padding: 20px;
            text-align: left;
            border: 1px dashed var(--danger);
        }

        .warning-box p {
            margin: 0;
            font-size: 14px;
            color: #7f1d1d;
            line-height: 1.6;
        }

        .back-btn {
            margin-top: 30px; 
            display: block; 
            text-align: center;
            background: #1e293b; 
            color: #fff; 
            padding: 14px;
            border-radius: 10px; 
            text-decoration: none; 
            font-weight: 600;
            transition: all 0.2s;
        }

        .back-btn:hover {
            background: #0f172a;
            transform: translateY(-2px);
        }

        /* Responsive */
        @media (max-width: 480px) {
            .status-body { padding: 30px 20px; }
            .doc-status { font-size: 20px; }
        }
    </style>
</head>
<body>

    <div class="status-panel">
        <div class="status-header">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1l.05-4.006h1.7l.05 4.006h-1.8z"/>
            </svg>
            SISTEM VERIFIKASI GAGAL
        </div>
        
        <div class="status-body">
            <div class="icon-invalid">
                <span>✕</span>
            </div>
            
            <div class="doc-status">Dokumen Tidak Valid</div>
            <div class="doc-desc">Data sertifikat tidak ditemukan atau kode verifikasi salah.</div>

            <div class="warning-box">
                <p>
                    <strong>Mengapa ini terjadi?</strong><br>
                    1. Kode QR atau URL Hash tidak terdaftar di database kami.<br>
                    2. Dokumen mungkin telah dimodifikasi secara ilegal.<br>
                    3. Masa berlaku dokumen telah berakhir (jika ada).
                </p>
            </div>

            <p style="font-size: 13px; color: var(--text-muted); margin-top: 25px;">
                Jika Anda merasa ini adalah kesalahan teknis, silakan hubungi bagian administrasi SMK Muhammadiyah Kandanghaur.
            </p>

            <a href="/" class="back-btn">Kembali ke Beranda</a>
        </div>
    </div>

</body>
</html>