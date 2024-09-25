<?php

namespace App\Http\Controllers;

use App\Models\EstadoEvento;
use Illuminate\Http\Request;

class EstadoEventoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $estadoEvento = EstadoEvento::all(); 
        return view('configuracion.estadoEvento',['estadoEvento'=>$estadoEvento]);
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
        $estadoEvento = new EstadoEvento;
        $estadoEvento->EstadoEvento = $request->input('EstadoEvento');
        $estadoEvento->save();

        return redirect()->route('estadoEvento.index')->with('msg','Estado Evento guardado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(EstadoEvento $estadoEvento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EstadoEvento $estadoEvento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EstadoEvento $estadoEvento)
    {
        $estadoEvento = EstadoEvento::find($request->input('IdEstadoEvento'));
        $estadoEvento->estadoEvento = $request->input('EstadoEvento');
        $estadoEvento->save();

        return redirect()->route('estadoEvento.index')->with('msg','Estado Evento modificado correctamente.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EstadoEvento $estadoEvento)
    {
        //
    }
}
