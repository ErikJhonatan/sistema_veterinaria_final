<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comprobante extends Model
{
    use HasFactory;

    public const BOLETA = 1;
    public const FACTURA = 2;
    public const NOTA_VENTA = 3;

    public function tipoComprobante()
    {
        return $this->belongsTo(TipoComprobante::class, 'tipo_id', 'id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id', 'id');
    }

    public function venta()
    {
        return $this->belongsTo(Venta::class, 'venta_id', 'id');
    }

    public function pagos()
    {
        return $this->hasMany(ComprobantePago::class, 'comprobante_id', 'id');
    }
}
