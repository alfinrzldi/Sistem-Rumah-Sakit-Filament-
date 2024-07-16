<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class petugas extends Model
{
    use HasFactory;

    // The table associated with the model.
    protected $table = 'petugas';

    // The primary key associated with the table.
    protected $primaryKey = 'NIP'; // Menggunakan 'NIP' sebagai primary key

    // Indicates if the IDs are auto-incrementing.
    public $incrementing = false;

    // The attributes that are mass assignable.
    protected $fillable = [
        'NIP',
        'nama',
        'posisi',
        'telepon',
    ];
}
