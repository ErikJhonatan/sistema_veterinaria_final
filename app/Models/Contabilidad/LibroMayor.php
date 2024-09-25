<?php

namespace App\Models\Contabilidad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Contabilidad\TransaccionContable;

class LibroMayor extends Model
{
    use HasFactory;
    protected $fillable = [
        'fecha',
        'transaccion_contable_id',
        'cuenta_contable_id',
        'libro_diario_id',
        'saldo_deudor',
        'saldo_acreedor',
        'debe',
        'haber'
    ];

    public function transaccion_contable()
    {
        return $this->belongsTo(TransaccionContable::class, 'transaccion_contable_id');
    }
}
