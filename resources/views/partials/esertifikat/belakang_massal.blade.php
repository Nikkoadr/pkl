<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Sertifikat PKL Massal (Belakang)</title>
</head>
<body>
    @foreach ($data as $esertifikat)
        @include('partials.esertifikat.belakang', [
            'esertifikat' => $esertifikat,
            'pengaturan' => $pengaturan
        ])
    @endforeach
</body>
</html>
