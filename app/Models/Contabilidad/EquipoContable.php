<?php

namespace App\Models\Contabilidad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipoContable extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaccion_id',
        'transaccion_depreciacion_id',
        'nombre',
        'descripcion',
        'marca',
        'modelo',
        'serie',
        'precio',
        'metodo_pago',
        'color',
        'estado',
        'vida_util'
    ];
    public function transaccion()
    {
        return $this->belongsTo(TransaccionContable::class);
    }

    public function toArray()
    {
        $array = parent::toArray();
        $array['fecha'] = $this->transaccion->fecha;
        return $array;
    }
}
