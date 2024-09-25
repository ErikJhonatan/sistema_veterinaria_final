<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermisoRol extends Model
{
    use HasFactory;

    protected $table = "permisos_roles";

    protected $guarded = [];

    public $timestamps = false;

    public function permiso(){
        return $this->belongsTo(Permiso::class, "permiso_id");
    }
}
