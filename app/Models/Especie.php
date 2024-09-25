<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Especie extends Model
{
    protected $table = 'especies';
    
    public function raza()
    {
        return $this->belongsTo(Raza::class, 'idRaza', 'id');
    }

    public function getRazas()
    {
        /**
         * Get all of the ptovincias for the Departamento
         *
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        return $this->hasMany(Raza::class, 'idEspecie', 'id');
       //belongsTo(Provincia::class, 'idProvincia', 'id');
    }
}
