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
                        <label for="nama">Nama User</label>
                        <input type="text" id="nama" class="form-control autocomplete-user"
                            value="{{ $kaprodi->user->nama ?? '' }}">
                        <input type="hidden" name="user_id" id="user_id" value="{{ $kaprodi->user_id }}">
                        @error('user_id')
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
        $(".autocomplete-user").autocomplete({
            source: "/autocomplete/users",
            minLength: 2,
            select: function(event, ui) {
                $("#nama").val(ui.item.label);
                $("#user_id").val(ui.item.id);
                return false;
            }
        });
    });
</script>
@endsection
