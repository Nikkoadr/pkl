<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <title>Surat Permohonan PKL</title>
    {{-- <link rel="stylesheet" href="{{ asset('assets/dist/css/styles_docx.css') }}" /> --}}
    <style>
      body {
  font-family: "Times New Roman", serif;
  margin: 0;
  padding: 0;
  background: #fff;
  color: #000;
}

.page {
  width: 210mm;
  min-height: 297mm;
  margin: auto;
  background: white;
  box-sizing: border-box;
  page-break-after: always;
}
.page:last-child {
  page-break-after: auto;
}
.kop table {
  width: 100%;
  border-collapse: collapse;
}

.kop td {
  padding: 2px;
}

.kop img {
  height: 85px;
}

.line {
  border-top: 2.5px solid black;
  margin: 8px 0 20px;
}

.meta {
  margin-bottom: 20px;
  font-size: 16px;
}

.meta table td {
  vertical-align: top;
  padding: 2px 5px;
}

.indent {
  text-indent: 50px;
  line-height: 1.7;
  margin-bottom: 15px;
  text-align: justify;
}

.signature-section {
  margin-top: 40px;
  display: flex;
  justify-content: space-between;
  text-align: center;
}

.signature {
  width: 30%;
}

.signature.center {
  width: 35%;
  margin-top: 80px;
}

.form-title {
  text-align: center;
  text-transform: uppercase;
  font-weight: bold;
  margin-top: 20px;
  margin-bottom: 10px;
  font-size: 16px;
}

.form-subtitle {
  text-align: center;
  margin-bottom: 20px;
  font-size: 15px;
}

.form-table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 20px;
  font-size: 16px;
}

.form-table td {
  padding: 6px;
  vertical-align: top;
}
a {
  color: black;
  text-decoration: none;
}

@media print {
  .page {
    margin: 0;
    box-shadow: none;
  }
}

    </style>
  </head>
  <body>
    <!-- Halaman 1 -->
    <div class="page">
      <div style="text-align: center">
        <table style="width: 100%; border-collapse: collapse">
          <tr>
            <td style="width: 100px" align="center">
              <img src="{{ asset('assets/dist/img/dikdasmenmuh.png') }}" width="100" />
            </td>
            <td align="center">
              <div style="font-size: 10pt; font-weight: bold; color: #007bff">
                MAJELIS PENDIDIKAN DASAR DAN MENENGAH PENDIDIKAN NONFORMAL
              </div>
              <div style="font-size: 10pt; font-weight: bold; color: #007bff">
                PIMPINAN WILAYAH MUHAMMADIYAH JAWA BARAT
              </div>
              <div style="font-size: 18pt; font-weight: bold; color: #007bff">
                SMK MUHAMMADIYAH KANDANGHAUR
              </div>
              <div style="font-size: 12pt; font-weight: bold">
                Terakreditasi “A” (Unggul)
              </div>
              <div style="font-size: 12pt; font-weight: bold">
                Nomor : 18572022/BAN-SM/SK/2022
              </div>
              <div style="font-size: 9pt; margin-top: 5px">
                Konsentrasi Keahlian : Teknik Elektronika Industri, Teknik
                Pengelasan, Teknik Kendaraan Ringan, <br />
                Teknik Komputer dan Jaringan, Teknik Sepeda Motor, Layanan
                Penunjang Kefarmasian Klinis dan Komunitas
              </div>
              <div style="font-size: 6pt">
                Jl. Raya Karanganyar No. 28/A Kec. Kandanghaur Kab. Indramayu
                45254 Telp. (0234) 507239
                email : smkmuhkdh@gmail.com website :
                https://www.smkmuhkandanghaur.sch.id
              </div>
            </td>
            <td style="width: 100px" align="center">
              <img src="{{ asset('assets/dist/img/logo.png') }}" width="80" />
            </td>
          </tr>
        </table>

        <!-- Dua garis horizontal khas -->
        <hr
          style="border: 2px solid black; margin-top: 4px; margin-bottom: 1px"
        />
        <hr style="border: 1px solid black; margin-top: 0" />
      </div>

      <div class="meta">
        <table>
          <tr>
            <td>Nomor</td>
            <td>: 631.001/III.4.AU/J/2025</td>
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
          <td><strong>{{ $tanggal_mulai }} s.d {{ $tanggal_selesai }}</strong></td>
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

      <div class="signature-section">
        <div class="signature">
          Ketua PKL<br />
          <img
            src="{{ asset('assets/dist/img/nanang.jpeg') }}"
            alt="Tanda tangan Ketua"
            height="70"
          /><br />
          <strong>H. NANANG HADI M, S.T.</strong>
        </div>
        <div class="signature center">
          Mengetahui,<br />
          Kepala Sekolah<br />
          <img
            src="{{ asset('assets/dist/img/kepsek.jpeg') }}"
            alt="Tanda tangan Kepsek"
            height="80"
          /><br />
          <strong>H. AFANDI, S.Pd.</strong>
        </div>
        <div class="signature">
          Kandanghaur, {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('j F Y') }} <br> Sekretaris PKL<br />
          <img
            src="{{ asset('assets/dist/img/riski.jpg') }}"
            alt="Tanda tangan Kepsek"
            height="60"
          /><br />
          <strong>RIZKY RAMADONA, S.T.</strong>
        </div>
      </div>
    </div>

    <!-- Halaman 2 -->
    <div class="page">
      <div style="text-align: center">
        <table style="width: 100%; border-collapse: collapse">
          <tr>
            <td style="width: 100px" align="center">
              <img src="{{ asset('assets/dist/img/dikdasmenmuh.png') }}" width="100" />
            </td>
            <td align="center">
              <div style="font-size: 10pt; font-weight: bold; color: #007bff">
                MAJELIS PENDIDIKAN DASAR DAN MENENGAH PENDIDIKAN NONFORMAL
              </div>
              <div style="font-size: 10pt; font-weight: bold; color: #007bff">
                PIMPINAN WILAYAH MUHAMMADIYAH JAWA BARAT
              </div>
              <div style="font-size: 18pt; font-weight: bold; color: #007bff">
                SMK MUHAMMADIYAH KANDANGHAUR
              </div>
              <div style="font-size: 12pt; font-weight: bold">
                Terakreditasi “A” (Unggul)
              </div>
              <div style="font-size: 12pt; font-weight: bold">
                Nomor : 18572022/BAN-SM/SK/2022
              </div>
              <div style="font-size: 9pt; margin-top: 5px">
                Konsentrasi Keahlian : Teknik Elektronika Industri, Teknik
                Pengelasan, Teknik Kendaraan Ringan, <br />
                Teknik Komputer dan Jaringan, Teknik Sepeda Motor, Layanan
                Penunjang Kefarmasian Klinis dan Komunitas
              </div>
              <div style="font-size: 6pt">
                Jl. Raya Karanganyar No. 28/A Kec. Kandanghaur Kab. Indramayu
                45254 Telp. (0234) 507239
                email : smkmuhkdh@gmail.com website :
                https://www.smkmuhkandanghaur.sch.id
              </div>
            </td>
            <td style="width: 100px" align="center">
              <img src="{{ asset('assets/dist/img/logo.png') }}" width="80" />
            </td>
          </tr>
        </table>

        <!-- Dua garis horizontal khas -->
        <hr
          style="border: 2px solid black; margin-top: 4px; margin-bottom: 1px"
        />
        <hr style="border: 1px solid black; margin-top: 0" />
      </div>

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
          <td>: <strong>1 September s.d 30 November 2025</strong></td>
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
