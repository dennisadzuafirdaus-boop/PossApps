<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = \App\Models\Kategori::all();
        confirmDelete('Hapus Data','Apakah anda yakin menghapus data ini?');
        return view('kategori.index', compact('kategori'));
    }


    public function store(Request $request) {
        $id = $request->id;
        $request->validate([
            'nama_kategori' => 'required|unique:kategoris,nama_kategori,' . $id,
            'deskripsi' => 'required|max:500|min:10',
        ], [
            'nama_kategori.required' => 'Nama Kategori wajib diisi.',
            'nama_kategori.unique' => 'Nama Kategori sudah ada.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'deskripsi.max' => 'Deskripsi maksimal 500 karakter.',
            'deskripsi.min' => 'Deskripsi minimal 10 karakter.',
        ]);

        kategori::updateOrCreate(
            ['id' => $id],
            [
                'nama_kategori' => $request->nama_kategori,
                'deskripsi' => $request->deskripsi,
                'slug' => Str::slug($request->nama_kategori),
            ]
        );
        toast()->success('Data kategori berhasil disimpan.');
        return redirect()->route('master-data.kategori.index');
    }

    //method destroy akan ditempatkan disini nanti
    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        toast()->success('Data kategori berhasil dihapus.');
        return redirect()->route('master-data.kategori.index');
    }
}
