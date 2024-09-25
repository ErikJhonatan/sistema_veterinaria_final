<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'idDepartamento', 'id');
    }

    public function provincia()
    {
        return $this->belongsTo(Provincia::class, 'idProvincia', 'id');
    }

    public function distrito()
    {
        return $this->belongsTo(Distrito::class, 'idDistrito', 'id');
    }

    public function getMascotas()
    {
        /**
         * Get all of the ptovincias for the Departamento
         *
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        return $this->hasMany(Mascota::class, 'idCliente', 'id');
       //belongsTo(Provincia::class, 'idProvincia', 'id');
    }
}
