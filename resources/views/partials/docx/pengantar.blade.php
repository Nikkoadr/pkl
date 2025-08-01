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
    <td><strong>{{ \Carbon\Carbon::parse($tanggal_mulai)->locale('id')->translatedFormat('j F Y') }} s.d {{ \Carbon\Carbon::parse($tanggal_selesai)->locale('id')->translatedFormat('j F Y') }}</strong></td>
  </tr>
</table>

<p class="indent">
  Demikian surat pengantar PKL kami sampaikan. Atas kerjasamanya, kami ucapkan terima kasih.
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

  <div class="meta">
    <table>
      <tr>
        <td>Nomor</td>
        <td>: 631.001/III.4.AU/J/2025</td>
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

<table style="width: 100%; border-collapse: collapse; font-size: 14px; text-transform: uppercase;" border="1">
  <thead>
    <tr style="background-color: #8b8263; color: white;">
      <th style="padding: 6px;">NO</th>
      <th style="padding: 6px;">NAMA SISWA</th>
      <th style="padding: 6px;">TINGKAT</th>
      <th style="padding: 6px;">KOMPETENSI KEAHLIAN</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($peserta as $index => $s)
      <tr>
        <td style="text-align: center; padding: 6px;">{{ $index + 1 }}</td>
        <td style="text-align: center; padding: 6px;">{{ strtoupper($s->user->nama ?? '-') }}</td>
        <td style="text-align: center; padding: 6px;">{{ strtoupper($s->kelas->nama_kelas ?? '-') }}</td>
        <td style="text-align: center; padding: 6px;">{{ strtoupper($s->kelas->kompetensi->nama_kompetensi ?? '-') }}</td>
      </tr>
    @endforeach
  </tbody>
</table>



    <script>
  window.onload = function () {
    window.print();
  };
</script>
  </body>
</html>
