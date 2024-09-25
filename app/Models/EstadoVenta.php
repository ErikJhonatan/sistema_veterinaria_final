<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoVenta extends Model
{
    use HasFactory;

    protected $table = 'estados_ventas';

    public const PAGADA = 1;
    public const PENDIENTE = 2;
    public const ANULADA = 3;
}
