<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Logbook & Penilaian PKL</title>
<style>
/* ====== RESET DASAR ====== */
body {
    font-family: "Times New Roman", Times, serif;
    font-size: 14px;
    color: #000;
    margin: 0;
    padding: 0;
    background: #fff;
}

/* ====== FORMAT HALAMAN ====== */
.page {
    width: 210mm;
    min-height: 297mm;
    padding: 5mm;              /* disamakan padding-nya */
    margin: 5mm auto;          /* margin seimbang atas-bawah */
    background: white;
    border: 1px solid #ccc;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    position: relative;
    box-sizing: border-box;
}

/* ====== MODE CETAK ====== */
@media print {
    @page {
        size: A4;
        margin: 5mm;           /* margin halaman sama seperti tampilan layar */
    }

    body {
        background: none;
        margin: 0;
        padding: 0;
    }

    .page {
        margin: 0;
        padding: 5mm;          /* padding tetap sama */
        border: none;
        box-shadow: none;
        page-break-after: always;
    }
}

/* ====== HEADING / TITLE ====== */
.form-title {
    text-align: center;
    font-weight: bold;
    font-size: 18px;
    text-transform: uppercase;
    margin-bottom: 15px;
    padding-bottom: 5px;
}

/* ====== TABEL UMUM ====== */
.form-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
    text-align: center; /* Semua tabel isi tengah */
    font-size: 14px;
}

.form-table td,
.form-table th {
    border: 1px solid #000;
    padding: 6px 8px;
    vertical-align: middle;
}

.form-table th {
    background: #f3f3f3;
    font-weight: bold;
}

/* ====== TABEL TANPA BORDER (DATA PESERTA) ====== */
.form-table.info td {
    border: none;
    padding: 4px 2px;
    text-align: left;
}

.form-table.info tr td:first-child {
    width: 180px;
}

/* ====== PARAGRAF ====== */
p {
    text-align: justify;
    line-height: 1.5;
    margin-top: 10px;
    margin-bottom: 10px;
}

/* ====== FOOTER / TANDA TANGAN ====== */
.signature {
    margin-top: 40px;
    text-align: right;
}

/* ====== HEADER SEKOLAH ====== */
.header {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 10px;
}

.header img {
    width: 70px;
    height: 70px;
    margin-right: 15px;
}

.header .title {
    text-align: center;
    font-size: 16px;
    font-weight: bold;
    text-transform: uppercase;
}
</style>

</head>
<body>
    <!-- HALAMAN 1 - REKAP LOGBOOK -->
    <div class="page">
        @include('partials.docx.head')

        <div class="form-title">
            REKAP KEGIATAN<br />
            PESERTA PRAKTIK KERJA LAPANGAN (PKL)
        </div>

        <table class="form-table info">
            <tr>
                <td>Nama Peserta</td>
                <td>: <strong>{{ $peserta->user->nama }}</strong></td>
            </tr>
            <tr>
                <td>Kelas / Kompetensi</td>
                <td>: {{ $peserta->kelas->nama_kelas }}</td>
            </tr>
            <tr>
                <td>Nama DUDI</td>
                <td>: {{ $peserta_pkl->dudi->nama_dudi }}</td>
            </tr>
            <tr>
                <td>Periode PKL</td>
                <td>: {{ \Carbon\Carbon::parse($tanggal_mulai)->translatedFormat('d F Y') }} 
                    s.d 
                    {{ \Carbon\Carbon::parse($tanggal_selesai)->translatedFormat('d F Y') }}
                </td>
            </tr>
        </table>

        <br>

        <table class="form-table">
            <thead>
                <tr>
                    <th style="width:40px;">No</th>
                    <th style="width:140px;">Tanggal</th>
                    <th style="width:200px;">Kegiatan</th>
                    <th style="width:100px;">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @php
                    use Carbon\Carbon;
                    $no = 1;
                    $hadir = 0;
                    $alfa = 0;
                    $tanggalIter = Carbon::parse($tanggal_mulai)->copy();
                    $tanggalAkhir = Carbon::parse($tanggal_selesai);
                @endphp

                @while($tanggalIter->lte($tanggalAkhir))
                    @php
                        $log = $logbooks->firstWhere('tanggal', $tanggalIter->toDateString());
                        $isHadir = $log && $log->jam;
                        if ($isHadir) {
                            $hadir++;
                        } else {
                            $alfa++;
                        }
                    @endphp
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $tanggalIter->translatedFormat('d F Y') }}</td>
                        <td>{{ $isHadir ? $log->keterangan : '-' }}</td>
                        <td>{{ $isHadir ? 'H' : 'A' }}</td>
                    </tr>
                    @php $tanggalIter->addDay(); @endphp
                @endwhile

                <tr style="font-weight:bold; border-top:2px solid #000;">
                    <td colspan="3" style="text-align:right;">Total Hadir :</td>
                    <td>{{ $hadir }}</td>
                </tr>
                <tr style="font-weight:bold;">
                    <td colspan="3" style="text-align:right;">Total Alfa :</td>
                    <td>{{ $alfa }}</td>
                </tr>
            </tbody>
        </table>

        <p style="margin-top:20px;">
            Keterangan: <strong>H</strong> = Hadir, <strong>A</strong> = Alfa (tidak mengisi logbook)
        </p>
        <p style="text-align:right; margin-top:40px;">
            ....................,....... {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('F Y') }}<br>
            Pimpinan / Pembimbing DUDI,<br><br><br><br>
            _________________________<br>
        </p>
    </div>

    <!-- HALAMAN 2 - PENILAIAN KINERJA -->
    <div class="page">
        @include('partials.docx.head')

        <div class="form-title">
            PENILAIAN KINERJA PESERTA<br />
            PRAKTIK KERJA LAPANGAN (PKL)
        </div>

        <p>
            Berdasarkan hasil kegiatan PKL dan rekap logbook peserta di halaman sebelumnya,
            mohon kepada pihak <strong>{{ $peserta_pkl->dudi->nama_dudi }}</strong> untuk mengisi penilaian
            terhadap kinerja peserta berikut ini.
        </p>
        <table class="form-table info">
            <tr>
                <td>Nama Peserta</td>
                <td>: <strong>{{ $peserta->user->nama }}</strong></td>
            </tr>
            <tr>
                <td>Kelas</td>
                <td>: {{ $peserta->kelas->nama_kelas }}</td>
            </tr>

        </table>
        <table class="form-table">
            <thead>
                <tr>
                    <th style="width:40px;">No</th>
                    <th>Aspek Penilaian</th>
                    <th style="width:150px;">Nilai (0–100)</th>
                </tr>
            </thead>
            <tbody>
                <tr><td>1</td><td>Disiplin Kerja</td><td></td></tr>
                <tr><td>2</td><td>Kemajuan Kerja</td><td></td></tr>
                <tr><td>3</td><td>Kualitas Kerja</td><td></td></tr>
                <tr><td>4</td><td>Inisiatif dan Kreativitas</td><td></td></tr>
                <tr><td>5</td><td>Perilaku dan Sikap Kerja</td><td></td></tr>
            </tbody>
        </table>

        <p>
            Nilai di atas akan digunakan sebagai dasar penilaian akhir PKL peserta.
            Kami sangat mengharapkan objektivitas dari pihak DUDI dalam memberikan penilaian.
        </p>

        <p style="text-align:right; margin-top:40px;">
            ....................,....... {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('F Y') }}<br>
            Pimpinan / Pembimbing DUDI,<br><br><br><br>
            _________________________<br>
        </p>
    </div>

    <script>
        window.onload = function () {
            window.print();
        };
    </script>
</body>
</html>
