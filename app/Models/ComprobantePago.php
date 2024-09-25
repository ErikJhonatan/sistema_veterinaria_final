<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComprobantePago extends Model
{
    use HasFactory;

    protected $table = 'comprobantes_pagos';

    public function medio_pago()
    {
        return $this->hasOne(FormaPago::class, 'id', 'medio_pago_id');
    }

    public function tipo_movimiento() {
        return $this->hasOne(TipoMovimiento::class, 'id', 'tipo_movimiento_id');
    }
}
