<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servicio extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function lineas()
    {
        return $this->belongsTo(Linea::class, 'idLinea', 'id');
    }

    public function categorias()
    {
        return $this->belongsTo(Categoria::class, 'idCategoria', 'id');
    }

    public function subCategorias()
    {
        return $this->belongsTo(SubCategoria::class, 'idSubCategoria', 'id')->withDefault([
            'SubCategoria' => '',
        ]);
    }



}
