<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrasi Akun | Manajemen PKL</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body class="hold-transition register-page">
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow w-100" style="max-width: 700px;">
        <div class="card-body register-card-body">
            <div class="text-center mb-4">
                <img src="{{ asset('assets/dist/img/logo.png') }}" alt="logo SMK" style="width: 12%;">
                <h3 class="mt-2"><b>Manajemen</b> PKL</h3>
                <p class="text-muted">Formulir Pendaftaran Akun</p>
            </div>

            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="tahun_ajaran_id">Tahun Ajaran</label>
                        <select name="tahun_ajaran_id" id="tahun_ajaran_id" class="form-control @error('tahun_ajaran_id') is-invalid @enderror" required>
                            @if ($tahun_ajaran)
                                <option value="{{ $tahun_ajaran->id }}" selected>{{ $tahun_ajaran->nama_tahun_ajaran }}</option>
                            @else
                                <option disabled>Belum ada tahun ajaran</option>
                            @endif
                        </select>
                        @error('tahun_ajaran_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12 mb-3">
                        <label for="nisn">NISN</label>
                        <input type="text" name="nisn" id="nisn" class="form-control @error('nisn') is-invalid @enderror"
                               placeholder="Contoh: 0062345678" value="{{ old('nisn') }}" required>
                        @error('nisn')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12 mb-3">
                        <label for="nis">NIS</label>
                        <input type="text" name="nis" id="nis" class="form-control @error('nis') is-invalid @enderror"
                               placeholder="Contoh: 242912xxx" value="{{ old('nis') }}" required>
                        @error('nis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12 mb-3">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" oninput="this.value = this.value.toUpperCase()" name="nama" id="nama"
                               class="form-control @error('nama') is-invalid @enderror"
                               placeholder="Contoh: ANDI SAPUTRA" value="{{ old('nama') }}" required>
                        @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12 mb-3">
                        <label for="tempat_lahir">Tempat Lahir</label>
                        <input type="text" oninput="this.value = this.value.toUpperCase()" name="tempat_lahir" id="tempat_lahir"
                               class="form-control @error('tempat_lahir') is-invalid @enderror"
                               placeholder="Contoh: BANDUNG" value="{{ old('tempat_lahir') }}">
                        @error('tempat_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12 mb-3">
                        <label for="tanggal_lahir">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                               class="form-control @error('tanggal_lahir') is-invalid @enderror"
                               value="{{ old('tanggal_lahir') }}" required>
                        @error('tanggal_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12 mb-3">
                        <label for="kelas_id">Kelas</label>
                        <select name="kelas_id" id="kelas_id" class="form-control @error('kelas_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Kelas --</option>
                            @foreach ($kelas as $k)
                                <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                        @error('kelas_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12 mb-3">
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control @error('jenis_kelamin') is-invalid @enderror" required>
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12 mb-3">
                        <label for="nama_dudi">Nama DUDI</label>
                        <input type="text" id="nama_dudi" class="form-control @error('dudi_id') is-invalid @enderror"
                               placeholder="Ketik minimal 2 huruf untuk mencari" required>
                        <input type="hidden" name="dudi_id" id="dudi_id" required>
                        @error('dudi_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12 mb-3">
                        <label for="alamat_dudi">Alamat DUDI</label>
                        <input type="text" name="alamat_dudi" id="alamat_dudi"
                               class="form-control @error('alamat_dudi') is-invalid @enderror"
                               placeholder="Alamat DUDI akan otomatis terisi" readonly>
                        @error('alamat_dudi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12 mb-3">
                        <label for="nama_pimpinan_dudi">Nama Pimpinan DUDI</label>
                        <input type="text" name="nama_pimpinan_dudi" id="nama_pimpinan_dudi"
                               class="form-control @error('nama_pimpinan_dudi') is-invalid @enderror"
                               placeholder="Nama pimpinan akan otomatis terisi" readonly>
                        @error('nama_pimpinan_dudi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12 mb-3">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email"
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="Contoh: andi@example.com" value="{{ old('email') }}" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12 mb-3">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Minimal 8 karakter" required>
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12 mb-4">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                               class="form-control" placeholder="Ulangi password" required>
                    </div>

                    <div class="col-12 d-flex">
                        <button type="submit" class="btn btn-primary w-50 me-2">Daftar</button>
                        <a href="{{ route('login') }}" class="btn btn-secondary w-50">Sudah Punya Akun</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
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

        $('form').on('submit', function(e) {
            if (!$('#dudi_id').val()) {
                e.preventDefault();
                alert('Silakan pilih Nama DUDI dari daftar yang muncul.');
                $('#nama_dudi').focus();
            }
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
</body>
</html>
