<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TratamientoMascota extends Model
{
    use HasFactory;

    protected $table = 'tratamientos_mascotas';

    public function producto(){
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}
