<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'qty',
        'harga_jual',
        'harga_beli',
        'total',
        'keuntungan',
        'tanggal'
    ];

    protected $casts = [
        'harga_jual' => 'decimal:2',
        'harga_beli' => 'decimal:2',
        'total' => 'decimal:2',
        'keuntungan' => 'decimal:2',
        'tanggal' => 'date'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
