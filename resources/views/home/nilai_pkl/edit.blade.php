@extends('layouts.master')
@section('title', 'Nilai PKL Saya')

@section('link')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endsection

@section('content')
<div class="content-wrapper">

    <section class="content-header">
        <h1>Nilai PKL Saya</h1>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-body">

                <form action="{{ route('nilai_pkl.update', $nilai_pkl->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @php
                        $fields = [
                            'nilai_disiplin_kerja' => 'Nilai Disiplin Kerja',
                            'nilai_kemajuan_kerja' => 'Nilai Kemajuan Kerja',
                            'nilai_kualitas_kerja' => 'Nilai Kualitas Kerja',
                            'nilai_inisiatif_kreatifitas' => 'Nilai Inisiatif & Kreatifitas',
                            'nilai_perilaku' => 'Nilai Perilaku',
                            'nilai_sidang_pkl' => 'Nilai Sidang PKL'
                        ];
                    @endphp

                    @foreach($fields as $name => $label)
                        <div class="form-group">
                            <label>{{ $label }}</label>
                            <input type="number" min="0" max="100" name="{{ $name }}" value="{{ old($name, $nilai_pkl->$name) }}"
                                class="form-control @error($name) is-invalid @enderror">
                            @error($name)
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    @endforeach

                    <div class="form-group">
                        <label for="foto_bukti_nilai_pkl">Foto Bukti Nilai PKL</label>
                        <div class="custom-file">
                            <input type="file" name="foto_bukti_nilai_pkl" id="foto_bukti_nilai_pkl"
                                class="custom-file-input @error('foto_bukti_nilai_pkl') is-invalid @enderror">
                            <label class="custom-file-label" for="foto_bukti_nilai_pkl">Pilih file...</label>

                            @error('foto_bukti_nilai_pkl')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if ($nilai_pkl->foto_bukti_nilai_pkl)
                            <div class="mt-2">
                                <a href="{{ asset('storage/bukti_nilai_pkl/'.$nilai_pkl->foto_bukti_nilai_pkl) }}" target="_blank">
                                    <img src="{{ asset('storage/bukti_nilai_pkl/'.$nilai_pkl->foto_bukti_nilai_pkl) }}"
                                        alt="Bukti Nilai PKL"
                                        class="img-thumbnail" style="max-width:150px;">
                                </a>
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Komentar</label>
                        <textarea name="komentar" rows="3" class="form-control @error('komentar') is-invalid @enderror">{{ old('komentar', $nilai_pkl->komentar) }}</textarea>
                        @error('komentar')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <a href="{{ route('nilai_pkl.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>

                </form>

            </div>
        </div>
    </section>

</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script>
    $(document).ready(function () {
        bsCustomFileInput.init();
    });
</script>

@if (session('success'))
<script>
Swal.fire({
    toast: true,
    position: 'top-end',
    icon: 'success',
    title: @json(session('success')),
    timer: 3000,
    showConfirmButton:false
});
</script>
@endif

@if (session('error'))
<script>
Swal.fire({
    toast: true,
    position: 'top-end',
    icon: 'error',
    title: @json(session('error')),
    timer: 3000,
    showConfirmButton:false
});
</script>
@endif
@endsection
