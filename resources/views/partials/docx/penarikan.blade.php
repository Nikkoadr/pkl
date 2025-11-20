<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <title>Surat Penarikan Peserta PKL</title>
    <link rel="stylesheet" href="{{ asset('assets/dist/css/styles_docx.css') }}?v={{ filemtime(public_path('assets/dist/css/styles_docx.css')) }}" />
  </head>
  <body>
    <div class="page">
      @include('partials.docx.head')

      <div class="meta">
        <table>
          <tr>
            <td>Nomor</td>
            <td>: 631.{{ str_pad($dudi->id, 3, '0', STR_PAD_LEFT) }}/III.4.AU/J/{{ date('Y') }}</td>
          </tr>
          <tr>
            <td>Lampiran</td>
            <td>: -</td>
          </tr>
          <tr>
            <td>Perihal</td>
            <td><strong>: Penarikan Peserta Praktik Kerja Lapangan (PKL)</strong></td>
          </tr>
        </table>
      </div>

      <p>
        Yth. Bapak/Ibu Pimpinan/Direktur<br />
        <strong>{{ $dudi->nama_dudi }}</strong><br />
        di Tempat
      </p>

      <p>Dengan hormat,</p>

      <p class="indent">
        Sehubungan telah berakhirnya masa Praktik Kerja Lapangan (PKL) Peserta Didik kami yang telah dimulai sejak tanggal 
        <strong>{{ $tanggal_mulai }}</strong> s.d 
        <strong>{{ $tanggal_selesai }}</strong>. 
        Kami segenap pihak <strong>SMK Muhammadiyah Kandanghaur</strong> dengan penuh kebesaran hati menyampaikan rasa terima kasih atas kerjasamanya.
      </p>

      <p class="indent">
        Selanjutnya tidak lupa kami meminta maaf kepada pihak <strong>{{ $dudi->nama_dudi }}</strong> apabila dari Peserta Didik kami telah melakukan perbuatan yang tidak semestinya serta masih terbatasnya kemampuan/skill dari anak didik kami. Namun, kami berharap silaturahmi yang baik tetap terjaga dan terpelihara di antara semua pihak demi keberlangsungan proses pendidikan yang senantiasa meningkat seiring bertambahnya waktu serta kerjasama di masa-masa yang akan datang.
      </p>

      <p class="indent">
        Oleh karena itu, kritik dan saran yang membangun akan senantiasa kami terima demi proses pendidikan yang lebih baik. Atas perhatiannya kami sampaikan terima kasih.
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
