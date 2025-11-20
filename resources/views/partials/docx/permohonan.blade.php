<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <title>Surat Permohonan PKL</title>
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
            <td>: 1 Lembar</td>
          </tr>
          <tr>
            <td>Perihal</td>
            <td><strong>: Permohonan Praktik Kerja Lapangan (PKL)</strong></td>
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
        Sesuai dengan Undang-undang Peraturan Menteri Pendidikan dan Kebudayaan
        Republik Indonesia Nomor 50 Tahun 2020 Tentang Praktik Kerja Lapangan
        Bagi Peserta Didik, maka Program Kerja SMK Muhammadiyah Kandanghaur
        Tahun Ajaran 2025/2026 khususnya mengenai pelaksanaan kegiatan
        <strong>Praktik Kerja Lapangan (PKL)</strong> untuk siswa Tingkat XI
        <strong>Konsentrasi Keahlian: {{ $kompetensi }}</strong> yang
        Insya Allah akan dilaksanakan pada:
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
          <td><strong>{{ $tanggal_mulai }} s.d {{ $tanggal_selesai}}</strong></td>
        </tr>
        <tr>
          <td>Waktu Pelaksanaan</td>
          <td>:</td>
          <td><strong>3 Bulan</strong></td>
        </tr>
      </table>

      <p class="indent">
        Dalam upaya memberikan pengalaman kerja nyata bagi siswa dalam
        pembentukan kompetensi secara utuh dan bermakna, terutama pembentukan
        sikap kerja sesuai kebutuhan dunia kerja, kami mewajibkan siswa tingkat
        XI untuk mengikuti Program PKL di Dunia Usaha/Industri.
      </p>

      <p class="indent">
        Sehubungan dengan hal tersebut, kami
        <strong>SMK Muhammadiyah Kandanghaur</strong> Kabupaten Indramayu
        memohon kerja sama untuk menerima dan membimbing siswa kami dalam
        pelaksanaan PKL.
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

    <!-- Halaman 2 -->
    <div class="page">
    @include('partials.docx.head')

      <div class="form-title">
        FORM ISIAN KESEDIAAN<br />DUNIA USAHA / DUNIA INDUSTRI
      </div>
      <div class="form-subtitle">
        PESERTA PRAKTIK KERJA LAPANGAN (PKL)<br />
        SMK MUHAMMADIYAH KANDANGHAUR<br />
        TAHUN AJARAN 2025 / 2026
      </div>

      <table class="form-table">
        <tr>
          <td colspan="2"><strong>A. DATA PERUSAHAAN / INSTANSI</strong></td>
        </tr>
        <tr>
          <td>1. Nama Perusahaan / Instansi</td>
          <td>: ____________________________________________</td>
        </tr>
        <tr>
          <td>2. Nama Pimpinan</td>
          <td>: ____________________________________________</td>
        </tr>
        <tr>
          <td>3. Alamat Perusahaan</td>
          <td>: ____________________________________________</td>
        </tr>
        <tr>
          <td>4. Contact Person / No. HP</td>
          <td>: ____________________________________________</td>
        </tr>

        <tr>
          <td colspan="2">
            <strong><br />B. DATA KEGIATAN PKL</strong>
          </td>
        </tr>
        <tr>
          <td>1. Jumlah Siswa yang diterima</td>
          <td>: ___________ Orang</td>
        </tr>
        <tr>
          <td>2. Tanggal Pelaksanaan PKL</td>
          <td>: <strong>{{ $tanggal_mulai }} s.d {{ $tanggal_selesai }}</strong></td>
        </tr>
      </table>

      <p style="text-align: right">____________,__ {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('F Y') }}</p>
      <p style="text-align: right; padding-right: 50px">Yang Menerima,</p>
      <br /><br /><br />
      <p style="text-align: right">__________________________</p>
    </div>
    <script>
  window.onload = function () {
    window.print();
  };
</script>
  </body>
</html>
