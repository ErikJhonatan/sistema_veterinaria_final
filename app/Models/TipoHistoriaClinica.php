<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoHistoriaClinica extends Model
{
    use HasFactory;

    protected $table = 'tipos_historias_clinicas';

    const CONSULTA = 1;
    const CONTROL = 2;
    const CIRUGIA = 3;
    const VACUNA = 4;
    const ANTIPARASITARIO = 5;
    const ANTIPULGAS = 6;
    const TRATAMIENTO = 7;

}
