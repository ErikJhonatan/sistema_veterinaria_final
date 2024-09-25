<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    use HasFactory;

    protected $table = 'almacenes';
    protected $guarded = [];

    public function tipo()
    {
        return $this->hasOne(Sede::class, 'id', 'sede_id');
    }
}
