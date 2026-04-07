<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Sertifikat PKL - {{ $esertifikat->nomor_sertifikat }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/dist/img/about.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Story+Script&family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/styles_sertifikat.css') }}?v={{ filemtime(public_path('assets/dist/css/styles_sertifikat.css')) }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/styles_verifikasi.css') }}?v={{ filemtime(public_path('assets/dist/css/styles_verifikasi.css')) }}">
    <style>
        .ttd-box {
            width: 370px;!important
        }
    </style>
</head>

<body>

<div class="wrapper">

    {{-- PANEL KIRI --}}
    <div class="status-panel">
        <div class="status-header">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
            </svg>
            VERIFIKASI SISTEM
        </div>

        <div class="status-body">
            <div class="icon-valid"><span>✓</span></div>
            <div class="doc-sah">Dokumen Valid</div>
            <div class="doc-desc">Data tersertifikasi oleh SMK Muhammadiyah Kandanghaur</div>

            <div class="info">
                <div class="info-row">
                    <span>Nama Lengkap</span>
                    <strong>{{ strtoupper($nama) }}</strong>
                </div>

                <div class="info-row">
                    <span>Nomor Sertifikat</span>
                    <strong>{{ $esertifikat->nomor_sertifikat }}</strong>
                </div>

                <div class="info-row">
                    <span>Tanggal Terbit</span>
                    <strong>
                        {{ $esertifikat->tanggal_diterbitkan
                            ? \Carbon\Carbon::parse($esertifikat->tanggal_diterbitkan)->locale('id')->translatedFormat('d F Y')
                            : '-' }}
                    </strong>
                </div>
            </div>

            <div class="box-valid">
                <strong>Sidik Jari Digital</strong>
                <div class="fingerprint">{{ $esertifikat->hash }}</div>
            </div>

            <div class="info" style="border: none; padding-top: 10px;">
                <div class="info-row">
                    <span>Penanda Tangan</span>
                    <strong>{{ $esertifikat->kepala_sekolah ?? '-' }}</strong>
                    <small style="color: var(--text-muted)">Kepala Sekolah</small>
                </div>
            </div>

            <a href="{{ route('login') }}" class="login-btn">Login ke Sistem</a>
        </div>
    </div>

    {{-- AREA KANAN --}}
    <div class="sertifikat-area">

        {{-- HALAMAN DEPAN --}}
        <div style="width: 100%">
            <div class="section-label">Halaman Depan</div>

            <div class="page-shadow">
                <div class="page">
                    <div class="nomor">
                        Nomor : {{ $esertifikat->nomor_sertifikat ?? $nomorFallback }}
                    </div>

                    <div class="judul">Sertifikat ini diberikan Kepada :</div>

                    <div class="nama">{{ strtoupper($nama) }}</div>

                    <div class="jurusan">
                        ( {{ strtoupper($kompetensi?->nama_kompetensi ?? '-') }} )
                    </div>

                    <div class="isi">
                        Yang telah menyelesaikan <br>
                        <b>PRAKTIK KERJA LAPANGAN (PKL)</b><br>

                        <i>di <b>{{ strtoupper($dudi?->nama_dudi ?? '-') }}</b></i><br>

                        <i>
                            dari tanggal
                            {{ $esertifikat?->tanggal_mulai_pkl
                                ? \Carbon\Carbon::parse($esertifikat->tanggal_mulai_pkl)->locale('id')->translatedFormat('d F Y')
                                : '-' }}
                            sampai dengan
                            {{ $esertifikat?->tanggal_selesai_pkl
                                ? \Carbon\Carbon::parse($esertifikat->tanggal_selesai_pkl)->locale('id')->translatedFormat('d F Y')
                                : '-' }}
                        </i>
                    </div>

                    <div class="foto">
                        <img src="{{ $foto }}" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>

                    <div class="area-ttd">
                        <div class="ttd-box">
                            <div class="ttd-row">
                                <div class="ttd-barcode">
                                    <img src="data:image/png;base64,{{ $qrWithLogo }}" width="85" height="85" style="image-rendering: crisp-edges;">
                                </div>

                                <div class="ttd-text">
                                    <div class="ttd-atas">
                                        Ditandatangani secara elektronik oleh:<br>
                                        Kepala Sekolah <br>
                                        SMK Muhammadiyah Kandanghaur
                                    </div>
                                    <hr>
                                    <div class="ttd-nama">
                                        {{ $esertifikat->kepala_sekolah ?? '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- HALAMAN BELAKANG --}}
        <div style="width: 100%">
            <div class="section-label">Halaman Belakang</div>

            <div class="page-shadow">
                <div class="back-certificate">

                    <h3 class="center bold">PENILAIAN PESERTA PRAKTIK KERJA LAPANGAN (PKL)</h3>

                    <table class="header-table">
                        <tr>
                            <td>Konsentrasi Keahlian</td>
                            <td>: {{ $kompetensi?->nama_kompetensi ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>NISN / NIS</td>
                            <td>: {{ $peserta?->nisn ?? '-' }} / {{ $peserta?->nis ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Nama Peserta Didik</td>
                            <td>: {{ $nama }}</td>
                        </tr>
                        <tr>
                            <td>Tempat PKL</td>
                            <td>: {{ $dudi?->nama_dudi ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Tempat, Tanggal Lahir</td>
                            <td>
                                :
                                {{ $user?->tempat_lahir ?? '-' }},
                                {{ $user?->tanggal_lahir
                                    ? \Carbon\Carbon::parse($user->tanggal_lahir)->locale('id')->translatedFormat('d F Y')
                                    : '-' }}
                            </td>
                        </tr>
                    </table>

                    @if(!$nilai)
                        <div style="padding: 14px; border: 1px dashed #999; border-radius: 8px; margin-top: 12px;">
                            <b>Informasi:</b> Nilai PKL belum tersedia / belum diinput.
                        </div>
                    @else
                        <h3 class="bold">A. NILAI SIKAP</h3>

                        <table>
                            <thead>
                                <tr>
                                    <th style="width:5%;">No</th>
                                    <th style="width:55%;">Aspek Yang Dinilai</th>
                                    <th style="width:15%;">Angka</th>
                                    <th style="width:25%;">Predikat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="center">1</td>
                                    <td>Disiplin Kerja</td>
                                    <td class="center">{{ $nilai->nilai_disiplin_kerja }}</td>
                                    <td class="center">{{ \App\Helpers\EsertifikatHelper::predikat($nilai->nilai_disiplin_kerja) }}</td>
                                </tr>
                                <tr>
                                    <td class="center">2</td>
                                    <td>Kemajuan Kerja dan Motivasi</td>
                                    <td class="center">{{ $nilai->nilai_kemajuan_kerja }}</td>
                                    <td class="center">{{ \App\Helpers\EsertifikatHelper::predikat($nilai->nilai_kemajuan_kerja) }}</td>
                                </tr>
                                <tr>
                                    <td class="center">3</td>
                                    <td>Kualitas Kerja</td>
                                    <td class="center">{{ $nilai->nilai_kualitas_kerja }}</td>
                                    <td class="center">{{ \App\Helpers\EsertifikatHelper::predikat($nilai->nilai_kualitas_kerja) }}</td>
                                </tr>
                                <tr>
                                    <td class="center">4</td>
                                    <td>Inisiatif dan Kreativitas</td>
                                    <td class="center">{{ $nilai->nilai_inisiatif_kreatifitas }}</td>
                                    <td class="center">{{ \App\Helpers\EsertifikatHelper::predikat($nilai->nilai_inisiatif_kreatifitas) }}</td>
                                </tr>
                                <tr>
                                    <td class="center">5</td>
                                    <td>Perilaku / Sikap</td>
                                    <td class="center">{{ $nilai->nilai_perilaku }}</td>
                                    <td class="center">{{ \App\Helpers\EsertifikatHelper::predikat($nilai->nilai_perilaku) }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <h3 class="bold">B. NILAI KOMPETENSI</h3>

                        <table>
                            <thead>
                                <tr>
                                    <th rowspan="2" style="width:5%;">No</th>
                                    <th rowspan="2" style="width:55%;">Kompetensi yang diuji</th>
                                    <th colspan="2" style="background-color:#f5a700; text-align:center;">
                                        Nilai Perolehan
                                    </th>
                                </tr>
                                <tr>
                                    <th style="width:15%;">Angka</th>
                                    <th style="width:25%;">Predikat</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td class="center">1</td>
                                    <td>Nilai rata-rata sikap</td>
                                    <td class="center">{{ $esertifikat->rata_rata !== null ? number_format($esertifikat->rata_rata, 0) : '-' }}</td>
                                    <td class="center">
                                        {{ $esertifikat->rata_rata !== null ? \App\Helpers\EsertifikatHelper::predikat($esertifikat->rata_rata) : '-' }}
                                    </td>
                                </tr>

                                <tr>
                                    <td class="center">2</td>
                                    <td>Nilai sidang laporan PKL</td>
                                    <td class="center">{{ $nilai->nilai_sidang_pkl }}</td>
                                    <td class="center">{{ \App\Helpers\EsertifikatHelper::predikat($nilai->nilai_sidang_pkl) }}</td>
                                </tr>

                                <tr>
                                    <td colspan="2" class="bold" style="text-align:right;">Nilai Akhir :</td>
                                    <td colspan="2" class="center bold">
                                        {{ $esertifikat->nilai_akhir !== null ? number_format($esertifikat->nilai_akhir, 0) : '-' }}
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2" class="bold" style="text-align:right;">Predikat :</td>
                                    <td colspan="2" class="center bold">
                                        {{ $esertifikat->predikat ?? '-' }}
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="4" class="note">
                                        <b>Catatan:</b><br>
                                        {{ $esertifikat->catatan_sikap ?? '-' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-top: 10px;">
                            <table class="small-table" style="width: 250px; border: 1px solid black; text-align: center;">
                                <thead>
                                    <tr>
                                        <th>Nilai</th>
                                        <th>Predikat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td>90 - 100</td><td>Sangat Baik</td></tr>
                                    <tr><td>80 - 89</td><td>Baik</td></tr>
                                    <tr><td>70 - 79</td><td>Cukup Baik</td></tr>
                                    <tr><td>0 - 69</td><td>Belum Baik</td></tr>
                                </tbody>
                            </table>

                            <div class="signature">
                                {{ $dudi?->jabatan_pimpinan ?? 'Kepala / Teknisi / Mekanik,' }}<br />
                                {{ $dudi?->nama_dudi ?? '-' }}<br /><br /><br /><br /><br />
                                <hr>
                                {!! $dudi?->nama_pimpinan_dudi
                                    ? '<strong>' . e($dudi->nama_pimpinan_dudi) . '</strong>'
                                    : '............................................' !!}<br>
                                    {{ $dudi->nomor_kepegawaian }}
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>

    </div>
</div>

</body>
</html>
