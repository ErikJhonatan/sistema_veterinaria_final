<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\Venta;
use App\Models\VentaItem;
use App\Models\Cliente;
use App\Models\Mascota;
use App\Models\Producto;
use App\Models\Servicio;
use App\Models\FormaPago;
use App\Models\TipoMovimiento;
use App\Models\Sede;

use App\Http\Helpers\Token;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AlmacenesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $almacenes = Almacen::with(['tipo'])->get();

        return view('almacenes.index', ['almacenes' => $almacenes]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $tipos_almacenes = Sede::all();

        return view('almacenes.create', ['tipos_almacenes' => $tipos_almacenes]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Datos
        // Modelo

        $datos  = $request->all();
        $almacen= new Almacen();

        $datos['estado'] = 1;

        $almacen->fill($datos);
        $almacen->save();

        return redirect()->route('almacenes.index')->with('msg', 'Almacén creado correctamente.');
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
        $almacen = Almacen::find($id);
        $tipos_almacenes = Sede::all();

        if (!$almacen->exists()) {
            return redirect()->route('almacenes');
        }

        return view('almacenes.edit', ['almacen' => $almacen, 'tipos_almacenes' => $tipos_almacenes]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Datos
        // Modelo

        $datos  = $request->all();
        $almacen= new Almacen();

        $almacen->where('id', $id)->update([
            'sede_id' => $datos['sede_id'],
            'nombre' => $datos['nombre']
        ]);

        return redirect()->route('almacenes.index')->with('msg', 'Almacén actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Almacen $almacen)
    {
        $almacen->first()->delete();

        return redirect()->back()->with('msg', 'Almacén eliminado correctamente.');
    }
}
