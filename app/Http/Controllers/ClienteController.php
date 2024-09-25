<?php

namespace App\Http\Controllers;

use App\Config\PermisosValue;
use App\Http\Services\MovimientoService;
use App\Http\Services\PermisoService;
use App\Models\Cliente;
use App\Models\Departamento;
use App\Models\Provincia;
use App\Models\Distrito;
use App\Models\TipoMovimiento;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        PermisoService::autorizadoOrFail(
            PermisosValue::CLIENTE_VER_MODULO,
            PermisoService::permisosRol(Auth::user()->rol_id)
        );


        $clientes = Cliente::with('getMascotas')->orderBy('created_at', 'desc')->get();
        return view('clientes.index',['clientes'=> $clientes]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        PermisoService::autorizadoOrFail(
            PermisosValue::CLIENTE_CREAR,
            PermisoService::permisosRol(Auth::user()->rol_id)
        );

        $departamentos = Departamento::all();
        $provincias = Provincia::all();
        $distritos = Distrito::all();
        return view('clientes.create',[  'departamentos'=>$departamentos,
                                            'provincias'=>$provincias,
                                            'distritos'=>$distritos
                                        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $ClienteReferido = false;
        if(null !== $request->input('ClienteReferido')){
            if($request->input('ClienteReferido')== "on"){
                $ClienteReferido = true;
            }
        }
        $cliente = new Cliente();
        $cliente->idDepartamento = $request->input('Departamento');
        $cliente->idProvincia = $request->input('Provincia');
        $cliente->idDistrito = $request->input('Distrito');
        $cliente->Nombre = $request->input('Nombre');
        $cliente->Apellido = $request->input('Apellido');
        $cliente->DocumentoIdentidad = $request->input('DocumentoIdentidad');
        if($request->input('FechaNacimiento') != null){
            $cliente->FechaNacimiento = Carbon::createFromFormat('d/m/Y', $request->input('FechaNacimiento'));
        }
        $cliente->Email = $request->input('Email');
        $cliente->TelefonoFijo = $request->input('TelefonoFijo');
        $cliente->TelefonoMovil = $request->input('TelefonoMovil');
        $cliente->TelefonoTrabajo = $request->input('TelefonoTrabajo');
        $cliente->Direccion = $request->input('Direccion');
        $cliente->ClienteReferido = $ClienteReferido;
        $cliente->Observaciones = $request->input('Observaciones');
        $cliente->NombreEmpresa = $request->input('NombreEmpresa');
        $cliente->RegistroTributario = $request->input('RegistroTributario');
        $cliente->DireccionEmpresa = $request->input('DireccionEmpresa');
        $cliente->Facebook = $request->input('Facebook');
        $cliente->Instagram = $request->input('Instagram');
       // $cliente->ZonaResidencia = $request->input('ZonaResidencia');
        $cliente->ReferenciaDireccion = $request->input('ReferenciaDireccion');

        $cliente->save();

        $movimiento = new MovimientoService();
        $movimiento->create([
            'tipo_movimiento_id' => TipoMovimiento::CLIENTE_CREACION,
            'valor_anterior' => null,
            'valor_nuevo' => json_encode($cliente),
            'modulo' => TipoMovimiento::CLIENTE,
            'usuario_id' => $request->user()->id
        ]);

        return redirect()->route('cliente.index')->with('msg','Registro Guardado correctamente.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        PermisoService::autorizadoOrFail(
            PermisosValue::CLIENTE_EDITAR,
            PermisoService::permisosRol(Auth::user()->rol_id)
        );

        $clientes = Cliente::find($id);
        $departamentos = Departamento::all();
        $provincias = Provincia::all();
        $distritos = Distrito::all();
        return view('clientes.edit',[
                                            'cliente'=>$clientes,
                                            'departamentos'=>$departamentos,
                                            'provincias'=>$provincias,
                                            'distritos'=>$distritos
                                        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        /*$request->validate([
            'NombrePrveedor'=>'required|max:3',
            'email'=>'nullable|email'
        ]);*/
        $ClienteReferido = false;
        if(null !== $request->input('ClienteReferido')){
            if($request->input('ClienteReferido')== "on"){
                $ClienteReferido = true;
            }
        }
        $cliente = Cliente::find($id);
        $valorAnterior = json_encode($cliente);

        $cliente->idDepartamento = $request->input('Departamento');
        $cliente->idProvincia = $request->input('Provincia');
        $cliente->idDistrito = $request->input('Distrito');
        $cliente->Nombre = $request->input('Nombre');
        $cliente->Apellido = $request->input('Apellido');
        $cliente->DocumentoIdentidad = $request->input('DocumentoIdentidad');
        if($request->input('FechaNacimiento') != null){
            $cliente->FechaNacimiento = Carbon::createFromFormat('d/m/Y', $request->input('FechaNacimiento'));
        }
        $cliente->Email = $request->input('Email');
        $cliente->TelefonoFijo = $request->input('TelefonoFijo');
        $cliente->TelefonoMovil = $request->input('TelefonoMovil');
        $cliente->TelefonoTrabajo = $request->input('TelefonoTrabajo');
        $cliente->Direccion = $request->input('Direccion');
        $cliente->ClienteReferido = $ClienteReferido;
        $cliente->Observaciones = $request->input('Observaciones');
        $cliente->NombreEmpresa = $request->input('NombreEmpresa');
        $cliente->RegistroTributario = $request->input('RegistroTributario');
        $cliente->DireccionEmpresa = $request->input('DireccionEmpresa');
        $cliente->Facebook = $request->input('Facebook');
        $cliente->Instagram = $request->input('Instagram');
        //$cliente->ZonaResidencia = $request->input('ZonaResidencia');
        $cliente->ReferenciaDireccion = $request->input('ReferenciaDireccion');

        $cliente->save();

        $movimiento = new MovimientoService();
        $movimiento->create([
            'tipo_movimiento_id' => TipoMovimiento::CLIENTE_EDICION,
            'valor_anterior' => $valorAnterior,
            'valor_nuevo' => json_encode($cliente),
            'modulo' => TipoMovimiento::CLIENTE,
            'usuario_id' => $request->user()->id
        ]);

        return redirect()->route('cliente.index')->with('msg','Cliente Modificado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request ,$id)
    {
        $cliente = json_encode(Cliente::find($id));
        $movimiento = new MovimientoService();
        $movimiento->create([
            'tipo_movimiento_id' => TipoMovimiento::CLIENTE_ELIMINACION,
            'valor_anterior' => $cliente,
            'valor_nuevo' => $cliente,
            'modulo' => TipoMovimiento::CLIENTE,
            'usuario_id' => $request->user()->id
        ], esEliminacion : true);

        Cliente::where('id', $id)->delete();

        return redirect()->back()->with('msg', 'Cliente eliminado correctamente.');
    }


    public function getProvincias($id)
    {
        $depto = Departamento::find($id);
        return  response()->json($depto->getProvincias);
    }

    public function getDistritos($id)
    {
        $prov = Provincia::find($id);
        return  response()->json($prov->getDistritos);
    }

    public function  getGrafico(){

        DB::statement("SET lc_time_names = 'es_ES'");

        $clientesPorProvincia =
                    Cliente::select([
                        'idProvincia',
                        DB::raw('count(*) as Total'),
                    ])
                    ->with([
                        'provincia'
                    ])
                    ->groupby('idProvincia')
                    ->get();
        $clientesPorMes = Cliente::select([
            'created_at',
            DB::raw('count(*) as Total'),
            DB::raw("CONCAT(MONTHNAME(created_at), '-', YEAR(created_at)) as Mes")
        ])
        ->groupBy('Mes')
        ->get();


        return view('clientes.graphics',[
            'clientesPorProvincia' => $clientesPorProvincia,
            'clientesPorMes' => $clientesPorMes
        ]);

    }

    public function auditoria(Request $request, $modulo){
        if(!$modulo){
            return response()->json(["error" => "El modulo es requerido"]);
        }

        $movimientosService = new MovimientoService();

        $parametros= $request->all();
        $parametros["modulo"] = $modulo;

        $movimientos = $movimientosService->findAll($parametros);

        return view('clientes.auditoria', [
            'movimientos' => $movimientos,
        ]);
    }

}
