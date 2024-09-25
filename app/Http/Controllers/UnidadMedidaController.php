<?php

namespace App\Http\Controllers;

use App\Models\UnidadMedida;
use Illuminate\Http\Request;

class UnidadMedidaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $unidadMedida = UnidadMedida::all(); 
        return view('configuracion.unidadMedida',['unidadMedida'=>$unidadMedida]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $unidadMedida = new UnidadMedida;
        $unidadMedida->UnidadMedida = $request->input('UnidadMedida');
        $unidadMedida->save();

        return redirect()->route('unidadMedida.index')->with('msg','Unidad de medida guardada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(UnidadMedida $unidadMedida)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UnidadMedida $unidadMedida)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $UnidadMedida = UnidadMedida::find($request->input('IdUnidadMedida'));
        $UnidadMedida->UnidadMedida = $request->input('UnidadMedida');
        $UnidadMedida->save();

        return redirect()->route('unidadMedida.index')->with('msg','Unidad de Medida modificada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UnidadMedida $unidadMedida)
    {
        //
    }
}
