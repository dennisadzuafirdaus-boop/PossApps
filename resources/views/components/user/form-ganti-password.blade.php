<!-- Modal Ganti Password -->
<div class="modal fade" id="formGantiPassword" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('users.ganti-password') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Ganti Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="password_lama">Password Lama</label>
                        <input type="password" class="form-control" id="password_lama" name="password_lama" required>
                    </div>
                    @error('password_lama')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label for="password_baru">Password Baru</label>
                        <input type="password" class="form-control" id="password_baru" name="password_baru" required>
                    </div>
                    @error('password_baru')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label for="password_baru_confirmation">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="password_baru_confirmation" name="password_baru_confirmation" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
