<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Tidak Valid!</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { background: #fdf2f2; font-family: 'Inter', sans-serif; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
        .error-card { background: white; padding: 40px; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); text-align: center; max-width: 400px; border-top: 8px solid #dc2626; }
        .icon { font-size: 60px; color: #dc2626; margin-bottom: 20px; }
        h1 { color: #991b1b; margin-bottom: 10px; font-size: 24px; }
        p { color: #4b5563; line-height: 1.6; margin-bottom: 25px; }
        .btn { background: #dc2626; color: white; padding: 12px 25px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: 0.3s; display: inline-block; }
        .btn:hover { background: #b91c1c; transform: translateY(-2px); }
    </style>
</head>
<body>
    <div class="error-card">
        <div class="icon">⚠️</div>
        <h1>Data Tidak Ditemukan!</h1>
        <p>Maaf, sertifikat dengan kode keamanan tersebut tidak terdaftar di sistem kami atau data telah dianulir.</p>
        <p style="font-size: 13px; color: #9ca3af;">Pastikan Anda memindai kode QR asli yang diterbitkan oleh SMK Muhammadiyah Kandanghaur.</p>
        <a href="/" class="btn">Kembali ke Beranda</a>
    </div>
</body>
</html>