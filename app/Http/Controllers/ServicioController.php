<?php

namespace App\Http\Controllers;

use App\Config\PermisosValue;
use App\Http\Services\MovimientoService;
use App\Http\Services\PermisoService;
use App\Models\Servicio;
use App\Models\Linea;
use App\Models\Categoria;
use App\Models\SubCategoria;
use App\Models\TipoMovimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        PermisoService::autorizadoOrFail(
            PermisosValue::SERVICIO_VER_MODULO,
            PermisoService::permisosRol(Auth::user()->rol_id)
        );

        $servicios = Servicio::orderBy('created_at', 'desc')->get();
        return view('servicios.index',['servicios'=>$servicios]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        PermisoService::autorizadoOrFail(
            PermisosValue::SERVICIO_CREAR,
            PermisoService::permisosRol(Auth::user()->rol_id)
        );

        $lineas = Linea::all();
        $categorias = Categoria::all();
        $subCategoria = SubCategoria::all();

        return view('servicios.create',[  'lineas'=>$lineas,
                                            'categorias'=>$categorias,
                                            'subCategorias'=>$subCategoria
                                        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'NombreServicio'=>'required|max:60',
        //     'email'=>'nullable|email'
        // ]);
        $ExoneradoImpuestos = false;
        if(null !== $request->input('ExoneradoImpuestos')){
            if($request->input('ExoneradoImpuestos')== "on"){
                $ExoneradoImpuestos = true;
            }
        }

        $servicio = new Servicio();
        $servicio->idLinea = $request->input('Linea');
        $servicio->idCategoria = $request->input('Categoria');
        $servicio->idSubCategoria = $request->input('SubCategoria');
        $servicio->Servicio = $request->input('NombreServicio');
        $servicio->CostoServicio = $request->input('CostoServicio');
        $servicio->PrecioServicio = $request->input('PrecioServicio');
        $servicio->ExoneradoImpuestos = $ExoneradoImpuestos;

        $servicio->save();

        $movimiento = new MovimientoService();
        $movimiento->create([
            'tipo_movimiento_id' => TipoMovimiento::SERVICIO_CREACION,
            'valor_anterior' => null,
            'valor_nuevo' => json_encode($servicio),
            'modulo' => TipoMovimiento::SERVICIO,
            'usuario_id' => $request->user()->id
        ]);

        return redirect()->route('servicio.index')->with('msg','Servicio Guardado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Servicio $servicio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        PermisoService::autorizadoOrFail(
            PermisosValue::SERVICIO_EDITAR,
            PermisoService::permisosRol(Auth::user()->rol_id)
        );

        $servicio = Servicio::find($id);
        $lineas = Linea::all();
        $categorias = Categoria::all();
        $subCategoria = SubCategoria::all();

        return view('servicios.edit',[
                                            'servicio'=>$servicio,
                                            'lineas'=>$lineas,
                                            'categorias'=>$categorias,
                                            'subCategorias'=>$subCategoria
                                        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'NombreServicio'=>'required|max:60',
        //     'email'=>'nullable|email'
        // ]);

        $ExoneradoImpuestos = false;
        if(null !== $request->input('ExoneradoImpuestos')){
            if($request->input('ExoneradoImpuestos')== "on"){
                $ExoneradoImpuestos = true;
            }
        }
        $servicio = Servicio::find($id);
        $valorAnterior = json_encode($servicio);

        $servicio->idLinea = $request->input('Linea');
        $servicio->idCategoria = $request->input('Categoria');
        $servicio->idSubCategoria = $request->input('SubCategoria');
        $servicio->Servicio = $request->input('NombreServicio');
        $servicio->CostoServicio = $request->input('CostoServicio');
        $servicio->PrecioServicio = $request->input('PrecioServicio');
        $servicio->ExoneradoImpuestos = $ExoneradoImpuestos;
        $servicio->save();

        $valorNuevo = json_encode($servicio);

        $movimiento = new MovimientoService();
        $movimiento->create([
            'tipo_movimiento_id' => TipoMovimiento::SERVICIO_EDICION,
            'valor_anterior' => $valorAnterior,
            'valor_nuevo' => $valorNuevo,
            'modulo' => TipoMovimiento::SERVICIO,
            'usuario_id' => $request->user()->id
        ]);

        return redirect()->route('servicio.index')->with('msg','Servicio Modificado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $servicio = Servicio::find($id);
        $servicio = json_encode($servicio);
        $movimiento = new MovimientoService();
        $movimiento->create([
            'tipo_movimiento_id' => TipoMovimiento::SERVICIO_ELIMINACION,
            'valor_anterior' => $servicio,
            'valor_nuevo' => $servicio,
            'modulo' => TipoMovimiento::SERVICIO,
            'usuario_id' => $request->user()->id
        ], esEliminacion : true);

        Servicio::where('id', $id)->delete();

        return redirect()->back()->with('msg', 'Servicio eliminado correctamente.');
    }

    public function getCategorias($id)
    {
        $Categ = Linea::find($id);
        return  response()->json($Categ->getCategorias);
    }

    public function getSubCategorias($id)
    {
        $SubCateg = Categoria::find($id);
        return  response()->json($SubCateg->getSubCategorias);
    }

    public function auditoria(Request $request, $modulo){

        PermisoService::autorizadoOrFail(
            PermisosValue::SERVICIO_VER_AUDITORIA,
            PermisoService::permisosRol(Auth::user()->rol_id)
        );

        if(!$modulo){
            return response()->json(["error" => "El modulo es requerido"]);
        }

        $movimientosService = new MovimientoService();

        $parametros= $request->all();
        $parametros["modulo"] = $modulo;

        $movimientos = $movimientosService->findAll($parametros);

        return view('servicios.auditoria', [
            'movimientos' => $movimientos,
        ]);
    }
}
