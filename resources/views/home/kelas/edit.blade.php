@extends('layouts.master')
@section('title', 'Edit Kelas')

@section('content')
<div class="content-wrapper">
    <!-- Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Kelas</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('kelas.index') }}">Kelas</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <form action="{{ route('kelas.update', $kelas->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <!-- Kompetensi Keahlian -->
                        <div class="form-group">
                            <label for="kompetensi_keahlian_id">Kompetensi Keahlian</label>
                            <select name="kompetensi_keahlian_id" id="kompetensi_keahlian_id" class="form-control @error('kompetensi_keahlian_id') is-invalid @enderror">
                                <option value="">-- Pilih Kompetensi --</option>
                                @foreach ($kompetensi as $kk)
                                    <option value="{{ $kk->id }}" {{ $kelas->kompetensi_keahlian_id == $kk->id ? 'selected' : '' }}>
                                        {{ $kk->nama_kompetensi }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kompetensi_keahlian_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nama Kelas -->
                        <div class="form-group">
                            <label for="nama_kelas">Nama Kelas</label>
                            <input type="text" name="nama_kelas" id="nama_kelas" class="form-control @error('nama_kelas') is-invalid @enderror" value="{{ old('nama_kelas', $kelas->nama_kelas) }}">
                            @error('nama_kelas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="card-footer">
                        <a href="{{ route('kelas.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
