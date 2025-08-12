<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Sertifikat PKL Massal</title>
</head>
<body>
    @foreach ($data as $peserta_pkl)
            @include('partials.esertifikat.belakang', [
                'peserta' => $peserta_pkl,
                'pengaturan' => $pengaturan
            ])
    @endforeach
</body>
</html>
