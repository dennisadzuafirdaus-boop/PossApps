<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Kategori;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $kategoris = Kategori::all();
        confirmDelete('Hapus Data','Apakah anda yakin menghapus data ini?');
        return view('product.index', compact('products', 'kategoris'));
    }

    public function store(Request $request)
    {
        $id = $request->id;
        $request->validate([

            'nama_produk'          => 'required|unique:products,nama_produk,' . $id,
            'kategori_id'           => 'required|exists:kategoris,id',
            'harga_beli_pokok'      => 'required|numeric|min:0',
            'harga_jual'            => 'required|numeric|min:0',
            'stok'                  => 'required|numeric|min:0',
            'stok_minimum'          => 'required|numeric|min:0',
            'image'                 => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ],
        // custom error messages
        [
            'kategori_id.required'      => 'Kategori wajib diisi',
            'kategori_id.exists'        => 'Kategori tidak ditemukan',
            'nama_produk.required'     => 'Nama produk wajib diisi',
            'nama_produk.unique'       => 'Nama produk sudah digunakan',
            'harga_beli_pokok.required' => 'Harga beli pokok wajib diisi',
            'harga_beli_pokok.numeric'  => 'Harga beli pokok harus berupa angka',
            'harga_beli_pokok.min'      => 'Harga beli pokok minimal 1',
            'harga_jual.required'       => 'Harga jual wajib diisi',
            'harga_jual.numeric'        => 'Harga jual harus berupa angka',
            'harga_jual.min'            => 'Harga jual minimal 1',
            'stok.required'             => 'Stok wajib diisi',
            'stok.numeric'              => 'Stok harus berupa angka',
            'stok.min'                  => 'Stok minimal 0',
            'stok_minimum.required'     => 'Stok minimum wajib diisi',
            'stok_minimum.numeric'      => 'Stok minimum harus berupa angka',
            'stok_minimum.min'          => 'Stok minimum minimal 0',
            'is_active.required'        => 'Status aktif wajib diisi',
            'is_active.in'              => 'Status aktif tidak valid',        
            'image.image'               => 'File harus berupa gambar',
            'image.mimes'               => 'Format gambar harus jpeg, png, jpg, atau gif',
            'image.max'                 => 'Ukuran gambar maksimal 2MB',

        ]);
        //sku nya biar muncul
        $newRequest = [
                'id' => $id,
                'nama_produk'      => $request->nama_produk,
                // 'sku'
                'kategori_id'       => $request->kategori_id,
                'harga_beli_pokok'  => $request->harga_beli_pokok,
                'harga_jual'        => $request->harga_jual,
                'stok'              => $request->stok,
                'stok_minimum'      => $request->stok_minimum,
                'is_active'         => $request->is_active == 'Y' ? true : false,

        ];

            if (!$id) {
                $newRequest['sku'] = Product::nomorSKU();

            }

            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('product_images'), $imageName);
                $newRequest['image'] = $imageName;
            }

        Product::updateOrCreate(
            ['id' => $id],
            $newRequest
        );
        toast()->success('Data produk berhasil disimpan');
        return redirect()->route('master-data.product.index');
    }

    //bikin methord getdata
    public function getData(){
        //paramaternya adalah search
        $search = request()->query('search');
        //ambil data produk yang nama produknya mengandung search
        $query = Product::query();
        //like untuk mencari nama produk yang mengandung search tidak usah sama persis untuk mencarinya
        $products = $query->where('nama_produk', 'like', '%' . $search . '%')->get();
        return response()->json($products);
    }

    public function cekStok(){
        $id = request()->query('id');
        $product = Product::find($id);

        // jika produk tidak ditemukan, kembalikan 404 atau 0
        if (!$product) {
            return response()->json(0, 404);
        }

        $stok = $product->stok;
        return response()->json($stok);
    }
}

