<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Sertifikat PKL</title>

    <!-- Font Nama -->
    <link href="https://fonts.googleapis.com/css2?family=Story+Script&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/styles_sertifikat.css') }}" />
</head>
<body>

<div class="page">

    <div class="nomor">
        Nomor : {{ $esertifikat->nomor_sertifikat ?? ('086.' . str_pad($esertifikat->id, 3, '0', STR_PAD_LEFT) . '/KET/III.4/AU/F/' . date('Y')) }}
    </div>

    <div class="judul">Sertifikat ini diberikan Kepada :</div>

    <div class="nama">{{ strtoupper($esertifikat->peserta_pkl->peserta->user->nama) }}</div>

    <div class="jurusan">
        ( {{ strtoupper($esertifikat->peserta_pkl->peserta->kelas->kompetensi->nama_kompetensi ?? '-') }} )
    </div>

    <div class="isi">
        Yang telah menyelesaikan <br>
        <b>PRAKTIK KERJA LAPANGAN (PKL)</b><br>
        <i>di <b>{{ strtoupper($esertifikat->peserta_pkl->dudi->nama_dudi ?? '-') }}</b></i><br>
        <i>
            dari tanggal 
            {{ \Carbon\Carbon::parse($pengaturan->tanggal_mulai_pkl)->locale('id')->translatedFormat('d F Y') }} 
            sampai dengan 
            {{ \Carbon\Carbon::parse($pengaturan->tanggal_selesai_pkl)->locale('id')->translatedFormat('d F Y') }}
        </i>
    </div>

    <div class="tanggal">
        Sertifikat ini diberikan pada tanggal {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('j F Y') }}
    </div>

    {{-- Foto --}}
    <div class="foto">
    @if($esertifikat->peserta_pkl->peserta->user->foto_profil)
        <img src="{{ asset('storage/foto_profil/' . $esertifikat->peserta_pkl->peserta->user->foto_profil) }}"
            alt="Foto Peserta"
            style="width: 100%; height: 100%; object-fit: cover;">
    @else
        <img src="{{ asset('assets/dist/img/foto-default.jpeg') }}"
            alt="Foto Default"
            style="width: 100%; height: 100%; object-fit: cover;">
    @endif
</div>

    <div class="ttd">
        Kepala SMK Muhammadiyah <br> Kandanghaur,<br>

        <div class="qr-ttd">
            {!! QrCode::size(80)->generate(url('esertifikat/scan/' . urlencode($esertifikat->nomor_sertifikat))) !!}
        </div>

        <div class="nama-ttd">{{ $pengaturan->kepala_sekolah }}</div>
    </div>

</div>
</body>
</html>
