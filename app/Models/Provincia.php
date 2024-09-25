<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    protected $table = 'provincias';

    public function distrito()
    {
        return $this->belongsTo(Distrito::class, 'idDistrito', 'id');
    }
    public function getDistritos()
    {
        /**
         * Get all of the ptovincias for the Departamento
         *
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        return $this->hasMany(Distrito::class, 'idProvincia', 'id');
       //belongsTo(Provincia::class, 'idProvincia', 'id');
    }
}
