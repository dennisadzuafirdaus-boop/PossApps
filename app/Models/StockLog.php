<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'tanggal',
        'nomor_transaksi',
        'tipe',
        'qty',
        'stok_sebelum',
        'stok_sesudah',
        'user_id',
        'keterangan'
    ];

    protected $casts = [
        'tanggal' => 'date'
    ];

    /**
     * Tipe transaksi
     */
    const TIPE_MASUK = 'masuk';
    const TIPE_KELUAR = 'keluar';
    const TIPE_PENYESUAIAN = 'penyesuaian';

    /**
     * Relasi ke product
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Relasi ke user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Scope filter berdasarkan tanggal
     */
    public function scopeFilterByDate($query, $startDate, $endDate)
    {
        if ($startDate) {
            $query->where('tanggal', '>=', $startDate);
        }
        if ($endDate) {
            $query->where('tanggal', '<=', $endDate);
        }
        return $query;
    }

    /**
     * Scope filter berdasarkan tipe
     */
    public function scopeFilterByType($query, $tipe)
    {
        if ($tipe && $tipe != 'semua') {
            $query->where('tipe', $tipe);
        }
        return $query;
    }

    /**
     * Scope filter berdasarkan produk
     */
    public function scopeFilterByProduct($query, $productId)
    {
        if ($productId) {
            $query->where('product_id', $productId);
        }
        return $query;
    }
}
