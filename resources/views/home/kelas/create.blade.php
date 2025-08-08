@extends('layouts.master')
@section('title', 'Tambah Kelas')

@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1>Tambah Kelas</h1>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Form Tambah Kelas</h3>
        </div>

        <form action="{{ route('kelas.store') }}" method="POST">
          @csrf
          <div class="card-body">
            <div class="form-group">
              <label for="nama_kelas">Nama Kelas</label>
              <input type="text" class="form-control @error('nama_kelas') is-invalid @enderror" id="nama_kelas" name="nama_kelas" value="{{ old('nama_kelas') }}" placeholder="Contoh: XI RPL 1">
              @error('nama_kelas')
              <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            <div class="form-group">
              <label for="kompetensi_keahlian_id">Kompetensi Keahlian</label>
              <select class="form-control @error('kompetensi_keahlian_id') is-invalid @enderror" id="kompetensi_keahlian_id" name="kompetensi_keahlian_id">
                <option value="">-- Pilih Kompetensi --</option>
                @foreach($kompetensi as $item)
                  <option value="{{ $item->id }}" {{ old('kompetensi_keahlian_id') == $item->id ? 'selected' : '' }}>
                    {{ $item->nama_kompetensi }}
                  </option>
                @endforeach
              </select>
              @error('kompetensi_keahlian_id')
              <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>
          </div>

          <div class="card-footer">
            <a href="{{ route('kelas.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </section>
</div>
@endsection
