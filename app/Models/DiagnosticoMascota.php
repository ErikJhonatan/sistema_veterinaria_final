<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiagnosticoMascota extends Model
{
    use HasFactory;

    protected $table = "diagnosticos_mascotas";

    protected $fillable = [
        "mascota_id",
        "diagnostico_id",
        "historial_clinica_id",
        "estado"
    ];

    public function diagnostico(){
        return $this->belongsTo(Diagnostico::class, 'diagnostico_id');
    }
}
