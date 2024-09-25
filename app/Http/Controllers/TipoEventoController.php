<?php

namespace App\Http\Controllers;

use App\Models\TipoEvento;
use Illuminate\Http\Request;

class TipoEventoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipoEvento = TipoEvento::all(); 
        return view('configuracion.tipoEvento',['tipoEvento'=>$tipoEvento]);
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
        $tipoEvento = new TipoEvento;
        $tipoEvento->TipoEvento = $request->input('TipoEvento');
        $tipoEvento->save();

        return redirect()->route('tipoEvento.index')->with('msg','Tipo de Evento guardado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TipoEvento $tipoEvento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TipoEvento $tipoEvento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TipoEvento $tipoEvento)
    {
        $tipoEvento = TipoEvento::find($request->input('IdTipoEvento'));
        $tipoEvento->TipoEvento = $request->input('TipoEvento');
        $tipoEvento->save();

        return redirect()->route('tipoEvento.index')->with('msg','Tipo de Evento modificado correctamente.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoEvento $tipoEvento)
    {
        //
    }
}
