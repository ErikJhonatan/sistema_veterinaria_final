<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentaItem extends Model
{
    use HasFactory;

    protected $table = 'ventas_items';
    protected $guarded = [];

    public function venta()
    {
        return $this->belongsTo(Venta::class, 'id', 'venta_id');
    }

    public function producto() {
        return $this->hasOne(Producto::class, 'id', 'producto_id');
    }

    public function servicio() {
        return $this->hasOne(Servicio::class, 'id', 'servicio_id');
    }

    public function mascota() {
        return $this->hasOne(Mascota::class, 'id', 'mascota_id');
    }
}
