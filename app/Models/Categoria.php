<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias';

    public function subCategoria()
    {
        return $this->belongsTo(SubCategoria::class, 'idSubCategoria', 'id');
    }

    public function linea()
    {
        return $this->belongsTo(Linea::class, 'IdLinea', 'id');
    }

    public function getSubCategorias()
    {
        return $this->hasMany(SubCategoria::class, 'idCategoria', 'id');
    }
}
