<!-- Modal Konfigurasi Akun -->
<div class="modal fade" id="formKonfigurasiAkun" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('users.update-profil') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Konfigurasi Akun</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Avatar Preview -->
                    <div class="text-center mb-4">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=667eea&color=fff&size=100"
                             class="img-circle elevation-3" alt="Avatar" style="width: 100px; height: 100px;">
                        <p class="text-muted small mt-2">Avatar otomatis dari nama</p>
                    </div>

                    <div class="form-group">
                        <label for="nama">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama" name="name" 
                               value="{{ old('name', auth()->user()->name) }}" required>
                        @error('name')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="{{ old('email', auth()->user()->email) }}" required>
                        @error('email')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Role</label>
                        <input type="text" class="form-control" value="{{ strtoupper(auth()->user()->role) }}" readonly>
                        <small class="text-muted">Role tidak dapat diubah</small>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Untuk mengubah password, gunakan menu <strong>Ganti Password</strong>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
