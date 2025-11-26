<div class="signature-section">
    <div class="signature">
        Ketua PKL<br />
        <img
            src="{{ asset('assets/dist/img/nanang.jpeg') }}"
            alt="Tanda tangan Ketua"
            height="70"
        /><br />
        <strong>{{ $ketua_pkl }}</strong>
    </div>

@php
    $isSurat = Route::is([
        'surat.permohonan',
        'surat.permohonan.massal',
        'surat.pengantar',
        'surat.pengantar.massal',
    ]);
@endphp

<div class="{{ $isSurat ? 'signature-center' : 'signature-center-penarikan' }}">
        Mengetahui,<br />
        Kepala Sekolah<br />
        <img
            src="{{ asset('assets/dist/img/kepsek.jpeg') }}"
            alt="Tanda tangan Kepsek"
            height="80"
        /><br />
        <strong>{{ $kepala_sekolah }}</strong>
    </div>

    <div class="signature">
        <span class="signature-date">
            Kandanghaur, {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('j F Y') }}
        </span>
        <br> Sekretaris PKL<br />
        <img
            src="{{ asset('assets/dist/img/riski.jpg') }}"
            alt="Tanda tangan Kepsek"
            height="60"
        /><br />
        <strong>{{ $sekretaris_pkl }}</strong>
    </div>
</div>
