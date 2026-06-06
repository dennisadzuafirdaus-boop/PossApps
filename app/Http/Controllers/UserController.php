<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {   
        $users = User::all();
        confirmDelete('Hapus Data','Apa anda yakin hapus data ini?');
        return view('users.index' , compact('users'));
    }

    public function store(Request $request)
    {

        $id = $request->id;
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
        ],
        [
            'email.required' => 'Email wajib diisi.',
            'name.required' => 'Nama wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah ada.',
        ]);

        $newRequest = $request->all();

        if (!$id) {
            $newRequest['password'] = Hash::make('CTR123');
        }
        User::updateOrCreate(['id' => $id],$newRequest);
        toast('Data berhasil disimpan','success');
        return redirect()->route('users.index');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        //cek jika user yang akan dihapus adalah user yang sedang login
        if (Auth::id() == $id) {
            toast('Tidak dapat menghapus user yang sedang login','error');
            return redirect()->route('users.index');
        }
        $user->delete();
        toast('Data berhasil dihapus','success');
        return redirect()->route('users.index');
    }

    public function gantiPassword(Request $request){
        //valadasi ganti password yang dimana ada component from ganti password
        $request->validate([
            'password_lama'      => 'required',
            'password_baru'     => ['required', Password::min(5)->MixedCase()->numbers(), 'confirmed'],
        ],
        [
            'password_lama.required' => 'Password lama wajib diisi.',
            'password_baru.min' => 'Password minimal 5 karakter.',
            'password_baru.mixed_case' => 'Password harus mengandung huruf besar dan kecil.',
            'password_baru.numbers' => 'Password harus mengandung angka.',
            'password_baru.required' => 'Password baru wajib diisi.',
            'password_baru.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);
    //ambil data user yang sedang login
    $user = User::find(Auth::id());

    //check password

    if (!Hash::check($request->password_lama, $user->password)) {
        toast('Password lama tidak sesuai','error');
        return redirect()->route('dashboard.index');
    }

    //update password
    $user->update([
        'password' => Hash::make($request->password_baru)
    ]);

    toast('Password berhasil diganti','success');
    return redirect()->route('dashboard.index');

    }

    /**
     * Update profil user yang sedang login
     */
    public function updateProfil(Request $request)
    {
        $userId = Auth::id();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $userId,
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh user lain.',
        ]);

        $user = User::find($userId);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        toast('Profil berhasil diperbarui','success');
        return redirect()->back();
    }

    public function resetpassword(Request $request){
        $request->validate([
            'id' => 'required|exists:users,id',
        ]);

        $user = User::find($request->id);
        $user->update([
            'password' => Hash::make('CTR123')
        ]);

        toast('Password berhasil direset ke CTR123','success');
        return redirect()->route('users.index');
    }

}



