<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HistoriaClinicaAdjunto extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'historia_clinica_adjuntos';

    protected $fillable = [
        'historia_clinica_id',
        'patch',
        'deleted_at'
    ];
}
