@extends('layouts.master')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Tambah Logbook</h1>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th style="width: 150px;">Tanggal</th>
                                <td>{{ now()->format('d-m-Y') }}</td>
                            </tr>
                            <tr>
                                <th>Jam</th>
                                <td>{{ now()->format('H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Peserta</th>
                                <td>{{ $nama_peserta }}</td>
                            </tr>
                            <tr>
                                <th>DUDI</th>
                                <td>{{ $nama_dudi }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <hr>
                        <form action="{{ route('logbook.store_siswa') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            {{-- Foto Bukti --}}
                            <div class="form-group col-12">
                                <label for="foto_bukti">Foto Bukti</label>
                                <div class="custom-file">
                                    <input type="file" name="foto_bukti" id="foto_bukti" 
                                        class="custom-file-input @error('foto') is-invalid @enderror">
                                    <label class="custom-file-label" for="foto">Pilih foto...</label>
                                    @error('foto')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Keterangan --}}
                            <div class="form-group col-12">
                                <label for="keterangan">Keterangan</label>
                                <textarea name="keterangan" id="keterangan" rows="4" 
                                    class="form-control @error('keterangan') is-invalid @enderror" 
                                    placeholder="Contoh: Menyelesaikan laporan harian">{{ old('keterangan') }}</textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('logbook.index') }}" class="btn btn-secondary">Batal</a>
                        </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(function () {
    bsCustomFileInput.init();
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
