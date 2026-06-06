<!-- Modal Reset Password -->
<div class="modal fade" id="formresetpassword{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="formresetpasswordLabel{{ $id }}" aria-hidden="true" style="position: fixed;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('users.reset-password') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $id }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="formresetpasswordLabel{{ $id }}">Reset Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin ingin mereset password?</p>
                    <p>Password akan kembali menjadi default <strong>"CTR123"</strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>
