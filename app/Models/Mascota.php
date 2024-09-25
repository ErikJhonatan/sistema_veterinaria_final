<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mascota extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function especie()
    {
        return $this->belongsTo(Especie::class, 'idEspecie', 'id');
    }

    public function raza()
    {
        return $this->belongsTo(Raza::class, 'idRaza', 'id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'idCliente', 'id');
    }

}
