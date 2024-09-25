<?php

namespace App\Models\Contabilidad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuentaContable extends Model
{
    use HasFactory;
    const CAPITAL = 501;
    CONST CAJA = 101;
    CONST BANCOS = 1061;
    const MERCADERIA_MANUFACTURADA = 20111;
    const VENTA_MERCADERIA_MANUFACTURADA = 7011;
    const SERVICIOS = 7041;
    const CUENTAS_GASTOS_SERVICIOS = [
        'luz' => 6361,
        'agua' => 6363,
        'internet' => 6365,
        'telefono' => 6364,
        'alquiler' => 6351,
        'maquinaria' => 6353,
        'equipo' => 6356

    ];

    const CUENTAS_GASTOS_PERSONAL = [
        'sueldos' => 621
    ];

    const IMPUESTOS = [
        'igv' => 6411,
    ];

    const MAQUINARIAS_EQUIPOS_ADQ = 33311;
    const DEPRECIACION_MAQUINARIAS_EQUIPOS = 6814;
    const REEVALUACION_MAQUINARIAS_EQUIPOS = 33313;

    public function subCuentas()
    {
        return $this->hasMany(CuentaContable::class, 'cuenta_contable_id');
    }

    public function parent()
    {
        return $this->belongsTo(CuentaContable::class, 'cuenta_contable_id');
    }
}
