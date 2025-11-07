@extends('layouts.master')
@section('title', 'Pengaturan')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Pengaturan Sekolah</h1>
    </section>

    <section class="content">
        <form action="{{ route('pengaturan.update', $pengaturan->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card">
                <div class="card-body">

                    <div class="form-group">
                        <label>Nama Sekolah</label>
                        <input type="text" class="form-control" name="nama_sekolah" value="{{ old('nama_sekolah', $pengaturan->nama_sekolah) }}">
                    </div>

                    <div class="form-group">
                        <label>Alamat Sekolah</label>
                        <input type="text" class="form-control" name="alamat_sekolah" value="{{ old('alamat_sekolah', $pengaturan->alamat_sekolah) }}">
                    </div>

                    <div class="form-group">
                        <label>Nomor Telepon Sekolah</label>
                        <input type="text" class="form-control" name="no_telp_sekolah" value="{{ old('no_telp_sekolah', $pengaturan->no_telp_sekolah) }}">
                    </div>

                    <div class="form-group">
                        <label>Kepala Sekolah</label>
                        <input type="text" class="form-control" name="kepala_sekolah" value="{{ old('kepala_sekolah', $pengaturan->kepala_sekolah) }}">
                    </div>
                    <div class="form-group">
                        <label>Ketua PKL</label>
                        <input type="text" class="form-control" name="ketua_pkl" value="{{ old('ketua_pkl', $pengaturan->ketua_pkl) }}">
                    </div>

                    <div class="form-group">
                        <label>Sekretaris PKL</label>
                        <input type="text" class="form-control" name="sekretaris_pkl" value="{{ old('sekretaris_pkl', $pengaturan->sekretaris_pkl) }}">
                    </div>

                    <div class="form-group">
                        <label>Tanggal Mulai PKL</label>
                        <input type="date" class="form-control" name="tanggal_mulai_pkl" value="{{ old('tanggal_mulai_pkl', $pengaturan->tanggal_mulai_pkl) }}">
                    </div>

                    <div class="form-group">
                        <label>Tanggal Selesai PKL</label>
                        <input type="date" class="form-control" name="tanggal_selesai_pkl" value="{{ old('tanggal_selesai_pkl', $pengaturan->tanggal_selesai_pkl) }}">
                    </div>

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
                </div>
            </div>
        </form>
    </section>
</div>
@endsection
@section('scripts')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
