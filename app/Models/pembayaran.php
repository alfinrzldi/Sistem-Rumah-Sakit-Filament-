<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';

    protected $primaryKey = 'id_pembayaran'; // Set the primary key

    public $incrementing = true; // Ensure the primary key is auto-incrementing

    protected $fillable = [
        'diagnosa_id',
        'pasien_id',
        'kamar_id',
        'tanggal',
        'obat_id',
        'jumlah_obat',
        'harga', // Add harga field
        'jumlah', // Add jumlah field
    ];

    public function diagnosa(): BelongsTo
{
    return $this->belongsTo(Diagnosa::class, 'diagnosa_id', 'rekam_medis');
}


    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class, 'pasien_id', 'NIK');
    }

    public function kamar(): BelongsTo
    {
        return $this->belongsTo(Kamar::class, 'kamar_id', 'no_kamar');
    }

    public function obat(): HasMany
    {
        return $this->hasMany(Obat::class, 'obat_id', 'kode_obat');
    }

    public function getTotalAttribute()
    {
        return $this->harga * $this->jumlah;
    }
}
