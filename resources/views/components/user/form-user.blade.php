<div>
    <!-- Button trigger modal -->
    <button type="button" class="btn {{ $id ? 'btn-sm btn-primary' : 'btn-success btn-sm' }}" data-toggle="modal" data-target="#formUser{{ $id ?? '' }}">
        @if ($id)
            <i class="fas fa-edit"></i>
        @else
            Tambah User
        @endif
    </button>

    <!-- Modal -->
    <div class="modal fade" id="formUser{{ $id ?? '' }}" tabindex="-1" role="dialog" aria-labelledby="formUserLabel{{ $id ?? '' }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $id ?? '' }}">
                    <div class="modal-header">
                        <h4 class="modal-title" id="formUserLabel{{ $id ?? '' }}">{{ $id ? 'Edit User' : 'Form User Baru' }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="email{{ $id ?? '' }}">Email</label>
                            <input type="email" class="form-control" id="email{{ $id ?? '' }}" name="email" value="{{ $id ? $email : old('email') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="name{{ $id ?? '' }}">Name</label>
                            <input type="text" class="form-control" id="name{{ $id ?? '' }}" name="name" value="{{ $id ? $name : old('name') }}" required>
                        </div>
                        @if(!$id)
                        <div class="form-group">
                            <label for="password{{ $id ?? '' }}">Password</label>
                            <input type="password" class="form-control" id="password{{ $id ?? '' }}" name="password" required>
                        </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</div>
