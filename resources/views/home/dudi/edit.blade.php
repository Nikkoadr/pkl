@extends('layouts.master')
@section('title', 'Edit DUDI')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Edit Data DUDI</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Form Edit</h3>
                </div>
                <form action="{{ route('dudi.update', $data->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body row">
                        <div class="form-group col-md-6">
                            <label>Nama DUDI <span class="text-danger">*</span></label>
                            <input type="text" name="nama_dudi" value="{{ old('nama_dudi', $data->nama_dudi) }}" class="form-control @error('nama_dudi') is-invalid @enderror" required>
                            @error('nama_dudi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>Alamat</label>
                            <input type="text" name="alamat_dudi" value="{{ old('alamat_dudi', $data->alamat_dudi) }}" class="form-control @error('alamat_dudi') is-invalid @enderror">
                            @error('alamat_dudi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>No. Telp</label>
                            <input type="text" name="no_telp_dudi" value="{{ old('no_telp_dudi', $data->no_telp_dudi) }}" class="form-control @error('no_telp_dudi') is-invalid @enderror">
                            @error('no_telp_dudi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>Jabatan Pimpinan</label>
                            <input type="text" name="jabatan_pimpinan" value="{{ old('jabatan_pimpinan', $data->jabatan_pimpinan) }}" class="form-control @error('jabatan_pimpinan') is-invalid @enderror">
                            @error('jabatan_pimpinan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>Nomor Kepegawaian</label>
                            <input type="text" name="nomor_kepegawaian" value="{{ old('nomor_kepegawaian', $data->nomor_kepegawaian) }}" class="form-control @error('nomor_kepegawaian') is-invalid @enderror">
                            @error('nomor_kepegawaian')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>Nama Pimpinan</label>
                            <input type="text" name="nama_pimpinan_dudi" value="{{ old('nama_pimpinan_dudi', $data->nama_pimpinan_dudi) }}" class="form-control @error('nama_pimpinan_dudi') is-invalid @enderror">
                            @error('nama_pimpinan_dudi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>Kuota <span class="text-danger">*</span></label>
                            <input type="number" name="kuota" value="{{ old('kuota', $data->kuota) }}" class="form-control @error('kuota') is-invalid @enderror" required>
                            @error('kuota')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label>Kompetensi Keahlian <span class="text-danger">*</span></label>
                            <select name="kompetensi_keahlian_id" class="form-control @error('kompetensi_keahlian_id') is-invalid @enderror" required>
                                <option value="" disabled>-- Pilih Kompetensi Keahlian --</option>
                                @foreach($kompetensi_keahlian as $item)
                                    <option value="{{ $item->id }}" {{ old('kompetensi_keahlian_id', $data->kompetensi_keahlian_id) == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama_kompetensi }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kompetensi_keahlian_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <small class="text-muted">
                            <span class="text-danger">*</span> Wajib diisi
                        </small>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('dudi.index') }}" class="btn btn-secondary float-left">Batal</a>
                        <button type="submit" class="btn btn-primary float-right">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
