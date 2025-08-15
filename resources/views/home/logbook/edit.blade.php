@extends('layouts.master')
@section('title', 'Edit Logbook')

@section('content')
<div class="content-wrapper">
    <!-- Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Edit Logbook</h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Form -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <form action="{{ route('logbook.update', $logbook->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="peserta">Peserta</label>
                            <input type="text" class="form-control" value="{{ $logbook->peserta_pkl->peserta->user->nama }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="dudi">DUDI</label>
                            <input type="text" class="form-control" value="{{ $logbook->peserta_pkl->dudi->nama_dudi }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', $logbook->tanggal) }}">
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="jam">Jam</label>
                            <input type="time" name="jam" id="jam" class="form-control @error('jam') is-invalid @enderror" value="{{ old('jam', $logbook->jam) }}">
                            @error('jam')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan', $logbook->keterangan) }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="foto_bukti">Foto Bukti (jika ingin diganti)</label><br>
                            @if ($logbook->foto_bukti)
                                <img src="{{ asset('storage/bukti_logbook/' . $logbook->foto_bukti) }}" alt="Foto Bukti" width="150" class="mb-2">
                            @endif
                            <input type="file" name="foto_bukti" id="foto_bukti" class="form-control-file @error('foto_bukti') is-invalid @enderror">
                            @error('foto_bukti')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('logbook.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-success float-right">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
