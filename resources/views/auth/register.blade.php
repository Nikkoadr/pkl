<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrasi Peserta PKL</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- AdminLTE -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    <!-- jQuery UI (autocomplete) -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css" />
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        /* Minor cosmetic adjustments for a fresh, minimal look */
        .register-card-body { padding: 2rem; }
        .brand-head img { width: 64px; height: auto; }
        .form-section { background: #ffffff; border-radius: 12px; padding: 1.25rem; box-shadow: 0 6px 18px rgba(15,23,42,0.06); }
        label { font-weight: 600; font-size: 0.95rem; }
        .required::after { content: " *"; color: #e3342f; }
        .ui-autocomplete { max-height: 220px; overflow-y: auto; overflow-x: hidden; }
        @media (max-width: 767px) { .brand-head { text-align: center; } }
    </style>
</head>
<body class="hold-transition register-page">

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="w-100" style="max-width: 900px;">
        <div class="card">
            <div class="card-body register-card-body">

                <div class="d-flex align-items-center mb-4 brand-head">
                    <img src="{{ asset('assets/dist/img/logo.png') }}" alt="logo SMK" class="me-3">
                    <div>
                        <h3 class="mb-0">Registrasi Peserta PKL</h3>
                        <p class="text-muted mb-0">Form pendaftaran akun peserta untuk program PKL</p>
                    </div>
                </div>

                <form action="{{ route('register') }}" method="POST" novalidate>
                    @csrf

                    <div class="row g-3">
                        <div class="col-12 col-lg-6">
                            <div class="form-section">
                                <div class="mb-3">
                                    <label for="tahun_ajaran_id" class="required">Tahun Ajaran</label>
                                    <select name="tahun_ajaran_id" id="tahun_ajaran_id" class="form-control @error('tahun_ajaran_id') is-invalid @enderror" required>
                                        @if ($tahun_ajaran)
                                            <option value="{{ $tahun_ajaran->id }}" selected>{{ $tahun_ajaran->nama_tahun_ajaran }}</option>
                                        @else
                                            <option disabled>Belum ada tahun ajaran</option>
                                        @endif
                                    </select>
                                    @error('tahun_ajaran_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="mb-3">
                                    <label for="nisn" class="required">NISN</label>
                                    <input type="text" name="nisn" id="nisn" maxlength="15" class="form-control @error('nisn') is-invalid @enderror"
                                        placeholder="Contoh: 0062345678" value="{{ old('nisn') }}" required>
                                    @error('nisn')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="mb-3">
                                    <label for="nis" class="required">NIS</label>
                                    <input type="text" name="nis" id="nis" maxlength="15" class="form-control @error('nis') is-invalid @enderror"
                                        placeholder="Contoh: 242912xxx" value="{{ old('nis') }}" required>
                                    @error('nis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="mb-3">
                                    <label for="nama" class="required">Nama Lengkap</label>
                                    <input type="text" oninput="this.value = this.value.toUpperCase()" name="nama" id="nama"
                                        class="form-control @error('nama') is-invalid @enderror"
                                        placeholder="Contoh: ANDI SAPUTRA" value="{{ old('nama') }}" required>
                                    @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="mb-3">
                                    <label for="tempat_lahir">Tempat Lahir</label>
                                    <input type="text" oninput="this.value = this.value.toUpperCase()" name="tempat_lahir" id="tempat_lahir"
                                        class="form-control @error('tempat_lahir') is-invalid @enderror"
                                        placeholder="Contoh: BANDUNG" value="{{ old('tempat_lahir') }}">
                                    @error('tempat_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="mb-3">
                                    <label for="tanggal_lahir" class="required">Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                                        class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                        value="{{ old('tanggal_lahir') }}" required>
                                    @error('tanggal_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-section">

                                <div class="mb-3">
                                    <label for="kelas_id" class="required">Kelas</label>
                                    <select name="kelas_id" id="kelas_id" class="form-control @error('kelas_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Kelas --</option>
                                        @foreach ($kelas as $k)
                                            <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                                        @endforeach
                                    </select>
                                    @error('kelas_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="mb-3">
                                    <label for="jenis_kelamin" class="required">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control @error('jenis_kelamin') is-invalid @enderror" required>
                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                        <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="mb-3">
                                    <label for="nama_dudi" class="required">Nama DUDI</label>
                                    <input type="text" id="nama_dudi" class="form-control @error('dudi_id') is-invalid @enderror"
                                        placeholder="Ketik minimal 2 huruf untuk mencari" value="{{ old('dudi_name') }}" required>
                                    <input type="hidden" name="dudi_id" id="dudi_id" value="{{ old('dudi_id') }}" required>
                                    @error('dudi_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="required">Email</label>
                                    <input type="email" name="email" id="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="Contoh: andi@example.com" value="{{ old('email') }}" required>
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="required">Password</label>
                                    <input type="password" name="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Minimal 8 karakter" required>
                                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password_confirmation" class="required">Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="form-control" placeholder="Ulangi password" required>
                                </div>

                            </div>

                        </div>
<div class="col-12 mt-3 d-flex gap-2">
    <button type="submit" class="btn btn-primary w-100 py-2">Daftar</button>
    <a href="{{ route('login') }}" class="btn btn-outline-secondary w-100 py-2">Sudah Punya Akun</a>
</div>

                        <div class="col-12">
                            <p class="text-muted small mt-3">Dengan mendaftar, kamu menyetujui kebijakan penggunaan sistem dan data yang diminta untuk keperluan administrasi PKL.</p>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

<script>
    $(function () {
        // autocomplete DUDI
        $("#nama_dudi").autocomplete({
            source: '/autocomplete/dudi',
            minLength: 2,
            select: function (event, ui) {
                $('#nama_dudi').val(ui.item.label);
                $('#dudi_id').val(ui.item.id);
                return false;
            }
        });

        // ensure DUDI selected from list before submit
        $('form').on('submit', function(e) {
            if (!$('#dudi_id').val()) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Pilih Nama DUDI',
                    text: 'Silakan pilih Nama DUDI dari daftar yang muncul sebelum melanjutkan.',
                    timer: 3500,
                    showConfirmButton: true
                });
                $('#nama_dudi').focus();
                return false;
            }
        });

        // show flash messages with SweetAlert2
        @if (session('success'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: @json(session('success')),
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        @endif

        @if (session('error'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: @json(session('error')),
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        @endif
    });
</script>

</body>
</html>