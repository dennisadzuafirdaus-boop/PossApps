<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_supplier',
        'nama_supplier',
        'alamat',
        'telepon',
        'email',
        'kontak_person',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    /**
     * Generate kode supplier otomatis
     */
    public static function generateKodeSupplier()
    {
        $lastSupplier = self::orderBy('id', 'desc')->first();
        if ($lastSupplier) {
            $lastNumber = (int) substr($lastSupplier->kode_supplier, 3);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        return 'SUP' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Relasi ke goods receipts
     */
    public function goodsReceipts()
    {
        return $this->hasMany(GoodsReceipt::class, 'supplier_id');
    }
}
