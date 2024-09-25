<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoMovimiento extends Model
{
    use HasFactory;

    protected $table = 'tipos_movimientos';

    public const VENTA = 1;
    public const COMPRA = 2;
    public const ANULACION = 3;
    public const DIRECTO = 4;
    public const CLIENTE_EDICION =  5;
    public const CLIENTE_CREACION =  6;
    public const SERVICIO_CREACION =  7;
    public const SERVICIO_EDICION =  8;
    public const PRODUCTO_EDICION =  9;
    public const PRODUCTO_CREACION =  10;
    public const MASCOTA_CREACION =  11;
    public const MASCOTA_EDICION =  12;
    public const CLIENTE_ELIMINACION =  13;
    public const SERVICIO_ELIMINACION =  14;
    public const PRODUCTO_ELIMINACION =  15;
    public const MASCOTA_ELIMINACION =  16;

    const VENTAS = "ventas";
    const CLIENTE = "cliente";
    const SERVICIO = "servicio";
    const PRODUCTO = "producto";
    const MASCOTA = "mascota";
}
