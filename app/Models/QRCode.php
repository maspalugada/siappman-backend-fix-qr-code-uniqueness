<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QRCode extends Model
{
    use HasFactory;

    const STATUS_ACTIVE = 'active';
    const STATUS_SCANNED = 'scanned';
    const STATUS_INACTIVE = 'inactive';

    protected $fillable = [
        'asset_id',
        'qr_code',
        'qr_image',
        'sequence_number',
        'status',
        'scanned_at',
    ];

    protected $casts = [
        'scanned_at' => 'datetime',
        'sequence_number' => 'integer',
    ];

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public function scanActivities(): HasMany
    {
        return $this->hasMany(ScanActivity::class, 'qr_code', 'qr_code');
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeScanned($query)
    {
        return $query->where('status', self::STATUS_SCANNED);
    }

    public function markAsScanned()
    {
        $this->update([
            'status' => self::STATUS_SCANNED,
            'scanned_at' => now(),
        ]);
    }
}
