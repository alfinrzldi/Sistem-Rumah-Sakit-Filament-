<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class obat extends Model
{
    use HasFactory;

    protected $table = 'obat';

    protected $primaryKey = 'kode_obat'; // Set primary key

    public $incrementing = false;
    
    protected $keyType = 'string'; 

    protected $fillable = ['nama', 'harga','kode_obat'];

}
