<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamenAuxiliarMascota extends Model
{
    use HasFactory;

    protected $table = "examenes_auxiliares_mascotas";

    protected $fillable = [
        "mascota_id",
        "examen_auxiliar_id",
        "historial_clinica_id",
        "indicaciones",
        "updated_at",
        "created_at"
      
    ];

    public function examenAuxiliar(){
        return $this->belongsTo(ExamenAuxiliar::class, 'examen_auxiliar_id');
    }
}
