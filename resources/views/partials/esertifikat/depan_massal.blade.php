<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Sertifikat PKL Massal (Depan)</title>
</head>
<body>
    @foreach ($data as $esertifikat)
        @include('partials.esertifikat.depan', [
            'esertifikat' => $esertifikat,
            'pengaturan' => $pengaturan
        ])
    @endforeach
</body>
</html>
