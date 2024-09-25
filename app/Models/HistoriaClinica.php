<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriaClinica extends Model
{
    use HasFactory;
    
    protected $table = "historias_clinicas";

    public function tipoHistoriaClinica(){
        return $this->belongsTo(TipoHistoriaClinica::class, 'tipo_historia_clinica_id');
    }

    public function tratamientoMascota(){
        return $this->hasMany(TratamientoMascota::class, 'historia_clinica_id');
    }

    public function examenAuxiliarMascota(){
        return $this->hasMany(ExamenAuxiliarMascota::class, 'historia_clinica_id');
    }

    public function diagnosticoMascota(){
        return $this->hasMany(DiagnosticoMascota::class, 'historia_clinica_id');
    }

    public function vacunas()
    {
        return $this->hasMany(TratamientoMascota::class)
                    ->where('tipo_historia_clinica_id', TipoHistoriaClinica::VACUNA);
    }

    public function antiparasitarios()
    {
        return $this->hasMany(TratamientoMascota::class)
                    ->where('tipo_historia_clinica_id', TipoHistoriaClinica::ANTIPARASITARIO);
    }

    public function antipulgas()
    {
        return $this->hasMany(TratamientoMascota::class)
                    ->where('tipo_historia_clinica_id', TipoHistoriaClinica::ANTIPULGAS);
    }
}
