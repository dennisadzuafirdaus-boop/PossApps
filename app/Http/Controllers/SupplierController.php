<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::orderBy('created_at', 'desc')->paginate(10);
        confirmDelete('Hapus Data', 'Apakah anda yakin menghapus data ini?');
        return view('supplier.index', compact('suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'kontak_person' => 'nullable|string|max:255',
        ], [
            'nama_supplier.required' => 'Nama supplier wajib diisi',
        ]);

        $id = $request->id;
        
        Supplier::updateOrCreate(
            ['id' => $id],
            [
                'kode_supplier' => $id ? Supplier::find($id)->kode_supplier : Supplier::generateKodeSupplier(),
                'nama_supplier' => $request->nama_supplier,
                'alamat' => $request->alamat,
                'telepon' => $request->telepon,
                'email' => $request->email,
                'kontak_person' => $request->kontak_person,
                'is_active' => true,
            ]
        );

        toast()->success($id ? 'Supplier berhasil diperbarui' : 'Supplier berhasil ditambahkan');
        return redirect()->route('master-data.supplier.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        return response()->json($supplier);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        toast()->success('Supplier berhasil dihapus');
        return redirect()->route('master-data.supplier.index');
    }

    /**
     * Toggle active status
     */
    public function toggleStatus($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->update(['is_active' => !$supplier->is_active]);

        toast()->success('Status supplier berhasil diubah');
        return redirect()->route('master-data.supplier.index');
    }

    /**
     * Get supplier data for Select2
     */
    public function getData(Request $request)
    {
        $search = $request->query('search');
        $data = Supplier::where('is_active', true)
            ->where(function($q) use ($search) {
                $q->where('nama_supplier', 'like', '%' . $search . '%')
                  ->orWhere('kode_supplier', 'like', '%' . $search . '%');
            })
            ->get();

        return response()->json($data);
    }
}
