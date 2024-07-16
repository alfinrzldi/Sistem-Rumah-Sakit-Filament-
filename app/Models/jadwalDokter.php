<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JadwalDokter extends Model
{
    use HasFactory;

    protected $table = 'jadwal_dokter'; // Corrected table name

    protected $fillable = ['dokter_id', 'jam', 'hari'];

    public function dokter(): BelongsTo
    {
        return $this->belongsTo(Dokter::class, 'dokter_id', 'NIPK');
    }
}
