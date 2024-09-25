<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $table = 'departamentos';

    public function provincia()
    {
        return $this->belongsTo(Provincia::class, 'idProvincia', 'id');
    }

    public function getProvincias()
    {
        /**
         * Get all of the ptovincias for the Departamento
         *
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        return $this->hasMany(Provincia::class, 'idDepartamento', 'id');
       //belongsTo(Provincia::class, 'idProvincia', 'id');
    }
}
