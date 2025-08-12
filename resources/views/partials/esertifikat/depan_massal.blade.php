<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Sertifikat PKL Massal</title>
</head>
<body>
    @foreach ($data as $peserta)
            @include('partials.esertifikat.depan', [
                'peserta' => $peserta,
                'pengaturan' => $pengaturan
            ])
    @endforeach
</body>
</html>
