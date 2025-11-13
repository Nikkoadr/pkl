{{-- resources/views/profile/edit.blade.php --}}
@extends('layouts.master')

@section('title', 'Profil Saya')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Profil Saya</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Ubah Profil</h3>
                </div>
                <form action="{{ route('home.profil.update', auth()->user()->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card-body row">
                        {{-- Foto Profil --}}
                        <div class="col-md-4 text-center">
                            <div class="mb-3">
                                <img src="{{ auth()->user()->foto_profil ? asset('storage/foto_profil/' . auth()->user()->foto_profil) : asset('assets/dist/img/about.png') }}"
                                    class="img-fluid rounded" style="max-height: 220px; object-fit: cover;" alt="Foto Profil">
                            </div>
                        <div class="form-group">
                            <label for="foto_profil">Foto Profil</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('foto_profil') is-invalid @enderror" id="foto_profil" name="foto_profil" accept="image/*">
                                <label class="custom-file-label" for="foto_profil">Pilih file</label>
                                @error('foto_profil')
                                    <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        </div>

                        {{-- Data User --}}
                        <div class="col-md-8">
                            @if(auth()->user()->peserta)
                                    <div class="form-group">
                                        <label for="nis">NIS</label>
                                        <input type="text" name="nis" id="nis" 
                                            class="form-control @error('nis') is-invalid @enderror"
                                            value="{{ old('nis', auth()->user()->peserta->nis ?? '') }}">
                                        @error('nis') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="nisn">NISN</label>
                                        <input type="text" name="nisn" id="nisn" 
                                            class="form-control @error('nisn') is-invalid @enderror"
                                            value="{{ old('nisn', auth()->user()->peserta->nisn ?? '') }}">
                                        @error('nisn') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>

                                @if(isset($kelas) && $kelas->count())
                                        <div class="form-group">
                                            <label for="kelas_id">Kelas</label>
                                            <select name="kelas_id" id="kelas_id" class="form-control @error('kelas_id') is-invalid @enderror">
                                                <option value="" disabled selected>-- Pilih Kelas --</option>
                                                @foreach($kelas as $k)
                                                    <option value="{{ $k->id }}" 
                                                        {{ old('kelas_id', auth()->user()->peserta->kelas_id ?? '') == $k->id ? 'selected' : '' }}>
                                                        {{ $k->nama_kelas }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('kelas_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                        </div>
                                @endif
                            @endif
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror"
                                    value="{{ old('nama', auth()->user()->nama) }}">
                                @error('nama') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control @error('jenis_kelamin') is-invalid @enderror">
                                        <option value="" disabled>-- Pilih --</option>
                                        <option value="Laki-laki" {{ old('jenis_kelamin', auth()->user()->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ old('jenis_kelamin', auth()->user()->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', auth()->user()->email) }}">
                                    @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="tempat_lahir">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror"
                                        value="{{ old('tempat_lahir', auth()->user()->tempat_lahir) }}">
                                    @error('tempat_lahir') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="tanggal_lahir">Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" 
                                        class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                        value="{{ old('tanggal_lahir', auth()->user()->tanggal_lahir) }}">
                                    @error('tanggal_lahir') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <hr>

                            {{-- Password --}}
                            <div class="form-group">
                                <label for="password">Password Baru</label>
                                <input type="password" 
                                    class="form-control @error('password') is-invalid @enderror" 
                                    id="password" 
                                    name="password" 
                                    placeholder="Kosongkan jika tidak ingin mengubah">
                                @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Konfirmasi Password Baru</label>
                                <input type="password" 
                                    class="form-control @error('password_confirmation') is-invalid @enderror" 
                                    id="password_confirmation" 
                                    name="password_confirmation" 
                                    placeholder="Ulangi password baru">
                                @error('password_confirmation') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group text-right">
                                <a href="{{ url()->previous() }}" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script>
$(function () {
    bsCustomFileInput.init();

    $('#foto_profil').on('change', function(event) {
        let reader = new FileReader();
        reader.onload = function(e) {
            $('img[alt="Foto Profil"]').attr('src', e.target.result);
        }
        reader.readAsDataURL(event.target.files[0]);
    });
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
