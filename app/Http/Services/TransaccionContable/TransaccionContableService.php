<?php
namespace App\Http\Services\TransaccionContable;

use App\Http\Services\Contabilidad\LibroDiario\LibroDiarioService;
use App\Http\Services\Contabilidad\LibroMayor\LibroMayorService;
use App\Models\Contabilidad\TransaccionContable;
use App\Models\Contabilidad\CuentaContable;
use App\Models\Contabilidad\LibroMayor;
use PHPUnit\Event\Tracer\Tracer;

class TransaccionContableService
{
    protected $libroDiarioService;
    protected $libroMayorService;

    public function __construct(
        LibroDiarioService $libroDiarioService,
        LibroMayorService $libroMayorService
    )
    {
        $this->libroDiarioService = $libroDiarioService;
        $this->libroMayorService = $libroMayorService;
    }

    public function buscarCuentaPorCodigo($codigo)
    {
        return CuentaContable::where('codigo', $codigo)->first();
    }

    public function buscarTransaccion($id)
    {
        return TransaccionContable::find($id);
    }

    public function crearTransaccionContable($data)
    {
        $cuentaDebito = CuentaContable::find($data['cuenta_debito_id']);
        $cuentaCredito = CuentaContable::find($data['cuenta_credito_id']);

        if (!$cuentaDebito || !$cuentaCredito) {
            return response (['message' => 'Cuenta contable no encontrada'], 404);
        }

        $transaccionContable = TransaccionContable::create($data);
        // libro diario
        $registroCuentaDebitoLibroDiario = $this->libroDiarioService->registrarLibroDiario(
            $data['fecha'],
            $data['monto'],
            0,
            $data['concepto'],
            $data['cuenta_debito_id'],
            $transaccionContable->id
        );

        $registroCuentaCreditoLibroDiario = $this->libroDiarioService->registrarLibroDiario(
            $data['fecha'],
            0,
            $data['monto'],
            $data['concepto'],
            $data['cuenta_credito_id'],
            $transaccionContable->id
        );

        // libro mayor
        $registroCuentaDebitoLibroMayor = $this->libroMayorService->registrarLibroMayor(
            $data['fecha'],
            $data['monto'],
            0,
            $data['monto'],
            0,
            $data['cuenta_debito_id'],
            $transaccionContable->id,
            $registroCuentaDebitoLibroDiario->id
        );

        $registroCuentaCreditoLibroMayor = $this->libroMayorService->registrarLibroMayor(
            $data['fecha'],
            0,
            $data['monto'],
            0,
            $data['monto'],
            $data['cuenta_credito_id'],
            $transaccionContable->id,
            $registroCuentaCreditoLibroDiario->id
        );
        return $transaccionContable;
    }

    public function actualizarTransaccionContable($transaction, $data)
    {
        $transaction->update($data);
        // actualizar libro diario
        // actualizar cuenta debito
        $actualizacionCuentaDebitoLibroDiario = $this->libroDiarioService->actualizarLibroDiario(
            $data['fecha'],
            $data['monto'],
            0,
            $data['concepto'],
            $transaction->cuenta_debito_id,
            $transaction->id
        );
        // actualizar cuenta credito
        $actualizacionCuentaCreditoLibroDiario = $this->libroDiarioService->actualizarLibroDiario(
            $data['fecha'],
            0,
            $data['monto'],
            $data['concepto'],
            $transaction->cuenta_credito_id,
            $transaction->id
        );

        // actualizar libro mayor
        // actualizar cuenta debito
        $actualizacionCuentaDebitoLibroMayor = $this->libroMayorService->actualizarLibroMayor(
            $data['fecha'],
            $data['monto'],
            0,
            $data['monto'],
            0,
            $transaction->cuenta_debito_id,
            $transaction->id,
            $actualizacionCuentaDebitoLibroDiario->id
        );

        // actualizar cuenta credito
        $actualizacionCuentaCreditoLibroMayor = $this->libroMayorService->actualizarLibroMayor(
            $data['fecha'],
            0,
            $data['monto'],
            0,
            $data['monto'],
            $transaction->cuenta_credito_id,
            $transaction->id,
            $actualizacionCuentaCreditoLibroDiario->id
        );
        return response(['data' => $transaction, 'message' => 'Transaccion contable actualizada'], 200);
    }

    public function transaccionContableNoEncontrada()
    {
        return response(['message' => 'Transaccion no encontrada'], 404);
    }

    public function eliminarTransaccionContable($transaccionContable)
    {
        $transaccionContable->delete();
    }

    public function obtenerTransaccionContable($id)
    {
        return TransaccionContable::find($id);
    }

     public function obtenerSaldoCaja($year)
    {
        $cuenta = $this->buscarCuentaPorCodigo(CuentaContable::CAJA);
        $saldoCaja = LibroMayor::where('cuenta_contable_id', $cuenta->id)
            ->whereYear('fecha', $year)
            ->sum('saldo_deudor') - LibroMayor::where('cuenta_contable_id', $cuenta->id)
            ->whereYear('fecha', $year)
            ->sum('saldo_acreedor');
        return $saldoCaja;
    }

    public function obtenerSaldoBanco($year)
    {
        $cuenta = $this->buscarCuentaPorCodigo(CuentaContable::BANCOS);
        $saldoBanco = LibroMayor::where('cuenta_contable_id', $cuenta->id)
            ->whereYear('fecha', $year)
            ->sum('saldo_deudor') - LibroMayor::where('cuenta_contable_id', $cuenta->id)
            ->whereYear('fecha', $year)
            ->sum('saldo_acreedor');
        return $saldoBanco;
    }

    public function obtenerTransaccionesContables($tipo, $year)
    {
       switch ($tipo) {
            case 'capital':
                return TransaccionContable::where('tipo_transaccion', 'capital')->whereYear('fecha', $year)->get();
                // ingreso_venta, ingreso_servicio
            case 'ingreso':
               return TransaccionContable::where('tipo_transaccion', 'ingreso_venta')->orWhere('tipo_transaccion', 'ingreso_servicio')->whereYear('fecha', $year)->get();
            case 'gasto':
               return TransaccionContable::where('tipo_transaccion', 'gasto_personal')->orWhere('tipo_transaccion', 'gasto_servicio')->orWhere('tipo_transaccion', 'gasto_impuesto')->whereYear('fecha', $year)->get();
            case 'compra':
               return TransaccionContable::where('tipo_transaccion', 'compra')->whereYear('fecha', $year)->get();
            case 'equipo':
               return TransaccionContable::where('tipo_transaccion', 'equipo')->whereYear('fecha', $year)->get();
            default:
               return TransaccionContable::whereYear('fecha', $year)->get();
       }
    }
}
