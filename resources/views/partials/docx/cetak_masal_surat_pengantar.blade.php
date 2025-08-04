<!DOCTYPE html>
<html lang="id">
    <head>
    <meta charset="UTF-8" />
    <title>Surat Pengantar PKL Massal</title>
    </head>
    <body>
    @foreach ($data as $item)
        @php
        $dudi = $item['dudi'];
        $peserta = $item['peserta'];
        $kompetensi = $item['kompetensi'];
        $jumlah_siswa = $item['jumlah_siswa'];
        @endphp

        @include('partials.docx.pengantar', [
            'dudi' => $dudi,
            'peserta' => $peserta,
            'kompetensi' => $kompetensi,
            'jumlah_siswa' => $jumlah_siswa,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_selesai' => $tanggal_selesai
        ])
    @endforeach
</body>
</html>
