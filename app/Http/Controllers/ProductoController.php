<?php

namespace App\Http\Controllers;

use App\Config\PermisosValue;
use App\Http\Services\MovimientoService;
use App\Http\Services\PermisoService;
use App\Models\Producto;
use App\Models\Linea;
use App\Models\Categoria;
use App\Models\Movimiento;
use App\Models\SubCategoria;
use App\Models\UnidadMedida;
use App\Models\Presentacion;
use App\Models\Proveedor;
use App\Models\TipoMovimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        PermisoService::autorizadoOrFail(
            PermisosValue::PRODUCTO_VER_MODULO,
            PermisoService::permisosRol(Auth::user()->rol_id)
        );

        $productos = Producto::orderBy('created_at', 'desc')->get();
        return view('productos.index',['productos'=>$productos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        PermisoService::autorizadoOrFail(
            PermisosValue::PRODUCTO_CREAR,
            PermisoService::permisosRol(Auth::user()->rol_id)
        );

        $lineas = Linea::all();
        $categorias = Categoria::all();
        $subCategoria = SubCategoria::all();
        $unidadMedidas = UnidadMedida::all();
        $presentaciones = Presentacion::all();
        $proveedores = Proveedor::all();
        return view('productos.create',[  'lineas'=>$lineas,
                                            'categorias'=>$categorias,
                                            'subCategoria'=>$subCategoria,
                                            'unidadMedidas'=>$unidadMedidas,
                                            'presentaciones'=>$presentaciones,
                                            'proveedores'=>$proveedores
                                        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $ExoneradoCompra = false;
        if(null !== $request->input('ExoneradoCompra')){
            if($request->input('ExoneradoCompra')== "on"){
                $ExoneradoCompra = true;
            }
        }

        $ExoneradoVenta = false;
        if(null !== $request->input('ExoneradoVenta')){
            if($request->input('ExoneradoVenta')== "on"){
                $ExoneradoVenta = true;
            }
        }

        $producto = new Producto();
        $producto->idProveedor = $request->input('Proveedor');
        $producto->idUnidadMedida =$request->input('UnidadMedida');
        $producto->idPresentacion = $request->input('Presentacion');
        $producto->idLinea = $request->input('Linea');
        $producto->idCategoria = $request->input('Categoria');
        $producto->idSubCategoria = $request->input('SubCategoria');
        $producto->Producto = $request->input('NombreProducto');
        $producto->Marca = $request->input('Marca');
        $producto->Contenido = $request->input('Contenido');
        $producto->CodigoDeBarra =  $request->input('CodigoBarra');
        $producto->StockMinimo = $request->input('StockMinimo');
        $producto->StockMaximo = $request->input('StockMaximo');
        $producto->PrecioReferencialCompra = $request->input('PrecioCompra');
        $producto->PrecioVenta = $request->input('PrecioVenta');
        $producto->ExoneradoCompra = $ExoneradoCompra;
        $producto->ExoneradoVenta = $ExoneradoVenta;

        $producto->save();

        $movimiento = new MovimientoService();
        $valorNuevo = json_encode($producto);
        $movimiento->create([
            'tipo_movimiento_id' => TipoMovimiento::PRODUCTO_EDICION,
            'valor_anterior' => null,
            'valor_nuevo' => $valorNuevo,
            'modulo' => TipoMovimiento::PRODUCTO,
            'usuario_id' => $request->user()->id
        ]);

        return redirect()->route('producto.index')->with('msg','Producto Guardado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        PermisoService::autorizadoOrFail(
            PermisosValue::PRODUCTO_EDITAR,
            PermisoService::permisosRol(Auth::user()->rol_id)
        );

        $producto = Producto::find($id);
        $lineas = Linea::all();
        $categorias = Categoria::all();
        $subCategoria = SubCategoria::all();
        $unidadMedidas = UnidadMedida::all();
        $presentaciones = Presentacion::all();
        $proveedores = Proveedor::all();
        return view('productos.edit',[  'producto' => $producto,
                                        'lineas'=>$lineas,
                                        'categorias'=>$categorias,
                                        'subCategoria'=>$subCategoria,
                                        'unidadMedidas'=>$unidadMedidas,
                                        'presentaciones'=>$presentaciones,
                                        'proveedores'=>$proveedores
                                    ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $ExoneradoCompra = false;
        if(null !== $request->input('ExoneradoCompra')){
            if($request->input('ExoneradoCompra')== "on"){
                $ExoneradoCompra = true;
            }
        }

        $ExoneradoVenta = false;
        if(null !== $request->input('ExoneradoVenta')){
            if($request->input('ExoneradoVenta')== "on"){
                $ExoneradoVenta = true;
            }
        }

        $producto = Producto::find($id);
        $valorAnterior = json_encode($producto);

        $producto->idProveedor = $request->input('Proveedor');
        $producto->idUnidadMedida =$request->input('UnidadMedida');
        $producto->idPresentacion = $request->input('Presentacion');
        $producto->idLinea = $request->input('Linea');
        $producto->idCategoria = $request->input('Categoria');
        $producto->idSubCategoria = $request->input('SubCategoria');
        $producto->Producto = $request->input('NombreProducto');
        $producto->Marca = $request->input('Marca');
        $producto->Contenido = $request->input('Contenido');
        $producto->CodigoDeBarra =  $request->input('CodigoBarra');
        $producto->StockMinimo = $request->input('StockMinimo');
        $producto->StockMaximo = $request->input('StockMaximo');
        $producto->PrecioReferencialCompra = $request->input('PrecioCompra');
        $producto->PrecioVenta = $request->input('PrecioVenta');
        $producto->ExoneradoCompra = $ExoneradoCompra;
        $producto->ExoneradoVenta = $ExoneradoVenta;
        $producto->save();

        $movimiento = new MovimientoService();
        $valorNuevo = json_encode($producto);
        $movimiento->create([
            'tipo_movimiento_id' => TipoMovimiento::PRODUCTO_EDICION,
            'valor_anterior' => $valorAnterior,
            'valor_nuevo' => $valorNuevo,
            'modulo' => TipoMovimiento::PRODUCTO,
            'usuario_id' => $request->user()->id
        ]);


        return redirect()->route('producto.index')->with('msg','Producto Modificado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $producto = Producto::find($id);
        $producto = json_encode($producto);
        $movimiento = new MovimientoService();
        $movimiento->create([
            'tipo_movimiento_id' => TipoMovimiento::PRODUCTO_ELIMINACION,
            'valor_anterior' => $producto,
            'valor_nuevo' => $producto,
            'modulo' => TipoMovimiento::PRODUCTO,
            'usuario_id' => $request->user()->id
        ], esEliminacion : true);

        Producto::where('id', $id)->delete();
        return redirect()->back()->with('msg', 'Producto eliminado correctamente.');
    }

    public function auditoria(Request $request, $modulo){

        PermisoService::autorizadoOrFail(
            PermisosValue::PRODUCTO_VER_AUDITORIA,
            PermisoService::permisosRol(Auth::user()->rol_id)
        );

        if(!$modulo){
            return response()->json(["error" => "El modulo es requerido"]);
        }

        $movimientosService = new MovimientoService();

        $parametros= $request->all();
        $parametros["modulo"] = $modulo;

        $movimientos = $movimientosService->findAll($parametros);

        return view('productos.auditoria', [
            'movimientos' => $movimientos,
            'modulo' => $modulo
        ]);
    }

    public function galeria($id)
    {
        $producto = Producto::find($id);

        return view('productos.galeria', [
            'producto'=> $producto,
        ]);
    }
}
