<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function linea(): BelongsTo
    {
        return $this->belongsTo(Linea::class, 'idNivel', 'id');
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'idCategoria', 'id');
    }

    public function subCategoria(): BelongsTo
    {
        return $this->belongsTo(SubCategoria::class, 'idSubCategoria', 'id');
    }

    public function unidadMedida(): BelongsTo
    {
        return $this->belongsTo(UnidadMedida::class, 'idUnidadMedida', 'id');
    }

    public function presentacion(): BelongsTo
    {
        return $this->belongsTo(Presentacion::class, 'idPresentacion', 'id');
    }

    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(Proveedor::class, 'idProveedor', 'id');
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(ProductoStock::class, 'producto_id', 'id');
    }
}
