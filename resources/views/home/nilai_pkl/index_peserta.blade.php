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

                @php
                    $readonly = $esertifikat->nomor_sertifikat ?? null;
                @endphp

                @if($nilai_pkl->exists)
                    <form action="{{ route('nilai_pkl.update_siswa', $nilai_pkl->id) }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                @else
                    <form action="{{ route('nilai_pkl.store_peserta') }}" method="POST" enctype="multipart/form-data">
                @endif
                    @csrf

                    <div class="form-group">
                        <label>Nilai Disiplin Kerja</label>
                        <input type="number" name="nilai_disiplin_kerja"
                               value="{{ old('nilai_disiplin_kerja', $nilai_pkl->nilai_disiplin_kerja) }}"
                               class="form-control @error('nilai_disiplin_kerja') is-invalid @enderror"
                               {{ $readonly ? 'readonly' : '' }}>
                        @error('nilai_disiplin_kerja')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Nilai Kemajuan Kerja</label>
                        <input type="number" name="nilai_kemajuan_kerja"
                               value="{{ old('nilai_kemajuan_kerja', $nilai_pkl->nilai_kemajuan_kerja) }}"
                               class="form-control @error('nilai_kemajuan_kerja') is-invalid @enderror"
                               {{ $readonly ? 'readonly' : '' }}>
                        @error('nilai_kemajuan_kerja')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label>Nilai Kualitas Kerja</label>
                        <input type="number" name="nilai_kualitas_kerja"
                               value="{{ old('nilai_kualitas_kerja', $nilai_pkl->nilai_kualitas_kerja) }}"
                               class="form-control @error('nilai_kualitas_kerja') is-invalid @enderror"
                               {{ $readonly ? 'readonly' : '' }}>
                        @error('nilai_kualitas_kerja')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Nilai Inisiatif & Kreatifitas</label>
                        <input type="number" name="nilai_inisiatif_kreatifitas"
                               value="{{ old('nilai_inisiatif_kreatifitas', $nilai_pkl->nilai_inisiatif_kreatifitas) }}"
                               class="form-control @error('nilai_inisiatif_kreatifitas') is-invalid @enderror"
                               {{ $readonly ? 'readonly' : '' }}>
                        @error('nilai_inisiatif_kreatifitas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Nilai Perilaku</label>
                        <input type="number" name="nilai_perilaku"
                            value="{{ old('nilai_perilaku', $nilai_pkl->nilai_perilaku) }}"
                            class="form-control @error('nilai_perilaku') is-invalid @enderror"
                            {{ $readonly ? 'readonly' : '' }}>
                        @error('nilai_perilaku')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="foto_bukti_nilai_pkl">Foto Bukti Nilai PKL</label>
                        <div class="custom-file">
                            <input type="file" name="foto_bukti_nilai_pkl" id="foto_bukti_nilai_pkl"
                                class="custom-file-input @error('foto_bukti_nilai_pkl') is-invalid @enderror"
                                {{ $readonly ? 'disabled' : '' }}>
                            <label class="custom-file-label" for="foto_bukti_nilai_pkl">Pilih file</label>
                            @error('foto_bukti_nilai_pkl')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if ($nilai_pkl->foto_bukti_nilai_pkl)
                            <div class="mt-2">
                                <a href="{{ asset('storage/bukti_nilai_pkl/' . $nilai_pkl->foto_bukti_nilai_pkl) }}" target="_blank">
                                    <img src="{{ asset('storage/bukti_nilai_pkl/' . $nilai_pkl->foto_bukti_nilai_pkl) }}" 
                                        alt="Bukti Nilai PKL" 
                                        style="max-width: 150px; border: 1px solid #ccc; border-radius: 4px;">
                                </a>
                            </div>
                        @endif
                    </div>

                    @unless($readonly)
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    @endunless
                </form>
            </div>
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script>
$(function () {
    bsCustomFileInput.init();

    @unless($readonly)
    $('form').on('submit', function(event) {
        event.preventDefault();

        Swal.fire({
            icon: 'info',
            title: 'Perhatian!',
            text: 'Setelah sertifikat PKL diterbitkan, nilai tidak dapat diubah lagi.',
            confirmButtonText: 'Simpan Nilai',
            showCancelButton: true,
            cancelButtonText: 'Batal',
            confirmButtonColor: '#3085d6'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
    @endunless
});
</script>

@if (session('success'))
<script>
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: @json(session('success')),
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
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
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });
</script>
@endif
@endsection
