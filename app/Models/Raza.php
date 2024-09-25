<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Raza extends Model
{
    protected $table = 'razas';

    public function especie()
    {
        return $this->belongsTo(Especie::class, 'idEspecie', 'id');
    }
}
