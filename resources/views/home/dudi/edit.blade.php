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

            <!-- Notifikasi -->
            @if(session('success'))
                <script>
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: '{{ session("success") }}',
                        showConfirmButton: false,
                        timer: 2000
                    });
                </script>
            @endif

            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Form Edit</h3>
                </div>
                <form action="{{ route('dudi.update', $data->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body row">
                        <div class="form-group col-md-6">
                            <label>Nama DUDI</label>
                            <input type="text" name="nama_dudi" value="{{ $data->nama_dudi }}" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Alamat</label>
                            <input type="text" name="alamat_dudi" value="{{ $data->alamat_dudi }}" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label>No. Telp</label>
                            <input type="text" name="no_telp_dudi" value="{{ $data->no_telp_dudi }}" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Nomor Kepegawaian</label>
                            <input type="text" name="nomor_kepegawaian" value="{{ $data->nomor_kepegawaian }}" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Nama Pimpinan</label>
                            <input type="text" name="nama_pimpinan_dudi" value="{{ $data->nama_pimpinan_dudi }}" class="form-control">
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('dudi.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-warning">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
