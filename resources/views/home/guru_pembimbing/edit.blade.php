@extends('layouts.master')
@section('title', 'Edit Guru Pembimbing')
@section('link')
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Edit Guru Pembimbing</h1>
    </section>

    <section class="content">
        <form action="{{ route('guru_pembimbing.update', $data->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nama_guru">Nama Guru</label>
                <input type="text" class="form-control" id="nama_guru" value="{{ $data->guru->user->nama }}">
                <input type="hidden" name="guru_id" id="guru_id" value="{{ $data->guru_id }}">
            </div>

            <div class="form-group">
                <label for="nama_dudi">Nama DUDI</label>
                <input type="text" class="form-control" id="nama_dudi" value="{{ $data->dudi->nama_dudi }}">
                <input type="hidden" name="dudi_id" id="dudi_id" value="{{ $data->dudi_id }}">
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('guru_pembimbing.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </section>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
$(function() {
    function setupAutocomplete(selector, hiddenSelector, url) {
        $(selector).autocomplete({
            source: url,
            minLength: 2,
            select: function(event, ui) {
                $(selector).val(ui.item.label);
                $(hiddenSelector).val(ui.item.id);
                return false;
            }
        });
    }

    setupAutocomplete("#nama_guru", "#guru_id", "/autocomplete/guru");
    setupAutocomplete("#nama_dudi", "#dudi_id", "/autocomplete/dudi");
});
</script>
@endsection
