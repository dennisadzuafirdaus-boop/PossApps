<?php

namespace App\View\Components\Product;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormProduct extends Component
{
    /**
     * Create a new component instance.
     */
    public $id, $kategori_id, $nama_produk, $sku, $harga_jual, $harga_beli_pokok, $stok, $stok_minimum, $is_active, $kategoris;
    public function __construct($id = null)
    
    {
        $this-> kategoris = \App\Models\Kategori::all();
        if ($id) {
            $product = \App\Models\Product::find($id);
            $this->id = $product->id;
            $this->kategori_id = $product->kategori_id;
            $this->nama_produk = $product->nama_produk;
            $this->sku = $product->sku;
            $this->harga_jual = $product->harga_jual;
            $this->harga_beli_pokok = $product->harga_beli_pokok;
            $this->stok = $product->stok;
            $this->stok_minimum = $product->stok_minimum;
            $this->is_active = $product->is_active;
        }
        
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.product.form-product');
    }
}
