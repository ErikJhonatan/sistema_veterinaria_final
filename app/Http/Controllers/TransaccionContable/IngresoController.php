<?php

namespace App\Http\Controllers\TransaccionContable;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Contabilidad\IngresoStoreRequest;
use App\Models\Contabilidad\CuentaContable;
use App\Http\Services\TransaccionContable\TransaccionContableService;
use App\Http\Requests\Contabilidad\UpdateTransactionRequest;

class IngresoController extends Controller
{

    protected $transaccionContableService;

    public function __construct(TransaccionContableService $transaccionContableService)
    {
        $this->transaccionContableService = $transaccionContableService;
    }

    public function index(Request $request)
    {
        $anio = $request->input('anio', date('Y'));
        $transacciones = $this->transaccionContableService->obtenerTransaccionesContables('ingreso', $anio);
        return view('contabilidad.ingresos', ['transacciones' => $transacciones]);
    }

    public function store(IngresoStoreRequest $request)
    {
        $dataValitated = $request->validated();
        $dataValitated['metodo_pago'] = $dataValitated['forma_pago'];
        $dataValitated['descripcion'] = $dataValitated['concepto'];
        if ('efectivo' == $dataValitated['forma_pago']) {
            $dataValitated['cuenta_debito_id'] = $this->transaccionContableService->buscarCuentaPorCodigo(
                CuentaContable::CAJA
            )->id;
        } else if ('transferencia' == $dataValitated['forma_pago']) {
            $dataValitated['cuenta_debito_id'] = $this->transaccionContableService->buscarCuentaPorCodigo(
                CuentaContable::BANCOS
            )->id;
        }

        if ('ingreso_venta' == $dataValitated['tipo_transaccion']) {
            $dataValitated['cuenta_credito_id'] = $this->transaccionContableService->buscarCuentaPorCodigo(
                CuentaContable::VENTA_MERCADERIA_MANUFACTURADA
            )->id;
        } else if ('ingreso_servicio' == $dataValitated['tipo_transaccion']) {
            $dataValitated['cuenta_credito_id'] = $this->transaccionContableService->buscarCuentaPorCodigo(
                CuentaContable::SERVICIOS
            )->id;
        }
        
        $this->transaccionContableService->crearTransaccionContable($dataValitated);
        return redirect()->route('ingresos.index')->with('msg', 'Ingreso registrado correctamente.');
    }

    public function show($id)
    {
        $transaccionContable = $this->transaccionContableService->obtenerTransaccionContable($id);

        if (!$transaccionContable) {
            return $this->transaccionContableService->transaccionContableNoEncontrada();
        }

        return $transaccionContable;
    }

    public function update(UpdateTransactionRequest $request)
    {
        $transaccion = $this->transaccionContableService->buscarTransaccion($request->input('idIngreso'));

        if (!$transaccion) {
            return $this->transaccionContableService->transaccionContableNoEncontrada();
        }

        $dataValitated = $request->validated();
        $dataValitated['descripcion'] = $dataValitated['concepto'];
        $this->transaccionContableService->actualizarTransaccionContable($transaccion, $dataValitated);
        return redirect()->route('ingresos.index')->with('msg', 'Ingreso actualizado correctamente.');
    }

    public function destroy($id)
    {
        $transaccion = $this->transaccionContableService->buscarTransaccion($id);
        if (!$transaccion) {
            return $this->transaccionContableService->transaccionContableNoEncontrada();
        }
        $this->transaccionContableService->eliminarTransaccionContable($transaccion);
        return redirect()->back()->with('msg', 'Ingreso eliminado correctamente.');
    }
}
