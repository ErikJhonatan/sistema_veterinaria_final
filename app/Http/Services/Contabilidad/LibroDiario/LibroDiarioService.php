<?php
namespace App\Http\Services\Contabilidad\LibroDiario;
use App\Models\Contabilidad\LibroDiario;


class LibroDiarioService
{
    public function registrarLibroDiario(
        $fecha,
        $debe,
        $haber,
        $concepto,
        // Parametros para buscar el libro diario a actualizar
        $cuenta_contable_id,
        $transaccion_contable_id
    )
    {
       return LibroDiario::create([
            'fecha' => $fecha,
            'debe' => $debe,
            'haber' => $haber,
            'concepto' => $concepto,
            'cuenta_contable_id' => $cuenta_contable_id,
            'transaccion_contable_id' => $transaccion_contable_id
        ]);
    }

    public function actualizarLibroDiario(
        $fecha,
        $debe,
        $haber,
        $concepto,
        // Parametros para buscar el libro diario a actualizar
        $cuenta_contable_id,
        $transaccion_contable_id
    )
    {
        $libro_diario = LibroDiario::where('cuenta_contable_id', $cuenta_contable_id)
            ->where('transaccion_contable_id', $transaccion_contable_id)
            ->first();

        $libro_diario->update([
            'fecha' => $fecha,
            'debe' => $debe,
            'haber' => $haber,
            'concepto' => $concepto,
            'cuenta_contable_id' => $cuenta_contable_id,
            'transaccion_contable_id' => $transaccion_contable_id
        ]);

        return $libro_diario;
    }
}
