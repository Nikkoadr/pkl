@extends('layouts.master')
@section('title', 'Tambah Peserta')

@section('link')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1 class="mb-2">Tambah Peserta</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <form action="{{ route('peserta.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Tahun Ajaran -->
                                <div class="form-group">
                                    <label>Tahun Ajaran</label>
                                    <select name="tahun_ajaran_id" class="form-control @error('tahun_ajaran_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Tahun Ajaran --</option>
                                        @foreach ($tahun_ajaran as $ta)
                                            <option value="{{ $ta->id }}" {{ old('tahun_ajaran_id') == $ta->id ? 'selected' : '' }}>{{ $ta->nama_tahun_ajaran }}</option>
                                        @endforeach
                                    </select>
                                    @error('tahun_ajaran_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <!-- NISN -->
                                <div class="form-group">
                                    <label>NISN</label>
                                    <input type="text" name="nisn" class="form-control @error('nisn') is-invalid @enderror" value="{{ old('nisn') }}" placeholder="NISN" required>
                                    @error('nisn')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <!-- NIS -->
                                <div class="form-group">
                                    <label>NIS</label>
                                    <input type="text" name="nis" class="form-control @error('nis') is-invalid @enderror" value="{{ old('nis') }}" placeholder="NIS" required>
                                    @error('nis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <!-- Nama Lengkap -->
                                <div class="form-group">
                                    <label>Nama Lengkap</label>
                                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" placeholder="Nama Lengkap" required>
                                    @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <!-- Tempat Lahir -->
                                <div class="form-group">
                                    <label>Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror" value="{{ old('tempat_lahir') }}" placeholder="Tempat Lahir">
                                    @error('tempat_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <!-- Tanggal Lahir -->
                                <div class="form-group">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir') }}" required>
                                    @error('tanggal_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Kelas -->
                                <div class="form-group">
                                    <label>Kelas</label>
                                    <select name="kelas_id" class="form-control @error('kelas_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Kelas --</option>
                                        @foreach ($kelas as $k)
                                            <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                                        @endforeach
                                    </select>
                                    @error('kelas_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <!-- Jenis Kelamin -->
                                <div class="form-group">
                                    <label>Jenis Kelamin</label>
                                    <select name="jenis_kelamin" class="form-control @error('jenis_kelamin') is-invalid @enderror" required>
                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                        <option value="1" {{ old('jenis_kelamin') == '1' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="2" {{ old('jenis_kelamin') == '2' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <!-- Nama DUDI (Autocomplete) -->
                                <div class="form-group">
                                    <label>Nama DUDI</label>
                                    <input type="text" id="nama_dudi" class="form-control @error('dudi_id') is-invalid @enderror" placeholder="Nama DUDI" required>
                                    <input type="hidden" name="dudi_id" id="dudi_id" required>
                                    @error('dudi_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <!-- Alamat DUDI -->
                                <div class="form-group">
                                    <label>Alamat DUDI</label>
                                    <input type="text" name="alamat_dudi" id="alamat_dudi" class="form-control" placeholder="Alamat DUDI" readonly>
                                </div>

                                <!-- Pimpinan DUDI -->
                                <div class="form-group">
                                    <label>Nama Pimpinan DUDI</label>
                                    <input type="text" name="nama_pimpinan_dudi" id="nama_pimpinan_dudi" class="form-control" placeholder="Nama Pimpinan DUDI" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Email" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required>
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <!-- Konfirmasi Password -->
                        <div class="form-group">
                            <label>Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password" required>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('peserta.index') }}" class="btn btn-secondary float-right">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script>
    $(function () {
        $("#nama_dudi").autocomplete({
            source: '/autocomplete/dudi',
            minLength: 2,
            select: function (event, ui) {
                $('#nama_dudi').val(ui.item.label);
                $('#dudi_id').val(ui.item.id);
                $('#alamat_dudi').val(ui.item.alamat);
                $('#nama_pimpinan_dudi').val(ui.item.pimpinan);
                return false;
            }
        });
    });
</script>
@endsection
