<?php

namespace App\Http\Controllers\TransaccionContable;

use App\Http\Controllers\Controller;
use App\Models\Contabilidad\CuentaContable;
use Illuminate\Http\Request;
use App\Http\Requests\Contabilidad\CapitalStoreRequest;
use App\Http\Requests\Contabilidad\UpdateTransactionRequest;
use App\Http\Services\TransaccionContable\TransaccionContableService;

class CapitalController extends Controller
{
    protected $transaccionContableService;

    public function __construct(TransaccionContableService $transaccionContableService)
    {
        $this->transaccionContableService = $transaccionContableService;
    }

    public function index()
    {
        $transacciones = $this->transaccionContableService->obtenerTransaccionesContables('capital', date('Y'));
        return view('contabilidad.capital', ['transacciones' => $transacciones]);
    }

    public function store(CapitalStoreRequest $request)
    {
        $dataValitated = $request->validated();
        $dataValitated['tipo_transaccion'] = 'capital';
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

        $dataValitated['cuenta_credito_id'] = $this->transaccionContableService->buscarCuentaPorCodigo(
            CuentaContable::CAPITAL
        )->id;

        $this->transaccionContableService->crearTransaccionContable($dataValitated);
        return redirect()->route('capital.index')->with('msg', 'Capital registrado correctamente.');
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
        $transaccion = $this->transaccionContableService->buscarTransaccion($request->input('idCapital'));

        if (!$transaccion) {
            return $this->transaccionContableService->transaccionContableNoEncontrada();
        }

        $dataValitated = $request->validated();
        $dataValitated['descripcion'] = $dataValitated['concepto'];
        $this->transaccionContableService->actualizarTransaccionContable($transaccion, $dataValitated);
        return redirect()->route('capital.index')->with('msg', 'Capital actualizado correctamente.');
    }

    public function destroy($id)
    {
        $transaccion = $this->transaccionContableService->buscarTransaccion($id);

        if (!$transaccion) {
            return $this->transaccionContableService->transaccionContableNoEncontrada();
        }
        $this->transaccionContableService->eliminarTransaccionContable($transaccion);
        return redirect()->back()->with('msg', 'Capital eliminado correctamente.');
    }
}
