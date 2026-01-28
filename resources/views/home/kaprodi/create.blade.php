<div class="modal fade" id="modalTambah">
    <div class="modal-dialog">
        <form action="{{ route('kaprodi.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kaprodi</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_guru">Nama</label>
                        <input type="text" class="form-control @error('guru_id') is-invalid @enderror" 
                            name="nama_guru" id="nama_guru" value="{{ old('nama_guru') }}" 
                            placeholder="Ketik nama...">
                        <input type="hidden" name="guru_id" id="guru_id" value="{{ old('guru_id') }}">
                        @error('guru_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="nama_kompetensi">Kompetensi Keahlian</label>
                        <input type="text" class="form-control" name="nama_kompetensi" id="nama_kompetensi" placeholder="Ketik kompetensi keahlian...">
                        <input type="hidden" name="kompetensi_keahlian_id" id="kompetensi_keahlian_id">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>