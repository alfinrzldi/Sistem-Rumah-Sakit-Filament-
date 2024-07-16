<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Diagnosa extends Model
{
    use HasFactory;

    protected $table = 'diagnosa';
    protected $primaryKey = 'rekam_medis';
    public $incrementing = false;
    protected $keyType = 'string'; 
    protected $fillable = ['rekam_medis','dokter_id', 'pasien_id', 'kamar_id', 'harga'];

    public function dokter(): BelongsTo
    {
        return $this->belongsTo(Dokter::class, 'dokter_id', 'NIPK');
    }

    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class, 'pasien_id', 'NIK');
    }

    public function kamar(): BelongsTo
    {
        return $this->belongsTo(Kamar::class, 'kamar_id', 'no_kamar');
    }

    public function obats(): BelongsToMany
    {
        return $this->belongsToMany(Obat::class, 'diagnosa_obat', 'rekam_medis', 'kode_obat')
            ->using(DiagnosaObat::class)
          ;
    }
}
