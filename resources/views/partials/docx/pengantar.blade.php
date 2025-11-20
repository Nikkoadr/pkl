<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <title>Surat Pengantar PKL</title>
    <link rel="stylesheet" href="{{ asset('assets/dist/css/styles_docx.css') }}?v={{ filemtime(public_path('assets/dist/css/styles_docx.css')) }}" />

  </head>
  <body>
    <!-- Halaman 1 -->
    <div class="page">
      @include('partials.docx.head')

<div class="meta">
  <table>
    <tr>
      <td>Nomor</td>
      <td>: 631.{{ str_pad($dudi->id, 3, '0', STR_PAD_LEFT) }}/III.4.AU/J/{{ date('Y') }}</td>
    </tr>
    <tr>
      <td>Lamp</td>
      <td>: 1 Lembar</td>
    </tr>
    <tr>
      <td>Perihal</td>
      <td><strong>: Pengantar Siswa Pelaksanaan Praktik Kerja Lapangan (PKL)</strong></td>
    </tr>
  </table>
</div>

<p>
  Yth. Bapak/Ibu Pimpinan Dunia Usaha/Dunia Industri<br />
  <strong>{{ $dudi->nama_dudi }}</strong><br />
  di Tempat,
</p>

<p>Dengan hormat,</p>

<p class="indent">
  Berdasarkan penyempurnaan kurikulum yang mengacu pada Undang-undang No. 20 Tahun 2003 tentang Sistem Pendidikan Nasional dan Peraturan Pemerintah No. 19 Tahun 2005 tentang Standar Nasional Pendidikan serta Peraturan Menteri Pendidikan Nasional No. 22 Tahun 2006 tentang Standar Isi dan No. 23 Tahun 2006 tentang Standar Kompetensi Lulusan (SKL), Landasan Hukum: Permendikbud No. 60 Tahun 2014, Lamp 1a.(IIIB.;i) dan Permendikbud No. 61 Tahun 2014 (III.7).
</p>

<p class="indent">
  Dalam rangka pencapaian kurikulum dan peningkatan sumber daya manusia, maka bagi siswa tingkat XI diwajibkan mengikuti program Praktik Kerja Lapangan (PKL) di Dunia Usaha / Industri, guna menambah wawasan sesuai dengan apa yang sudah dipelajari di sekolah.
</p>

<p class="indent">
  Sehubungan dengan hal itu, Kami <strong>SMK Muhammadiyah Kandanghaur – Indramayu</strong> menyampaikan surat pengantar PKL untuk dapat melaksanakan program PKL dengan ketentuan sebagai berikut:
</p>

<table style="font-size: 16px; border-collapse: collapse; margin-bottom: 15px;">
  <colgroup>
    <col style="width: 150px;">
    <col style="width: 15px;">
    <col>
  </colgroup>
  <tr>
    <td>Jumlah Siswa</td>
    <td>:</td>
    <td><strong>{{ $jumlah_siswa }} Siswa</strong></td>
  </tr>
  <tr>
    <td>Alokasi Waktu</td>
    <td>:</td>
    <td><strong>{{ $tanggal_mulai }} s.d {{ $tanggal_selesai }}</strong></td>
  </tr>
</table>

<p class="indent">
  Demikian surat pengantar PKL kami sampaikan. Atas kerjasamanya, kami ucapkan terima kasih.
</p>

  @include('partials.docx.ttd')
    </div>

    <!-- Halaman 2 -->
    <div class="page">
      @include('partials.docx.head')

      <div class="meta">
        <table>
          <tr>
            <td>Nomor</td>
            <td>: 631.{{ str_pad($dudi->id, 3, '0', STR_PAD_LEFT) }}/III.4.AU/J/{{ date('Y') }}</td>
          </tr>
          <tr>
            <td>Lampiran Ke</td>
            <td>: 1</td>
          </tr>
        </table>
      </div>

      <p style="text-align: center; font-weight: bold; font-size: 16px;">
        DAFTAR PESERTA PRAKTIK KERJA LAPANGAN (PKL)<br />
        SMK MUHAMMADIYAH KANDANGHAUR
      </p>

      <p style="margin-bottom: 15px;"><strong>DU/DI:</strong> {{ $dudi->nama_dudi }}</p>
        <table style="width: 99.5%; max-width: 100%; border-collapse: collapse; font-size: 14px; text-transform: uppercase; box-sizing: border-box;">
          <thead>
            <tr style="background-color: #8b8263; color: white;">
              <th style="padding: 6px; border: 1px solid black;">NO</th>
              <th style="padding: 6px; border: 1px solid black;">NAMA SISWA</th>
              <th style="padding: 6px; border: 1px solid black;">TINGKAT</th>
              <th style="padding: 6px; border: 1px solid black;">KOMPETENSI KEAHLIAN</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($peserta as $index => $s)
              <tr>
                <td style="text-align: center; padding: 6px; border: 1px solid black;">{{ $index + 1 }}</td>
                <td style="text-align: center; padding: 6px; border: 1px solid black;">{{ strtoupper($s->user->nama ?? '-') }}</td>
                <td style="text-align: center; padding: 6px; border: 1px solid black;">{{ strtoupper($s->kelas->nama_kelas ?? '-') }}</td>
                <td style="text-align: center; padding: 6px; border: 1px solid black;">{{ strtoupper($s->kelas->kompetensi->nama_kompetensi ?? '-') }}</td>
              </tr>
            @endforeach
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
