<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Kop Surat PKL</title>
  <style>
    body {
      font-family: "Times New Roman", serif;
      margin: 0;
      padding: 0;
      background: #ddd;
    }

    .page {
      width: 24.13cm;
      height: 10.48cm;
      background: white;
      margin: 20px auto;
      padding: 10px;
      box-sizing: border-box;
      box-shadow: 0 0 0.3cm rgba(0, 0, 0, 0.2);
      position: relative;
    }

    @page {
      size: 24.13cm 10.48cm;
      margin-top: 0.3cm;
      margin-bottom: 0.3cm;
      margin-left: 2cm;
      margin-right: 1.27cm;
    }

    @media print {
      body {
        background: white;
      }
      .page {
        margin: 0;
        box-shadow: none;
      }
    }

    /* Kop surat */
    .kop table {
      width: 100%;
      border-collapse: collapse;
    }
    .kop td {
      padding: 0;
    }
    .kop img {
      height: 60px;
    }
    .line {
      border-top: 2px solid black;
      margin: 5px 0 10px;
    }

    .tujuan {
      position: absolute;
      top: 55%;
      right: 15%;
      font-size: 11pt;
      line-height: 1.5;
    }
    .tujuan p {
      margin: 2px 0;
    }
  </style>
</head>
<body>
  <div class="page">
<div class="kop">
  <table width="100%">
    <tr>
      <td style="width: 100px;" align="center">
        <img src="{{ asset('assets/dist/img/dikdasmenmuh2.png') }}" style="width:120px; height:auto;" />
      </td>

      <td align="center" style="line-height: 1.3;">
        <div style="font-size: 12pt; font-weight: bold; color: #007bff;">
          MAJELIS PENDIDIKAN DASAR DAN MENENGAH PENDIDIKAN NONFORMAL
        </div>
        <div style="font-size: 12pt; font-weight: bold; color: #007bff;">
          PIMPINAN WILAYAH MUHAMMADIYAH JAWA BARAT
        </div>
        <div style="font-size: 18pt; font-weight: bold; color: #007bff; margin-top: 2px;">
          SMK MUHAMMADIYAH KANDANGHAUR
        </div>
        <div style="font-size: 10pt; font-weight: bold; margin-top: 2px;">
          Terakreditasi “A” (Unggul)
        </div>
        <div style="font-size: 8pt; margin-top: 3px;">
            Konsentrasi Keahlian : Teknik Elektronika Industri, Teknik
            Pengelasan, Teknik Kendaraan Ringan, <br />
            Teknik Komputer dan Jaringan, Teknik Sepeda Motor, Layanan
            Penunjang Kefarmasian Klinis dan Komunitas
        </div>
        <div style="font-size: 7pt; margin-top: 3px;">
          Jl. Raya Karanganyar No. 28/A Kec. Kandanghaur Kab. Indramayu 45254
          Telp. (0234) 507239 – email: smkmuhkdh@gmail.com – website: www.smkmuhkandanghaur.sch.id
        </div>
      </td>

      <td style="width: 100px;" align="center">
        <img src="{{ asset('assets/dist/img/logo.png') }}" style="width:85px; height:auto;" />
      </td>
    </tr>
  </table>
  <div class="line" style="border-bottom:2px solid #000; margin-top:5px;"></div>
</div>


    <div class="tujuan">
      <p>Kepada Yth:</p>
      <p>{{ $dudi->jabatan_pimpinan ?? 'Bapak/Ibu Pimpinan/Direktur' }}</p>
      <p><strong>{{ $dudi->nama_dudi }}</strong></p>
      <p>Di {{ $dudi->alamat_dudi ?? 'Tempat' }}</p>
    </div>
  </div>

  <script>
    window.onload = function () {
      window.print();
    };
  </script>
</body>
</html>
