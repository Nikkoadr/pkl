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
                <form action="{{ route('sidang_pkl.update', $nilai_sidang_pkl->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="nilai_sidang_pkl">Nilai Sidang</label>
                        <input type="number" name="nilai_sidang_pkl" id="nilai_sidang"
                            class="form-control @error('nilai_sidang_pkl') is-invalid @enderror"
                            value="{{ old('nilai_sidang_pkl', $nilai_sidang_pkl->nilai_sidang_pkl) }}" min="0" max="100"
                            placeholder="Masukkan nilai sidang...">
                        @error('nilai_sidang_pkl')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <a href="{{ route('sidang_pkl.index') }}" class="btn btn-secondary">Kembali</a>
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
