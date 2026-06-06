<?php

namespace App\Models;   

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'kategori_id',
        'nama_produk',
        'sku',
        'harga_jual',
        'harga_beli_pokok',
        'stok',
        'stok_minimum',
        'image',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    /**
     * Generate SKU otomatis
     */
    public static function nomorSKU()
    {
        $prefix = 'SKU-';
        $maxid = self::max('id');
        $sku = $prefix . str_pad($maxid + 1, 5, '0', STR_PAD_LEFT);
        return $sku;
    }

    /**
     * Relasi ke kategori
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    /**
     * Relasi ke goods receipt items
     */
    public function goodsReceiptItems()
    {
        return $this->hasMany(GoodsReceiptItem::class, 'product_id');
    }

    /**
     * Relasi ke stock logs
     */
    public function stockLogs()
    {
        return $this->hasMany(StockLog::class, 'product_id');
    }

    /**
     * Cek apakah stok menipis
     */
    public function isStokMenipis()
    {
        return $this->stok <= $this->stok_minimum;
    }

    /**
     * Scope untuk produk aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk produk dengan stok menipis
     */
    public function scopeStokMenipis($query)
    {
        return $query->whereColumn('stok', '<=', 'stok_minimum');
    }
}
