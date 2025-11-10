@extends('layouts.master')
@section('title', 'Edit Kaprodi')
@section('link')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css" />
@endsection
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Edit Kaprodi</h1>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('kaprodi.update', $kaprodi->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Autocomplete User --}}
                    <div class="form-group">
                        <label for="nama_guru">Nama User</label>
                        <input type="text" id="nama_guru" class="form-control"
                            value="{{ $kaprodi->guru->user->nama ?? '' }}">
                        <input type="hidden" name="guru_id" id="guru_id" value="{{ $kaprodi->guru_id }}">
                        @error('guru_id')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Kompetensi Keahlian --}}
                    <div class="form-group">
                        <label for="kompetensi_keahlian_id">Kompetensi Keahlian</label>
                        <select name="kompetensi_keahlian_id" id="kompetensi_keahlian_id" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            @foreach($kompetensi as $kk)
                                <option value="{{ $kk->id }}"
                                    {{ $kaprodi->kompetensi_keahlian_id == $kk->id ? 'selected' : '' }}>
                                    {{ $kk->nama_kompetensi }}
                                </option>
                            @endforeach
                        </select>
                        @error('kompetensi_keahlian_id')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('kaprodi.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script>
    
    $(function() {
        $("#nama_guru").autocomplete({
            source: "/autocomplete/guru",
            minLength: 2,
            select: function(event, ui) {
                $("#nama_guru").val(ui.item.label);
                $("#guru_id").val(ui.item.id);
                return false;
            }
        });
    });
</script>
@endsection
