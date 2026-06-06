<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodsReceiptItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'goods_receipt_id',
        'product_id',
        'qty',
        'stok_sebelum',
        'stok_sesudah',
        'harga_beli',
        'keterangan'
    ];

    protected $casts = [
        'harga_beli' => 'decimal:2'
    ];

    /**
     * Relasi ke goods receipt
     */
    public function goodsReceipt()
    {
        return $this->belongsTo(GoodsReceipt::class, 'goods_receipt_id');
    }

    /**
     * Relasi ke product
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
