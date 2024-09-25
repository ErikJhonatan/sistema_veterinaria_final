<?php
namespace App\Http\Services\TransaccionContable;

use App\Models\Contabilidad\LibroDiario;
use App\Models\Contabilidad\LibroMayor;
use App\Http\Services\Contabilidad\LibroDiario\LibroDiarioService;
use App\Http\Services\Contabilidad\LibroMayor\LibroMayorService;
use App\Models\Contabilidad\TransaccionContable;
use App\Models\Contabilidad\CuentaContable;
use App\Models\Contabilidad\EquipoContable;
use Carbon\Carbon;
class EquipoService
{
    protected $transaccionContableService;
    protected $libroDiarioService;
    protected $libroMayorService;

    public function __construct(
        TransaccionContableService $transaccionContableService,
        LibroDiarioService $libroDiarioService,
        LibroMayorService $libroMayorService
    )

    {
        $this->transaccionContableService = $transaccionContableService;
        $this->libroDiarioService = $libroDiarioService;
        $this->libroMayorService = $libroMayorService;
    }

    public function registrarEquipo($dataValidated)
    {

        $transaccionEquipo = $this->transaccionContableService->crearTransaccionContable(
            [
                'concepto' => 'Compra de equipo ' . $dataValidated['nombre'],
                'descripcion' => 'Compra de equipo ' . $dataValidated['nombre'],
                'monto' => $dataValidated['precio'],
                'fecha' => $dataValidated['fecha_adquisicion'],
                'tipo_transaccion' => 'compra_equipo',
                'monto_total' => $dataValidated['precio'],
                'metodo_pago' => $dataValidated['metodo_pago'],
                'cuenta_debito_id' => $this->transaccionContableService->buscarCuentaPorCodigo(
                    CuentaContable::MAQUINARIAS_EQUIPOS_ADQ
                )->id,
                'cuenta_credito_id' => $this->transaccionContableService->buscarCuentaPorCodigo(
                    $dataValidated['metodo_pago'] === 'efectivo' ? CuentaContable::CAJA : CuentaContable::BANCOS
                )->id
            ]
        );
        $fecha = Carbon::parse($dataValidated['fecha_adquisicion']);
        $vidaUtil = (int) $dataValidated['vida_util'];
        $transaccionDepreciacion = TransaccionContable::create([
            'concepto' => 'Depreciacion de equipo ' . $dataValidated['nombre'],
            'descripcion' => 'Depreciacion de equipo ' . $dataValidated['nombre'],
            'monto' => $dataValidated['precio'],
            'fecha' => $fecha->addYear($vidaUtil),
            'tipo_transaccion' => 'depreciacion_equipo',
            'monto_total' => $dataValidated['precio'],
            'metodo_pago' => $dataValidated['metodo_pago'],
            'cuenta_debito_id' => $this->transaccionContableService->buscarCuentaPorCodigo(
                CuentaContable::DEPRECIACION_MAQUINARIAS_EQUIPOS
            )->id,
            'cuenta_credito_id' => $this->transaccionContableService->buscarCuentaPorCodigo(
                CuentaContable::MAQUINARIAS_EQUIPOS_ADQ
            )->id
        ]);

        $dataValidated['transaccion_id'] = $transaccionEquipo->id;
        $dataValidated['transaccion_depreciacion_id'] = $transaccionDepreciacion->id;


        $equipo = EquipoContable::create($dataValidated);


        for($i = 1; $i <= $dataValidated['vida_util']; $i++){
            $fecha = Carbon::parse($dataValidated['fecha_adquisicion']);
            $dataDepreciacion = [
                'fecha' => $fecha->addYear($i),
                'monto' => $transaccionDepreciacion->monto / $dataValidated['vida_util'],
                'concepto' => $transaccionDepreciacion->descripcion,
                'cuenta_debito_id' => $transaccionDepreciacion->cuenta_debito_id,
                'cuenta_credito_id' => $transaccionDepreciacion->cuenta_credito_id
            ];
           $this->registrarDepreciacionEquipo($dataDepreciacion, $transaccionDepreciacion, $dataValidated['vida_util']);
        }
        return $equipo;
    }


    public function registrarDepreciacionEquipo($data, $transaccionContable, $vidaUtil)
    {


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
    }

    public function buscarEquipo($id)
    {
        return EquipoContable::find($id);
    }

    public function actualizarEquipo($equipo, $transaccionEquipo, $transaccionDepreaciacion, $data)
    {
        $dataValidated = $data->validated();
        $equipo->update($dataValidated);

        $depreciaciones_libro_diario = LibroDiario::where('transaccion_contable_id', $transaccionDepreaciacion->id)
            ->get();
        $depreciaciones_libro_mayor = LibroMayor::where('transaccion_contable_id', $transaccionDepreaciacion->id)
            ->get();

        $transaccionEquipo = TransaccionContable::find($equipo->transaccion_id);
        $transaccionDepreciacion = TransaccionContable::find($equipo->transaccion_depreciacion_id);

        $actualizarEquipo = $transaccionEquipo->update(
            [
                'concepto' => 'Compra de equipo ' . $dataValidated['nombre'],
                'descripcion' => 'Compra de equipo ' . $dataValidated['nombre'],
                'monto' => $dataValidated['precio'],
                'fecha' => $dataValidated['fecha_adquisicion'],
                'monto_total' => $dataValidated['precio'],
            ]
        );
        // debito
        $cuentaDebitoRegistro = $this->libroDiarioService->actualizarLibroDiario(
            $dataValidated['fecha_adquisicion'],
            $dataValidated['precio'],
            0,
            'Compra de equipo ' . $dataValidated['nombre'],
            $transaccionEquipo->cuenta_debito_id,
            $transaccionEquipo->id,
        );
        $cuentaHaberRegistro = $this->libroDiarioService->actualizarLibroDiario(
            $dataValidated['fecha_adquisicion'],
            0,
            $dataValidated['precio'],
            'Compra de equipo ' . $dataValidated['nombre'],
            $transaccionEquipo->cuenta_credito_id,
            $transaccionEquipo->id,
        );

        $actualizarDepreciacion = $transaccionDepreaciacion->update(
            [
                'concepto' => 'Depreciacion de equipo ' . $dataValidated['nombre'],
                'descripcion' => 'Depreciacion de equipo ' . $dataValidated['nombre'],
                'monto' => $dataValidated['precio'],
                'fecha' => $dataValidated['fecha_adquisicion'],
                'monto_total' => $dataValidated['precio'],
            ]
        );

        $actualizarDepreciacion = $this->actualizarLibrosDepreaciacion($equipo, $transaccionDepreciacion, $data, $depreciaciones_libro_diario, $depreciaciones_libro_mayor);

        return $equipo;
    }

    public function actualizarLibrosDepreaciacion($equipo, $transaccion, $data, $registrosLibroDiario, $registrosLibroMayor)
    {
        $fechaLibroDiario =  Carbon::parse($data['fecha_adquisicion']);
        $fechaLibroMayor = Carbon::parse($data['fecha_adquisicion']);
        foreach($registrosLibroDiario as $indice => $depreciacion){
            // actualizar libro diario cuenta debito
            $indice = $indice + 1;

            if(!($indice%2 === 0)){
                $fechaLibroDiario->addYear(1);
            }

            if($depreciacion->cuenta_contable_id === $transaccion->cuenta_debito_id){
                $depreciacion->update([
                    'fecha' => $fechaLibroDiario,
                    'debe' => $equipo->precio / $equipo->vida_util,
                    'concepto' => 'Depreciacion de equipo ' . $equipo->nombre
                ]);
            }
            // actualizar libro diario cuenta credito
            else if($depreciacion->cuenta_contable_id === $transaccion->cuenta_credito_id){
                $depreciacion->update([
                    'fecha' => $fechaLibroDiario,
                    'haber' => $equipo->precio / $equipo->vida_util,
                    'concepto' => 'Depreciacion de equipo ' . $equipo->nombre
                ]);
            }
        }

        $fechaLibroMayor =  Carbon::parse($data['fecha_adquisicion']);
        foreach($registrosLibroMayor as $indice => $depreciacion){
            // actualizar libro mayor cuenta debito
            $indice = $indice + 1;
            if(!($indice%2 === 0)){
                $fechaLibroMayor->addYear(1);
            }

            if($depreciacion->cuenta_contable_id === $transaccion->cuenta_debito_id){
                $depreciacion->update([
                    'fecha' => $fechaLibroMayor,
                    'debe' => $equipo->precio / $equipo->vida_util,
                    'saldo_deudor' => $equipo->precio / $equipo->vida_util
                ]);
            }
            // actualizar libro mayor cuenta credito
            else if($depreciacion->cuenta_contable_id === $transaccion->cuenta_credito_id){
                $depreciacion->update([
                    'fecha' => $fechaLibroMayor,
                    'haber' => $equipo->precio / $equipo->vida_util,
                    'saldo_acreedor' => $equipo->precio / $equipo->vida_util
                ]);
            };
        }
    }


    public function listarEquipos($year)
    {
        return EquipoContable::whereYear('created_at', $year)->get();
    }

    public function eliminarEquipo($equipo)
    {
        $transaccionEquipo = TransaccionContable::find($equipo->transaccion_id);
        $transaccionDepreciacion = TransaccionContable::find($equipo->transaccion_depreciacion_id);


        if (!$transaccionEquipo || !$transaccionDepreciacion) {
            return response(['message' => 'Transaccion no encontrada'], 404);
        }

        $transaccionEquipo->delete();
        $transaccionDepreciacion->delete();
        return response(['message' => 'Transaccion eliminada'], 200);
    }
}
