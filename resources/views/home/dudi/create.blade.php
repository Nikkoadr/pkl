<div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <form action="{{ route('dudi.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title" id="modalTambahLabel">Tambah DUDI</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>
                                Nama DUDI <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nama_dudi" class="form-control @error('nama_dudi') is-invalid @enderror" required>
                            @error('nama_dudi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>Alamat DUDI</label>
                            <input type="text" name="alamat_dudi" class="form-control @error('alamat_dudi') is-invalid @enderror">
                            @error('alamat_dudi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>No. Telp</label>
                            <input type="text" name="no_telp_dudi" class="form-control @error('no_telp_dudi') is-invalid @enderror">
                            @error('no_telp_dudi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>Jabatan Pimpinan</label>
                            <input type="text" name="jabatan_pimpinan" class="form-control @error('jabatan_pimpinan') is-invalid @enderror">
                            @error('jabatan_pimpinan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>Nomor Kepegawaian</label>
                            <input type="text" name="nomor_kepegawaian" class="form-control @error('nomor_kepegawaian') is-invalid @enderror">
                            @error('nomor_kepegawaian')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>Nama Pimpinan</label>
                            <input type="text" name="nama_pimpinan_dudi" class="form-control @error('nama_pimpinan_dudi') is-invalid @enderror">
                            @error('nama_pimpinan_dudi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>
                                Kuota <span class="text-danger">*</span>
                            </label>
                            <input type="number" name="kuota" class="form-control @error('kuota') is-invalid @enderror" required>
                            @error('kuota')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label>
                                Kompetensi Keahlian <span class="text-danger">*</span>
                            </label>
                            <select name="kompetensi_keahlian_id" class="form-control @error('kompetensi_keahlian_id') is-invalid @enderror" required>
                                <option value="" disabled selected>-- Pilih Kompetensi Keahlian --</option>
                                @foreach($kompetensi_keahlian as $komp)
                                    <option value="{{ $komp->id }}">{{ $komp->nama_kompetensi }}</option>
                                @endforeach
                            </select>
                            @error('kompetensi_keahlian_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <small class="text-muted">
                        <span class="text-danger">*</span> Wajib diisi
                    </small>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>