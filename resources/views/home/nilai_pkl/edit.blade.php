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
                        @method('PUT')
                        @csrf
                    <div class="form-group">
                        <label>Nilai Disiplin Kerja</label>
                        <input type="number" name="nilai_disiplin_kerja" value="{{ old('nilai_disiplin_kerja', $nilai_pkl->nilai_disiplin_kerja) }}" class="form-control @error('nilai_disiplin_kerja') is-invalid @enderror">
                        @error('nilai_disiplin_kerja')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Nilai Kemajuan Kerja</label>
                        <input type="number" name="nilai_kemajuan_kerja" value="{{ old('nilai_kemajuan_kerja', $nilai_pkl->nilai_kemajuan_kerja) }}" class="form-control @error('nilai_kemajuan_kerja') is-invalid @enderror">
                        @error('nilai_kemajuan_kerja')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Nilai Kualitas Kerja</label>
                        <input type="number" name="nilai_kualitas_kerja" value="{{ old('nilai_kualitas_kerja', $nilai_pkl->nilai_kualitas_kerja) }}" class="form-control @error('nilai_kualitas_kerja') is-invalid @enderror">
                        @error('nilai_kualitas_kerja')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Nilai Inisiatif & Kreatifitas</label>
                        <input type="number" name="nilai_inisiatif_kreatifitas" value="{{ old('nilai_inisiatif_kreatifitas', $nilai_pkl->nilai_inisiatif_kreatifitas) }}" class="form-control @error('nilai_inisiatif_kreatifitas') is-invalid @enderror">
                        @error('nilai_inisiatif_kreatifitas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Nilai Perilaku</label>
                        <input type="number" name="nilai_prilaku" value="{{ old('nilai_prilaku', $nilai_pkl->nilai_prilaku) }}" class="form-control @error('nilai_prilaku') is-invalid @enderror">
                        @error('nilai_prilaku')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="foto_bukti_nilai_pkl">Foto Bukti Nilai PKL</label>
                        <div class="custom-file">
                            <input type="file" name="foto_bukti_nilai_pkl" id="foto_bukti_nilai_pkl" 
                                class="custom-file-input @error('foto_bukti_nilai_pkl') is-invalid @enderror">
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

                    <div class="form-group">
                        <label>Nilai Sidang PKL</label>
                        <input type="number" name="nilai_sidang_pkl" value="{{ old('nilai_sidang_pkl', $nilai_pkl->nilai_sidang_pkl) }}" class="form-control @error('nilai_sidang_pkl') is-invalid @enderror">
                        @error('nilai_sidang_pkl')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Komentar</label>
                        <input type="number" name="komentar" value="{{ old('komentar', $nilai_pkl->komentar) }}" class="form-control @error('komentar') is-invalid @enderror">
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
<script src="{{ asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script>
$(function () {
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
