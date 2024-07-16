<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kamar extends Model
{
    use HasFactory;

    protected $table = 'kamar';

    protected $primaryKey = 'no_kamar';

    public $incrementing = false;

    protected $fillable = [
        'no_kamar',
        'harga',
        'status',
        'pasien_id',
    ]; 

    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class, 'pasien_id', 'NIK');
    }
}
