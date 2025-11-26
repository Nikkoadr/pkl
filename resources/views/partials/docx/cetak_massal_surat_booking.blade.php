<!DOCTYPE html>
<html lang="id">
    <head>
    <meta charset="UTF-8" />
    <title>Surat Booking PKL Massal</title>
    </head>
    <body>
    @foreach ($data as $item)
        @php
        $dudi = $item['dudi'];
        $kompetensi = $item['kompetensi'];
        @endphp

        @include('partials.docx.booking', [
            'dudi' => $dudi,
            'kompetensi' => $kompetensi,
        ])
    @endforeach
</body>
</html>
