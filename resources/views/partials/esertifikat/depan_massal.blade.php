<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Cetak Sertifikat PKL</title>
        <link rel="icon" type="image/x-icon" href="{{ asset('assets/dist/img/about.png') }}">
        <!-- Font Nama -->
        <link href="https://fonts.googleapis.com/css2?family=Story+Script&display=swap" rel="stylesheet">
        <link rel="stylesheet"href="{{ asset('assets/dist/css/styles_sertifikat.css') }}?v={{ filemtime(public_path('assets/dist/css/styles_sertifikat.css')) }}">
        <style>
            .page {
                margin: 0 auto 20px auto;!important
            }
        </style>
    </head>
    <body>
        <div class="print-wrapper">

            @foreach ($data as $row)
                <div class="page">

                    <div class="nomor">
                        Nomor: {{ $row->nomor_sertifikat
                            ?? '086.' . str_pad($row->id, 3, '0', STR_PAD_LEFT) . '/KET/III.4/AU/F/' . date('Y') }}
                    </div>

                    <div class="judul">Sertifikat ini diberikan kepada :</div>

                    <div class="nama">{{ strtoupper($row->peserta_pkl->peserta->user->nama ?? '-') }}</div>

                    <div class="jurusan">
                        ({{ strtoupper($row->peserta_pkl->peserta->kelas->kompetensi->nama_kompetensi ?? '-') }})
                    </div>

                    <div class="isi">
                        Yang telah menyelesaikan <br>
                        <b>PRAKTIK KERJA LAPANGAN (PKL)</b><br>
                        di <b>{{ strtoupper($row->peserta_pkl->dudi->nama_dudi ?? '-') }}</b>
                    </div>

                    <div class="tanggal">
                        dari tanggal
                        {{ \Carbon\Carbon::parse($row->tanggal_mulai_pkl)->locale('id')->translatedFormat('d F Y') }}
                        sampai
                        {{ \Carbon\Carbon::parse($row->tanggal_selesai_pkl)->locale('id')->translatedFormat('d F Y') }}
                    </div>

                    <div class="foto">
                        <img src="{{ $row->foto }}" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>

                <div class="area-ttd">
                    <div class="ttd-box">
                        <div class="ttd-row">
                            <div class="ttd-barcode">
                                <img src="data:image/png;base64,{{ $row->qrWithLogo }}" alt="QR Code">
                            </div>
                            <div class="ttd-text">
                                <div class="ttd-atas">
                                    Ditandatangani secara elektronik oleh:<br>
                                    Kepala Sekolah <br>
                                    SMK Muhammadiyah Kandanghaur
                                </div>
                                <hr>
                                <div class="ttd-nama">
                                    {{ $row->kepala_sekolah }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                </div>
            @endforeach

        </div>

        <script>
            window.onload = () => window.print();
        </script>
    </body>
</html>
