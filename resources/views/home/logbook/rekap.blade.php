<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Logbook PKL</title>
    <link rel="stylesheet" href="{{ asset('assets/dist/css/styles_docx.css') }}" />
</head>
<body>
    <div class="page">
        @include('partials.docx.head')

        <div class="form-title">
            REKAP KEGIATAN<br />
            PESERTA PRAKTIK KERJA LAPANGAN (PKL)
        </div>

        <table class="form-table">
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

        <table class="form-table" style="text-align:center; font-size:14px; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="width:40px;">No</th>
                    <th style="width:140px;">Tanggal</th>
                    <th style="width:100px;">Jam</th>
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
                        <td>
                            @if($isHadir)
                                {{ Carbon::parse($log->jam)->format('H:i') }}
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $isHadir ? 'H' : 'A' }}</td>
                    </tr>

                    @php
                        $tanggalIter->addDay();
                    @endphp
                @endwhile

                {{-- Total hadir & alfa --}}
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
    </div>

    <script>
        window.onload = function () {
            window.print();
        };
    </script>
</body>
</html>
