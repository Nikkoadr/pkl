<!DOCTYPE html>
<html lang="id">
    <head>
    <meta charset="UTF-8" />
    <title>Surat Permohonan PKL Massal</title>
    </head>
    <body>
    @foreach ($data as $item)
        @php
        $dudi = $item['dudi'];
        $peserta = $item['peserta'];
        $kompetensi = $item['kompetensi'];
        @endphp

        @include('partials.docx.permohonan', [
            'dudi' => $dudi,
            'peserta' => $peserta,
            'kompetensi' => $kompetensi,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_selesai' => $tanggal_selesai
        ])
    @endforeach
</body>
</html>
