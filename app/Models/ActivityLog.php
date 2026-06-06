<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'log_type',
        'user_id',
        'model_type',
        'model_id',
        'pesan',
        'data_lama',
        'data_baru'
    ];

    protected $casts = [
        'data_lama' => 'array',
        'data_baru' => 'array'
    ];

    /**
     * Relasi ke user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Scope filter berdasarkan log type
     */
    public function scopeFilterByType($query, $logType)
    {
        if ($logType) {
            $query->where('log_type', $logType);
        }
        return $query;
    }

    /**
     * Scope filter berdasarkan tanggal
     */
    public function scopeFilterByDate($query, $startDate, $endDate)
    {
        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }
        return $query;
    }
}
