@extends('layouts.master')
@section('title', 'Edit Peserta')

@section('link')
<!-- jQuery UI for Autocomplete -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Edit Data Peserta</h1>
    </section>

    <section class="content">
        <form action="{{ route('peserta.update', $peserta->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card card-primary">
                <div class="card-body row">
                    <!-- Tahun Ajaran -->
                    <div class="form-group col-md-6">
                        <label>Tahun Ajaran</label>
                        <select name="tahun_ajaran_id" class="form-control @error('tahun_ajaran_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Tahun Ajaran --</option>
                            @foreach ($tahun_ajaran as $ta)
                                <option value="{{ $ta->id }}" {{ old('tahun_ajaran_id', $peserta->tahun_ajaran_id ?? '') == $ta->id ? 'selected' : '' }}>
                                    {{ $ta->nama_tahun_ajaran }}
                                </option>
                            @endforeach
                        </select>
                        @error('tahun_ajaran_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- NIS -->
                    <div class="form-group col-md-3">
                        <label>NIS</label>
                        <input type="text" name="nis" class="form-control @error('nis') is-invalid @enderror" value="{{ old('nis', $peserta->nis) }}">
                        @error('nis') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- NISN -->
                    <div class="form-group col-md-3">
                        <label>NISN</label>
                        <input type="text" name="nisn" class="form-control @error('nisn') is-invalid @enderror" value="{{ old('nisn', $peserta->nisn) }}">
                        @error('nisn') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Nama -->
                    <div class="form-group col-md-6">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $peserta->user->nama) }}" required>
                        @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Tempat Lahir -->
                    <div class="form-group col-md-6">
                        <label>Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror"
                            value="{{ old('tempat_lahir', $peserta->user->tempat_lahir) }}">
                        @error('tempat_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Tanggal Lahir -->
                    <div class="form-group col-md-3">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                            value="{{ old('tanggal_lahir', $peserta->user->tanggal_lahir) }}">
                        @error('tanggal_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Jenis Kelamin -->
                    <div class="form-group col-md-3">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control @error('jenis_kelamin') is-invalid @enderror">
                            <option value="1" {{ old('jenis_kelamin', $peserta->user->jenis_kelamin) == 1 ? 'selected' : '' }}>Laki-laki</option>
                            <option value="2" {{ old('jenis_kelamin', $peserta->user->jenis_kelamin) == 2 ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Kelas -->
                    <div class="form-group col-md-6">
                        <label>Kelas</label>
                        <select name="kelas_id" class="form-control @error('kelas_id') is-invalid @enderror">
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}" {{ old('kelas_id', $peserta->kelas_id) == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                        @error('kelas_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="card-footer">
                    <a href="{{ route('peserta.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary float-right">Simpan</button>
                </div>
            </div>
        </form>
    </section>
</div>
@endsection
