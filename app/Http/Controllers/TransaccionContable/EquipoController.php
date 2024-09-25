<?php

namespace App\Http\Controllers\TransaccionContable;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contabilidad\CuentaContable;
use App\Http\Services\TransaccionContable\TransaccionContableService;
use App\Http\Services\TransaccionContable\EquipoService;
use App\Http\Requests\Contabilidad\EquipoStoreRequest;
use App\Http\Requests\Contabilidad\EquipoUpdateRequest;

class EquipoController extends Controller
{
    protected $equipoService;
    protected $transaccionContableService;

    public function __construct(
        EquipoService $equipoService,
        TransaccionContableService $transaccionContableService
    )
    {
        $this->equipoService = $equipoService;
        $this->transaccionContableService = $transaccionContableService;
    }

    public function index()
    {
        $equipos = $this->equipoService->listarEquipos(date('Y'));
        return view('contabilidad.equipos', ['transacciones' => $equipos]);
    }

    public function store(EquipoStoreRequest $request)
    {
        $dataValidated = $request->validated();

        $cuentaDebito = $this->transaccionContableService->buscarCuentaPorCodigo(
            CuentaContable::MAQUINARIAS_EQUIPOS_ADQ
        );

        if($dataValidated['metodo_pago'] === 'efectivo'){
            $cuentaCredito = $this->transaccionContableService->buscarCuentaPorCodigo(
                CuentaContable::CAJA
            );
            $saldo = $this->transaccionContableService->obtenerSaldoCaja($dataValidated['anio']);
        }
        else if($dataValidated['metodo_pago'] === 'transferencia'){
            $cuentaCredito = $this->transaccionContableService->buscarCuentaPorCodigo(
                CuentaContable::BANCOS
            );
            $saldo = $this->transaccionContableService->obtenerSaldoBanco($dataValidated['anio']);
        } else {
            return response(['message' => 'Metodo de pago no valido'], 400);
        }

        if($saldo < $dataValidated['precio'])
        {
            return redirect()->route('equipos.index')->with('error', 'Saldo insuficiente.');
        }


        $dataValidated['cuenta_debito_id'] = $cuentaDebito->id;
        $dataValidated['cuenta_credito_id'] = $cuentaCredito->id;
    
        $this->equipoService->registrarEquipo($dataValidated);
        return redirect()->route('equipos.index')->with('msg', 'Equipo registrado correctamente.');        
    }

    public function show($id)
    {        
        return $this->equipoService->buscarEquipo($id);
    }

    public function update(EquipoUpdateRequest $request)
    {
        $equipo = $this->equipoService->buscarEquipo($request->input('idEquipo'));

        if(!$equipo){
            return response(['message' => 'Equipo no encontrado'], 404);
        }
        $transaccionEquipo = $this->transaccionContableService->buscarTransaccion($equipo->transaccion_id);
        $transaccionDepreciacion = $this->transaccionContableService->buscarTransaccion($equipo->transaccion_depreciacion_id);

        $this->equipoService->actualizarEquipo($equipo, $transaccionEquipo, $transaccionDepreciacion, $request);
        return redirect()->route('equipos.index')->with('msg', 'Equipo actualizado correctamente.');
    }

    public function destroy($id)
    {        
        $equipo = $this->equipoService->buscarEquipo($id);
        if(!$equipo){
            return response(['message' => 'Equipo no encontrado'], 404);
        }
        $this->equipoService->eliminarEquipo($equipo);
        return redirect()->back()->with('msg', 'Equipo eliminado correctamente.');
    }
}
