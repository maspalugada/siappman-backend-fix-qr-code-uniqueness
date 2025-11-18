<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    const STATUS_READY = 'Ready';
    const STATUS_WASHING = 'Washing';
    const STATUS_STERILIZING = 'Sterilizing';
    const STATUS_IN_USE = 'In Use';
    const STATUS_MAINTENANCE = 'Maintenance';
    const STATUS_IN_TRANSIT = 'In Transit';
    const STATUS_IN_TRANSIT_STERILE = 'In Transit (Sterile)';
    const STATUS_IN_TRANSIT_DIRTY = 'In Transit (Dirty)';
    const STATUS_IN_PROCESS = 'In Process';
    const STATUS_RETURNING = 'Returning';
    const STATUS_RETURNED = 'Returned';

    protected $fillable = [
        'name',
        'instrument_type',
        'unit',
        'unit_code',
        'destination_unit',
        'destination_unit_code',
        'jumlah',
        'jumlah_steril',
        'jumlah_kotor',
        'jumlah_proses_cssd',
        'location',
        'description',
        'qr_code',
        'qr_codes',
        'qr_images',
        'specifications',
        'status'
    ];

    protected $casts = [
        'specifications' => 'array',
        'qr_codes' => 'array',
        'qr_images' => 'array',
    ];

    public function generateQrCode()
    {
        return 'ASSET-' . strtoupper(substr(md5($this->id . $this->name), 0, 8));
    }

    public function instrumentSets()
    {
        return $this->belongsToMany(InstrumentSet::class);
    }

    public function scanActivities()
    {
        return $this->morphMany(ScanActivity::class, 'scannable');
    }

    public function qrCodes()
    {
        return $this->hasMany(QRCode::class);
    }
}
