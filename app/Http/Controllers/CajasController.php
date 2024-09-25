<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use App\Models\Cliente;
use App\Models\FormaPago;
use App\Models\TipoMovimiento;

use App\Http\Helpers\Token;

use Illuminate\Http\Request;

class CajasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cajas = Caja::with(['tipo', 'medio_pago'])->orderBy('fecha','desc')->get();

        return view('cajas.index', ['cajas' => $cajas]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
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
}
