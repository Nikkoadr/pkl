<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Penilaian Peserta Praktik Kerja Lapangan (PKL)</title>
    <style>
        body { font-family: "Times New Roman", serif; font-size: 12pt; margin: 0; padding: 40px 0; background-color: #e0e0e0; display: flex; justify-content: center; flex-direction: column;
            align-items: center;}
        .a4-paper { background-color: white; width: 210mm; min-height: 297mm; padding: 30px 40px; box-shadow: 0 0 10px rgba(0,0,0,0.2); box-sizing: border-box; }
        h2, h3 { margin-bottom: 5px; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 15px; font-size: 12pt; }
        th, td { border: 1px solid black; padding: 4px 6px; vertical-align: middle; }
        th { background-color: #ffcc00; text-align: center; }
        .no-border { border: none; }
        .header-table td { border: none; padding: 2px 4px; }
        .header-table td:first-child { width: 180px; font-weight: bold; }
        .center { text-align: center; }
        .bold { font-weight: bold; }
        .note { font-size: 10pt; font-style: italic; }
        .signature { width: 300px; float: right; margin-top: 40px; text-align: center; font-size: 12pt; }
        .small-table td, .small-table th { font-size: 10pt; padding: 3px 6px; }
        .underline { text-decoration: underline; }
        @media print {
            body { background-color: white !important; padding: 0; margin: 0; display: block; }
            .a4-paper { box-shadow: none; width: auto; min-height: auto; padding: 0; margin: 0; page-break-after: always; }
        }
    </style>
</head>
<body>
    @php
        $nilai = $peserta_pkl->nilai_pkl->first();
        $rata_sikap = ($nilai->nilai_disiplin_kerja + $nilai->nilai_kemajuan_kerja + $nilai->nilai_kualitas_kerja + $nilai->nilai_inisiatif_kreatifitas + $nilai->nilai_prilaku) / 5;
        $nilai_akhir = ($rata_sikap + $nilai->nilai_sidang_pkl) / 2;
    @endphp
    @if (!function_exists('predikat'))
        @php
            function predikat($n) {
                if ($n >= 90) return 'Sangat Kompeten';
                if ($n >= 80) return 'Kompeten';
                if ($n >= 70) return 'Cukup Kompeten';
                return 'Belum Kompeten';
            }
        @endphp
    @endif
    <div class="a4-paper">
        <h3 class="center bold">PENILAIAN PESERTA PRAKTIK KERJA LAPANGAN (PKL)</h3>
        
        <table class="header-table">
            <tr>
                <td>Konsentrasi Keahlian</td>
                <td>: {{ $peserta_pkl->peserta->kelas->kompetensi->nama_kompetensi }}</td>
            </tr>
            <tr>
                <td>NISN / NIS</td>
                <td>: {{ $peserta_pkl->peserta->nisn }} / {{ $peserta_pkl->peserta->nis }}</td>
            </tr>
            <tr>
                <td>Nama Peserta Didik</td>
                <td>: {{ $peserta_pkl->peserta->user->nama }}</td>
            </tr>
            <tr>
                <td>Tempat PKL</td>
                <td>: {{ $peserta_pkl->dudi->nama_dudi }}</td>
            </tr>
            <tr>
                <td>Tempat, Tanggal Lahir</td>
                <td>: {{ $peserta_pkl->peserta->user->tempat_lahir }}, {{ \Carbon\Carbon::parse($peserta_pkl->peserta->user->tanggal_lahir)->locale('id')->translatedFormat('d F Y') }}</td>
            </tr>
        </table>

        <h3 class="bold">A. NILAI SIKAP</h3>
        <table>
            <thead>
                <tr>
                    <th style="width:30px;">No</th>
                    <th>Aspek Yang Di Nilai</th>
                    <th style="width:70px;">Angka</th>
                    <th style="width:120px;">Predikat</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="center">1</td>
                    <td>Disiplin Kerja</td>
                    <td class="center">{{ $nilai->nilai_disiplin_kerja }}</td>
                    <td class="center">{{ predikat($nilai->nilai_disiplin_kerja) }}</td>
                </tr>
                <tr>
                    <td class="center">2</td>
                    <td>Kemajuan Kerja dan Motivasi</td>
                    <td class="center">{{ $nilai->nilai_kemajuan_kerja }}</td>
                    <td class="center">{{ predikat($nilai->nilai_kemajuan_kerja) }}</td>
                </tr>
                <tr>
                    <td class="center">3</td>
                    <td>Kualitas Kerja</td>
                    <td class="center">{{ $nilai->nilai_kualitas_kerja }}</td>
                    <td class="center">{{ predikat($nilai->nilai_kualitas_kerja) }}</td>
                </tr>
                <tr>
                    <td class="center">4</td>
                    <td>Inisiatif dan Kreatifitas</td>
                    <td class="center">{{ $nilai->nilai_inisiatif_kreatifitas }}</td>
                    <td class="center">{{ predikat($nilai->nilai_inisiatif_kreatifitas) }}</td>
                </tr>
                <tr>
                    <td class="center">5</td>
                    <td>Perilaku / Sikap</td>
                    <td class="center">{{ $nilai->nilai_prilaku }}</td>
                    <td class="center">{{ predikat($nilai->nilai_prilaku) }}</td>
                </tr>
            </tbody>
        </table>

        <h3 class="bold">B. NILAI KOMPETENSI</h3>
        <table>
            <thead>
                <tr>
                    <th style="width:30px;">No</th>
                    <th>Kompetensi yang di uji</th>
                    <th colspan="2" style="background-color:#f5a700; text-align:center;">Nilai Perolehan</th>
                </tr>
                <tr>
                    <th></th>
                    <th></th>
                    <th style="width:70px;">Angka</th>
                    <th style="width:120px;">Predikat</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="center">1</td>
                    <td>Nilai rata-rata sikap</td>
                    <td class="center">{{ number_format($rata_sikap, 0) }}</td>
                    <td class="center">{{ predikat($rata_sikap) }}</td>
                </tr>
                <tr>
                    <td class="center">2</td>
                    <td>Nilai sidang laporan PKL</td>
                    <td class="center">{{ $nilai->nilai_sidang_pkl }}</td>
                    <td class="center">{{ predikat($nilai->nilai_sidang_pkl) }}</td>
                </tr>
                <tr>
                    <td colspan="2" class="bold" style="text-align:right;">Nilai Akhir :</td>
                    <td colspan="2" class="center bold">{{ number_format($nilai_akhir, 0) }}</td>
                </tr>
                <tr>
                    <td colspan="2" class="bold" style="text-align:right;">Predikat :</td>
                    <td colspan="2" class="center bold">{{ predikat($nilai_akhir) }}</td>
                </tr>
                <tr>
                    <td  colspan="4" class="note" style="font-size: 11pt;">
                        <b>Catatan :</b><br />
                        {{ $nilai->komentar }}
                    </td>
                </tr>
            </tbody>
        </table>
        <br />
        <br />
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-top: 10px;">
            <table class="small-table" style="width: 250px; border: 1px solid black; text-align: center;">
                <thead>
                    <tr>
                        <th>Nilai</th>
                        <th>Predikat</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>90 - 100</td><td>Sangat Kompeten</td></tr>
                    <tr><td>80 - 89</td><td>Kompeten</td></tr>
                    <tr><td>70 - 79</td><td>Cukup Kompeten</td></tr>
                    <tr><td>0 - 69</td><td>Belum Kompeten</td></tr>
                </tbody>
            </table>

            <div class="signature" style="text-align: center; margin-top: 0;">
                {{ $peserta_pkl->dudi->jabatan_pimpinan ?? 'Kepala / Teknisi / Mekanik,' }},<br />
                {{ $peserta_pkl->dudi->nama_dudi }}<br /><br /><br /><br /><br />
                {!! $peserta_pkl->dudi->nama_pimpinan_dudi 
                    ? '<strong>' . e($peserta_pkl->dudi->nama_pimpinan_dudi) . '</strong>' 
                    : '............................................' !!}
            </div>
        </div>

    </div>
<script>
    window.onload = function () {
        window.print();
    };
</script>
</body>
</html>
