<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;

    protected $table = "roles";

    const ADMINISTRADOR = 1;
    const VENDEDOR = 2;
    const DOCTOR = 3;
    const RRHH = 4;

    public function permisos (){
        return $this->belongsToMany(Permiso::class, "permisos_roles", "rol_id", "permiso_id");
    }

}
