<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class DiagnosaObat extends Pivot
{
    public static function booted(): void
    {
        static::creating(function ($record) {
            
        });
    }
}
