<?php

namespace App\Models\Contabilidad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibroDiario extends Model
{
    use HasFactory;
    protected $fillable = [
        'fecha',
        'transaccion_contable_id',
        'cuenta_contable_id',
        'concepto',
        'debe',
        'haber'
    ];
}
