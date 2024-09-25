<?php

namespace App\Models\Contabilidad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Contabilidad\CuentaContable;

class TransaccionContable extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha',
        'tipo_transaccion',
        'tipo',
        'metodo_pago',
        'descripcion',
        'cuenta_debito_id',
        'cuenta_credito_id',
        'monto'
    ];

    public function cuenta_debito()
    {
        return $this->belongsTo(CuentaContable::class, 'cuenta_debito_id');
    }

    public function cuenta_credito()
    {
        return $this->belongsTo(CuentaContable::class, 'cuenta_credito_id');
    }
}
