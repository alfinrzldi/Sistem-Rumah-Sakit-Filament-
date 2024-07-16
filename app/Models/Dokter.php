<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dokter extends Model
{
    use HasFactory;

    // The table associated with the model.
    protected $table = 'dokter';

    protected $primaryKey = 'NIPK';

    public $incrementing = false;
    // The attributes that are mass assignable.
    protected $fillable = [
        'NIPK',
        'nama',
        'jenis_kelamin',
        'telepon',
        'spesialis',
    ];
}
