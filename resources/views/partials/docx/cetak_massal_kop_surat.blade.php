<!DOCTYPE html>
<html lang="id">
    <head>
    <meta charset="UTF-8" />
    <title>Kop Surat PKL Massal</title>
    </head>
    <body>
    @foreach ($data as $item)
        @php
        $dudi = $item['dudi'];
        @endphp

        @include('partials.docx.kop_surat', [
            'dudi' => $dudi,
        ])
    @endforeach
</body>
</html>
