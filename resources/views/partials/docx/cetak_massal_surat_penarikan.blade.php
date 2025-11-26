<!DOCTYPE html>
<html lang="id">
    <head>
    <meta charset="UTF-8" />
    <title>Surat Penarikan PKL Massal</title>
    </head>
    <body>
    @foreach ($data as $item)
        @php
        $dudi = $item['dudi'];
        @endphp

        @include('partials.docx.penarikan', [
            'dudi' => $dudi,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_selesai' => $tanggal_selesai
        ])
    @endforeach
</body>
</html>
