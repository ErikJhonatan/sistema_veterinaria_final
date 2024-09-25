<?php

namespace App\Http\Controllers;

use App\Config\PermisosValue;
use App\Models\ProductoStock;
use App\Models\Producto;
use App\Models\Almacen;
use App\Models\Cliente;
use App\Models\FormaPago;
use App\Models\TipoMovimiento;

use App\Http\Helpers\Token;
use App\Http\Services\PermisoService;
use App\Models\Caja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StocksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        PermisoService::autorizadoOrFail(
            PermisosValue::INVENTARIO_VER_MODULO, 
            PermisoService::permisosRol(Auth::user()->rol_id)
        );

        $productos = Producto::with(['stocks'])->get();
        $almacenes = Almacen::all();

        return view('stocks.index', ['productos' => $productos, 'almacenes' => $almacenes]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        PermisoService::autorizadoOrFail(
            PermisosValue::INVENTARIO_MODIFICAR, 
            PermisoService::permisosRol(Auth::user()->rol_id)
        );

        $tipo = $request->tipo;
        $medios_pago = FormaPago::all();

        return view('cajas.create', ['tipo' => $tipo, 'medios_pago' => $medios_pago]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Datos
        // Modelo

        $datos  = $request->all();
        $caja   = new Caja();

        $datos['transaccion'] = Token::create(8, true);
        $datos['importe_'. $datos['movimiento']] = $datos['monto'];
        $datos['tipo_movimiento_id'] = TipoMovimiento::DIRECTO;

        $caja->fill($datos);
        $caja->save();

        return redirect()->route('cajas.index')->with('msg', 'Movimiento de caja creado correctamente.');
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

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Caja $caja)
    {
        $caja->delete();

        return redirect()->back()->with('msg', 'Movimiento de caja eliminado correctamente.');
    }

    // AJAX

    public function ajax(Request $request) {

        PermisoService::autorizadoOrFail(
            PermisosValue::INVENTARIO_MODIFICAR, 
            PermisoService::permisosRol(Auth::user()->rol_id)
        );

        $stock_id       = $request->input('stock_id');
        $producto_id    = $request->input('producto_id');
        $almacen_id     = $request->input('almacen_id');
        $cantidad       = $request->input('cantidad');
        $accion         = $request->input('accion');
        $datos          = $request->all();

        // Agregar stock

        if ($accion == 'agregar') {
            $stock      = new ProductoStock();
            $existencia = $stock->where('producto_id', $producto_id)->where('almacen_id', $almacen_id)->exists();

            if (!$existencia) {
                $stock->fill($datos)->save();

                $almacen = $stock->with('almacen')->where('id', $stock->id)->first()->almacen->nombre;
                $cantidad = '<div class="row">
                <div class="col-md-8">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-fw fa-hashtag"></i></span>
                        </div>
                        <input type="number" class="form-control form-control-sm" name="cantidad" value="'. $cantidad .'" placeholder="* Cantidad" min="0" step="1" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-success btn-sm modificar-stock w-100" data-stock_id="'. $stock->id .'">
                        <span class="text">
                            <i class="fas fa-fw fa-pen"></i> Modificar
                        </span>

                        <span class="spinner">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        </span>
                    </button>
                </div>
            </div>';
                $opciones = '<span class="eliminar-stock" data-stock_id="'. $stock->id .'" Title="Eliminar stock"><i class="fa fa-fw fa-trash"></i></span>';
            }
        }

        // Modificar stock

        if ($accion == 'modificar') {
            $stock      = new ProductoStock();
            $stock->where('id', $stock_id)->update([
                'cantidad' => $cantidad
            ]);
        }

        // Eliminar stock

        if ($accion == 'eliminar') {
            $stock      = new ProductoStock();
            $stock->where('id', $stock_id)->delete();
        }

        // Retornar datos

        $data = [
            'existencia' => $existencia ?? null,
            'almacen' => $almacen ?? null,
            'cantidad' => $cantidad ?? null,
            'opciones' => $opciones ?? null,
        ];

        return response()->json($data);
    }
}
