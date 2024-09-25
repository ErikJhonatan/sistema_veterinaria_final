<?php
namespace App\Http\Services\Contabilidad;
use App\Models\Contabilidad\LibroDiario;
use App\Models\Contabilidad\LibroMayor;
use App\Http\Services\Contabilidad\LibroDiario\LibroDiarioService;
use App\Http\Services\Contabilidad\LibroMayor\LibroMayorService;
class ContabilidadService
{

    protected $libroDiarioService;
    protected $libroMayorService;

    public function __construct(
        LibroDiarioService $libroDiarioService,
        LibroMayorService $libroMayorService
    ){
        $this->libroDiarioService = $libroDiarioService;
        $this->libroMayorService = $libroMayorService;
    }

    public function registrarDataCuentaDebito(
        $fecha,
        $monto,
        $concepto,
        $cuenta_contable_id,
        $transaccion_contable_id
    ){
       $libroDiarioRegistro = $this->libroDiarioService->registrarLibroDiario(
            $fecha,
            $monto,
            0,
            $concepto,
            $cuenta_contable_id,
            $transaccion_contable_id
        );

        $this->libroMayorService->registrarLibroMayor(
            $fecha,
            $monto,
            0,
            $monto,
            0,
            $cuenta_contable_id,
            $transaccion_contable_id,
            $libroDiarioRegistro->id
        );
        return $libroDiarioRegistro;
    }

    public function registrarDataCuentaCredito(
        $fecha,
        $monto,
        $concepto,
        $cuenta_contable_id,
        $transaccion_contable_id
    ){
        // Registrar en el libro diario y libro mayor
        $libroDiarioRegistro = $this->libroDiarioService->registrarLibroDiario(
            $fecha,
            0,
            $monto,
            $concepto,
            $cuenta_contable_id,
            $transaccion_contable_id
        );

        $this->libroMayorService->registrarLibroMayor(
            $fecha,
            0,
            $monto,
            0,
            $monto,
            $cuenta_contable_id,
            $transaccion_contable_id,
            $libroDiarioRegistro->id
        );
        return $libroDiarioRegistro;
    }
}
