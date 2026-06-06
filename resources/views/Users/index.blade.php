@extends('layouts.app')
@section('content_tittle', 'Data Users')
@section('content')
    <div class="card">
        <div class="p-2 d-flex justify-content-between border-bottom">
            <h4 class="h5">Daftar Users</h4>
            <div>
                <!-- Button to trigger modal -->
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#formUser">
                    Tambah User
                </button>
            </div>
        </div>
        <x-alert.sweetalert :errors="$errors" />
        <div class="card-body">
            <table class="table table-sm table-striped" id="table2">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $index => $user)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <!-- Edit button - triggers edit modal -->
                                    <button type="button" class="btn btn-sm btn-primary mx-1" data-toggle="modal" data-target="#formUser{{ $user->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <a href="{{ route('users.destroy', $user->id) }}" data-confirm-delete="true"
                                        class="btn btn-sm btn-danger mx-1">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    <div>
                                        <x-user.reset-password-button :id="$user->id" />
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modals diletakkan di luar card -->
    @foreach ($users as $user)
        <div class="modal fade" id="formUser{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="formUserLabel{{ $user->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $user->id }}">
                        <div class="modal-header">
                            <h4 class="modal-title" id="formUserLabel{{ $user->id }}">Edit User</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="email{{ $user->id }}">Email</label>
                                <input type="email" class="form-control" id="email{{ $user->id }}" name="email" value="{{ $user->email }}" required>
                            </div>
                            <div class="form-group">
                                <label for="name{{ $user->id }}">Name</label>
                                <input type="text" class="form-control" id="name{{ $user->id }}" name="name" value="{{ $user->name }}" required>
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
    @endforeach

    <!-- Modal Reset Password untuk setiap user -->
    @foreach ($users as $user)
        <x-user.reset-password :id="$user->id" />
    @endforeach

    <!-- Modal Tambah User -->
    <div class="modal fade" id="formUser" tabindex="-1" role="dialog" aria-labelledby="formUserLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title" id="formUserLabel">Form User Baru</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
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
@endsection
