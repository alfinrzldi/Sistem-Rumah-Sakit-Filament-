<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class pasien extends Model
{
    use HasFactory;

    protected $table = 'pasien';

    protected $primaryKey = 'NIK';

    public $incrementing = false;

    protected $fillable = ['NIK', 'nama', 'jenis_kelamin', 'telepon', 'status'];
    // Mengatur primary key menjadi NIK

    public function kamar()
    {
        return $this->belongsTo(Kamar::class, 'kamar_id', 'no_kamar');
    }
}
