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
                <form action="{{ route('nilai_pkl.update', $nilai_pkl->id) }}"
                    method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- IDENTITAS PESERTA --}}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Nama Peserta</label>
                                <input type="text"
                                    class="form-control"
                                    value="{{ $nilai_pkl->peserta_pkl->peserta->user->nama ?? '-' }}"
                                    readonly>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Kelas</label>
                                <input type="text"
                                    class="form-control"
                                    value="{{ $nilai_pkl->peserta_pkl->peserta->kelas->nama_kelas ?? '-' }}"
                                    readonly>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>DUDI</label>
                                <input type="text"
                                    class="form-control"
                                    value="{{ $nilai_pkl->peserta_pkl->dudi->nama_dudi ?? '-' }}"
                                    readonly>
                            </div>
                        </div>
                    </div>

                    <hr>

                    {{-- NILAI PKL --}}
                    <div class="form-group">
                        <label>Nilai Disiplin Kerja</label>
                        <input type="number"
                            name="nilai_disiplin_kerja"
                            class="form-control @error('nilai_disiplin_kerja') is-invalid @enderror"
                            value="{{ old('nilai_disiplin_kerja', $nilai_pkl->nilai_disiplin_kerja) }}"
                            min="0" max="100">
                        @error('nilai_disiplin_kerja')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Nilai Kemajuan Kerja</label>
                        <input type="number"
                            name="nilai_kemajuan_kerja"
                            class="form-control @error('nilai_kemajuan_kerja') is-invalid @enderror"
                            value="{{ old('nilai_kemajuan_kerja', $nilai_pkl->nilai_kemajuan_kerja) }}"
                            min="0" max="100">
                        @error('nilai_kemajuan_kerja')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Nilai Kualitas Kerja</label>
                        <input type="number"
                            name="nilai_kualitas_kerja"
                            class="form-control @error('nilai_kualitas_kerja') is-invalid @enderror"
                            value="{{ old('nilai_kualitas_kerja', $nilai_pkl->nilai_kualitas_kerja) }}"
                            min="0" max="100">
                        @error('nilai_kualitas_kerja')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Nilai Inisiatif & Kreatifitas</label>
                        <input type="number"
                            name="nilai_inisiatif_kreatifitas"
                            class="form-control @error('nilai_inisiatif_kreatifitas') is-invalid @enderror"
                            value="{{ old('nilai_inisiatif_kreatifitas', $nilai_pkl->nilai_inisiatif_kreatifitas) }}"
                            min="0" max="100">
                        @error('nilai_inisiatif_kreatifitas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Nilai Perilaku</label>
                        <input type="number"
                            name="nilai_perilaku"
                            class="form-control @error('nilai_perilaku') is-invalid @enderror"
                            value="{{ old('nilai_perilaku', $nilai_pkl->nilai_perilaku) }}"
                            min="0" max="100">
                        @error('nilai_perilaku')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- BUKTI --}}
                    <div class="form-group">
                        <label>Foto Bukti Nilai PKL</label>
                        <div class="custom-file">
                            <input type="file"
                                name="foto_bukti_nilai_pkl"
                                class="custom-file-input @error('foto_bukti_nilai_pkl') is-invalid @enderror">
                            <label class="custom-file-label">Pilih file...</label>
                        </div>

                        @if ($nilai_pkl->foto_bukti_nilai_pkl)
                            <div class="mt-2">
                                <a href="{{ asset('storage/bukti_nilai_pkl/'.$nilai_pkl->foto_bukti_nilai_pkl) }}"
                                target="_blank">
                                    Lihat Bukti
                                </a>
                            </div>
                        @endif
                    </div>

                    <a href="{{ route('nilai_pkl.index') }}" class="btn btn-secondary">
                        Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
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
