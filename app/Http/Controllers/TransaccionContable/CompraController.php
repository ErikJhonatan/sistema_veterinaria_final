<?php

namespace App\Http\Controllers\TransaccionContable;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contabilidad\CuentaContable;
use App\Http\Services\TransaccionContable\TransaccionContableService;
use App\Http\Services\Contabilidad\LibroMayor\LibroMayorService;
use App\Http\Requests\Contabilidad\UpdateTransactionRequest;

use App\Http\Requests\Contabilidad\CompraStoreRequest;

class CompraController extends Controller
{
    protected $transaccionContableService;
    protected $libroMayorService;

    public function __construct(
        TransaccionContableService $transaccionContableService,
        LibroMayorService $libroMayorService
    )
    {
        $this->transaccionContableService = $transaccionContableService;
        $this->libroMayorService = $libroMayorService;
    }

    public function index()
    {
        $transacciones = $this->transaccionContableService->obtenerTransaccionesContables('compra', date('Y'));
        return view('contabilidad.compras', ['transacciones' => $transacciones]);
    }

    public function store(CompraStoreRequest $request)
    {
        $dataValidated = $request->validated();
        $dataValidated['tipo_transaccion'] = 'compra';
        $dataValidated['metodo_pago'] = $dataValidated['forma_pago'];
        $dataValidated['descripcion'] = $dataValidated['concepto'];

        $dataValidated['cuenta_debito_id'] = $this->transaccionContableService->buscarCuentaPorCodigo(
            CuentaContable::MERCADERIA_MANUFACTURADA
        )->id;

        if('efectivo' == $dataValidated['forma_pago'])
        {
            $dataValidated['cuenta_credito_id'] = $this->transaccionContableService->buscarCuentaPorCodigo(
                CuentaContable::CAJA
            )->id;
            $saldo = $this->transaccionContableService->obtenerSaldoCaja($dataValidated['anio']);
        }

        else if('transferencia' == $dataValidated['forma_pago'])
        {
            $dataValidated['cuenta_credito_id'] = $this->transaccionContableService->buscarCuentaPorCodigo(
                CuentaContable::BANCOS
            )->id;
            $saldo = $this->transaccionContableService->obtenerSaldoBanco($dataValidated['anio']);
        }

        if($saldo < $dataValidated['monto'])
        {
            return redirect()->route('compras.index')->with('error', 'Saldo insuficiente.');
        }

        $this->transaccionContableService->crearTransaccionContable($dataValidated);
        return redirect()->route('compras.index')->with('msg', 'Compra registrada correctamente.');
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
        $transaccion = $this->transaccionContableService->buscarTransaccion($request->input('idCompra'));

        if (!$transaccion) {
            return $this->transaccionContableService->transaccionContableNoEncontrada();
        }
        $dataValidated = $request->validated();
        $dataValidated['descripcion'] = $dataValidated['concepto'];

        $metodo_pago = $transaccion->metodo_pago;

        if('efectivo' == $metodo_pago)
        {
            $saldo = $this->transaccionContableService->obtenerSaldoCaja($dataValidated['anio']);
        }
        else if('transferencia' == $metodo_pago)
        {
            $saldo = $this->transaccionContableService->obtenerSaldoBanco($dataValidated['anio']);
        }

        $saldo += $transaccion->monto;

        if(isset($dataValidated['monto']) && $saldo < $dataValidated['monto'])
        {
            return redirect()->route('compras.index')->with('error', 'Saldo insuficiente.');
        }
        $this->transaccionContableService->actualizarTransaccionContable($transaccion, $dataValidated);
        return redirect()->route('compras.index')->with('msg', 'Compra actualizada correctamente.');
    }

    public function destroy($id)
    {
        $transaccion = $this->transaccionContableService->buscarTransaccion($id);

        if (!$transaccion) {
            return $this->transaccionContableService->transaccionContableNoEncontrada();
        }

        $this->transaccionContableService->eliminarTransaccionContable($transaccion);

        return redirect()->back()->with('msg', 'Compra eliminada correctamente.');
    }
}
