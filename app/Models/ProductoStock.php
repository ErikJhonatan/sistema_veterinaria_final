<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductoStock extends Model
{
    use HasFactory;

    protected $table = 'productos_stocks';
    protected $guarded = ['accion'];

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class, 'producto_id', 'id');
    }

    public function almacen(): HasOne
    {
        return $this->hasOne(Almacen::class, 'id', 'almacen_id');
    }
}
