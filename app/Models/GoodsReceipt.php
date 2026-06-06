<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GoodsReceipt extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'kode_penerimaan',
        'supplier_id',
        'tanggal',
        'user_id',
        'nomor_invoice_supplier',
        'keterangan',
        'dokumen',
        'total_item',
        'total_qty',
        'status'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'total_item' => 'decimal:2',
        'total_qty' => 'decimal:2'
    ];

    /**
     * Generate kode penerimaan otomatis
     */
    public static function generateKodePenerimaan()
    {
        $year = date('Y');
        $prefix = 'GRN-' . $year . '-';
        
        $lastReceipt = self::withTrashed()
            ->whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();
            
        if ($lastReceipt) {
            $lastNumber = (int) substr($lastReceipt->kode_penerimaan, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Relasi ke supplier
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    /**
     * Relasi ke user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke items
     */
    public function items()
    {
        return $this->hasMany(GoodsReceiptItem::class, 'goods_receipt_id');
    }
}
