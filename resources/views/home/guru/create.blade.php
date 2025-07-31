@extends('layouts.master')
@section('title', 'Tambah Guru')
@section('link')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@endsection
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Tambah Guru</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <form action="{{ route('guru.store') }}" method="POST">
                    @csrf
                    <div class="card-body row">
                        <div class="form-group col-md-6">
                            <label for="nama">Nama Guru</label>
                            <input type="text" id="nama" class="form-control" placeholder="Cari nama guru..." required>
                            <input type="hidden" name="user_id" id="user_id" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="keterangan">Keterangan</label>
                            <input type="text" id="keterangan" class="form-control">
                        </div>

                    </div>
                    <div class="card-footer">
                        <a href="{{ route('guru.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
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
            $("#nama").autocomplete({
                source: '/autocomplete/users',
                minLength: 2,
                select: function (event, ui) {
                    $('#nama').val(ui.item.label);
                    $('#user_id').val(ui.item.id);
                    return false;
                }
            });

            $('form').on('submit', function(e) {
                if (!$('#user_id').val()) {
                    e.preventDefault();
                    alert('Silakan pilih nama user dari daftar.');
                    $('#nama').focus();
                }
            });
        });
    </script>
@endsection
