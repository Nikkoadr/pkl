<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <title>Surat Booking PKL</title>
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
            <td>: 631.{{ str_pad($dudi->id, 3, '0', STR_PAD_LEFT) }}/III.4.AU/J/{{ date('Y') }}
          </tr>
          <tr>
            <td>Lamp</td>
            <td>: -</td>
          </tr>
          <tr>
            <td>Perihal</td>
            <td><strong>: Permohonan Booking Tempat PKL Tahun 2026</strong></td>
          </tr>
        </table>
      </div>

      <p>
        Yth. Bapak/Ibu Pimpinan<br />
        <strong>{{ $dudi->nama_dudi }}</strong><br />
        di Tempat
      </p>

      <p>Dengan hormat,</p>

      <p class="indent">
        Dalam rangka persiapan kegiatan Praktik Kerja Lapangan (PKL) Tahun Ajaran 2025/2026 bagi siswa kelas XI Konsentrasi Keahlian {{ $kompetensi }}, 
        kami bermaksud mengajukan permohonan booking tempat PKL untuk pelaksanaan yang direncanakan mulai:
      </p>

      <table style="font-size: 16px; border-collapse: collapse; margin-bottom: 15px;">
        <colgroup>
          <col style="width: 150px;">
          <col style="width: 15px;">
          <col>
        </colgroup>
        <tr>
          <td>Hari, Tanggal</td>
          <td>:</td>
          <td><strong>3 Agustus 2026 - 30 November 2026</strong></td>
        </tr>
        <tr>
          <td>Waktu Pelaksanaan</td>
          <td>:</td>
          <td><strong>4 Bulan</strong></td>
        </tr>
      </table>

      <p class="indent">
        Kegiatan PKL ini bertujuan memberikan pengalaman kerja yang relevan bagi peserta didik agar memiliki kompetensi dan etos kerja 
        sesuai kebutuhan dunia usaha dan dunia industri. Sehubungan dengan hal tersebut, kami memohon kesediaan {{ $dudi->nama_dudi }} 
        untuk menerima serta membimbing siswa kami selama pelaksanaan PKL tersebut.
      </p>

      <p>
        Untuk konfirmasi kesediaan peserta didik PKL, Bapak/Ibu dapat
        menghubungi panitia PKL: <strong>081322584428 (Rizky)</strong>.
      </p>

      <p>
        Demikian permohonan kami. Atas perhatian dan kerja sama Bapak/Ibu, kami
        ucapkan terima kasih.
      </p>
    @include('partials.docx.ttd')
    </div>
    <script>
  window.onload = function () {
    window.print();
  };
</script>
  </body>
</html>
