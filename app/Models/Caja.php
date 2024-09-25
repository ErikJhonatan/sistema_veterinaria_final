<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Caja extends Model
{
    use HasFactory;

    protected $guarded = ['monto'];

    protected static function booted() {
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('created_at', 'desc');
        });
    }

    public function tipo()
    {
        return $this->hasOne(TipoMovimiento::class, 'id', 'tipo_movimiento_id');
    }

    public function medio_pago()
    {
        return $this->hasOne(FormaPago::class, 'id', 'medio_pago_id');
    }
}
