<?php

namespace App\View\Components\Kategori;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Kategori;

class FormKategori extends Component
{
    /**
     * Create a new component instance.
     */
    public $id, $nama_kategori, $deskripsi, $slug;
    public function __construct($id = null)
    {
        if ($id) {
            $kategori =Kategori::find($id);
            $this->id = $kategori->id;
            $this->nama_kategori = $kategori->nama_kategori;
            $this->deskripsi = $kategori->deskripsi;
            $this->slug = $kategori->slug;
        } else {
            $this->id = null;
            $this->nama_kategori = '';
            $this->deskripsi = '';
            $this->slug = '';
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.kategori.form-kategori');
    }
}
