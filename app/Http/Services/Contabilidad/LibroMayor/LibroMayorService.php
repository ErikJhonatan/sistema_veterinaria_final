<?php
namespace App\Http\Services\Contabilidad\LibroMayor;
use App\Models\Contabilidad\CuentaContable;
use App\Models\Contabilidad\LibroMayor;
use App\Http\Services\TransaccionContable\TransaccionContableService;

class LibroMayorService
{
    // protected $transaccionContableService;

    // public function __construct(
    //     TransaccionContableService $transaccionContableService
    // )
    // {
    //     $this->transaccionContableService = $transaccionContableService;
    // }

    public function registrarLibroMayor(
        $fecha,
        $debe,
        $haber,
        $saldo_deudor,
        $saldo_acreedor,
        $cuenta_contable_id,
        $transaccion_contable_id,
        $libro_diario_id
    )
    {
        LibroMayor::create([
            'fecha' => $fecha,
            'debe' => $debe,
            'haber' => $haber,
            'saldo_deudor' => $saldo_deudor,
            'saldo_acreedor' => $saldo_acreedor,
            'cuenta_contable_id' => $cuenta_contable_id,
            'transaccion_contable_id' => $transaccion_contable_id,
            'libro_diario_id' => $libro_diario_id
        ]);
    }
    public function actualizarLibroMayor(
        $fecha,
        $debe,
        $haber,
        $saldo_deudor,
        $saldo_acreedor,
        $cuenta_contable_id,
        $transaccion_contable_id,
        $libro_diario_id
    )
    {
        $libro_mayor = LibroMayor::where('cuenta_contable_id', $cuenta_contable_id)
            ->where('transaccion_contable_id', $transaccion_contable_id)
            ->where('libro_diario_id', $libro_diario_id)
            ->first();

        $libro_mayor->update([
            'fecha' => $fecha,
            'debe' => $debe,
            'haber' => $haber,
            'saldo_deudor' => $saldo_deudor,
            'saldo_acreedor' => $saldo_acreedor,
            'cuenta_contable_id' => $cuenta_contable_id,
            'transaccion_contable_id' => $transaccion_contable_id,
            'libro_diario_id' => $libro_diario_id
        ]);

        return $libro_mayor;
    }
}

