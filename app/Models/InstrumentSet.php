<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstrumentSet extends Model
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
        'description',
        'jumlah',
        'jumlah_steril',
        'jumlah_kotor',
        'jumlah_proses_cssd',
        'qr_code',
        'status',
    ];

    public function assets()
    {
        return $this->belongsToMany(Asset::class);
    }

    public function scanActivities()
    {
        return $this->morphMany(ScanActivity::class, 'scannable');
    }
}
