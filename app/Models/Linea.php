<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Linea extends Model
{
    protected $table = 'lineas';

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'idCategoria', 'id');
    }
    public function getCategorias()
    {
        return $this->hasMany(Categoria::class, 'idLinea', 'id');
    }
}
