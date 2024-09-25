<?php

namespace App\Http\Controllers\TransaccionContable;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Contabilidad\GastoStoreRequest;
use App\Models\Contabilidad\CuentaContable;
use App\Http\Services\TransaccionContable\TransaccionContableService;
use App\Http\Services\Contabilidad\LibroMayor\LibroMayorService;
use App\Http\Requests\Contabilidad\UpdateTransactionRequest;


class GastoController extends Controller
{
    protected $transaccionContableService;
    protected $libroMayorService;

    public function __construct(
        TransaccionContableService $transaccionContableService,
        LibroMayorService $libroMayorService
    ) {
        $this->transaccionContableService = $transaccionContableService;
        $this->libroMayorService = $libroMayorService;
    }

    public function index(Request $request)
    {        
        $transacciones = $this->transaccionContableService->obtenerTransaccionesContables('gasto', date('Y'));
        return view('contabilidad.gastos', ['transacciones' => $transacciones]);
    }

    public function store(GastoStoreRequest $request)
    {
        $dataValitated = $request->validated();
        $dataValitated['metodo_pago'] = $dataValitated['forma_pago'];
        $dataValitated['descripcion'] = $dataValitated['concepto'];

        if ('gasto_servicio' == $dataValitated['tipo_transaccion']) {
            $dataValitated['cuenta_debito_id'] = $this->transaccionContableService->buscarCuentaPorCodigo(
                CuentaContable::CUENTAS_GASTOS_SERVICIOS[$dataValitated['servicio']]
            )->id;
        } else if ('gasto_personal' == $dataValitated['tipo_transaccion']) {
            $dataValitated['cuenta_debito_id'] = $this->transaccionContableService->buscarCuentaPorCodigo(
                CuentaContable::CUENTAS_GASTOS_PERSONAL['sueldos']
            )->id;
        } else if('gasto_impuesto' == $dataValitated['tipo_transaccion']) {
            $dataValitated['cuenta_debito_id'] = $this->transaccionContableService->buscarCuentaPorCodigo(
                CuentaContable::IMPUESTOS['igv']
            )->id;
        }
        $saldo = 0;

        if ('efectivo' == $dataValitated['forma_pago']) {
            $dataValitated['cuenta_credito_id'] = $this->transaccionContableService->buscarCuentaPorCodigo(
                CuentaContable::CAJA
            )->id;
            $saldo = $this->transaccionContableService->obtenerSaldoCaja($dataValitated['anio']);
        } else if ('transferencia' == $dataValitated['forma_pago']) {
            $dataValitated['cuenta_credito_id'] = $this->transaccionContableService->buscarCuentaPorCodigo(
                CuentaContable::BANCOS
            )->id;
            $saldo = $this->transaccionContableService->obtenerSaldoBanco($dataValitated['anio']);
        }
        if ($saldo < $dataValitated['monto']) {
            return redirect()->route('gastos.index')->with('error', 'Saldo insuficiente.');
        }

        $this->transaccionContableService->crearTransaccionContable($dataValitated);
        return redirect()->route('gastos.index')->with('msg', 'Gasto registrado correctamente.');
    }

    public function show($id)
    {
        $transaccionContable = $this->transaccionContableService->obtenerTransaccionContable($id);

        if (!$transaccionContable) {
            return $this->transaccionContableService->transaccionContableNoEncontrada();
        }

        return $transaccionContable;
    }

    public function update(UpdateTransactionRequest $request, $id)
    {
        $transaccion = $this->transaccionContableService->buscarTransaccion($request->input('idGasto'));
        if (!$transaccion) {
            return $this->transaccionContableService->transaccionContableNoEncontrada();
        }
        $dataValitated = $request->validated();
        $dataValitated['descripcion'] = $dataValitated['concepto'];

        $metodo_pago = $transaccion->metodo_pago;

        if ('efectivo' == $metodo_pago) {
            $dataValitated['cuenta_credito_id'] = $this->transaccionContableService->buscarCuentaPorCodigo(
                CuentaContable::CAJA
            )->id;
            $saldo = $this->transaccionContableService->obtenerSaldoCaja($dataValitated['anio']);
        } else if ('transferencia' == $metodo_pago) {
            $dataValitated['cuenta_credito_id'] = $this->transaccionContableService->buscarCuentaPorCodigo(
                CuentaContable::BANCOS
            )->id;
            $saldo = $this->transaccionContableService->obtenerSaldoBanco($dataValitated['anio']);
        }
        $saldo += $transaccion->monto;
        if ($saldo < $dataValitated['monto']) {
            return redirect()->route('gastos.index')->with('error', 'Saldo insuficiente.');
        }

        $this->transaccionContableService->actualizarTransaccionContable($transaccion, $dataValitated);
        return redirect()->route('gastos.index')->with('msg', 'Gasto actualizado correctamente.');
    }

    public function destroy($id)
    {
        $transaccion = $this->transaccionContableService->buscarTransaccion($id);
        if (!$transaccion) {
            return $this->transaccionContableService->transaccionContableNoEncontrada();
        }
        $this->transaccionContableService->eliminarTransaccionContable($transaccion);
        return redirect()->back()->with('msg', 'Gasto eliminado correctamente.');
    }
}
