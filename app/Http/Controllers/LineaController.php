<?php

namespace App\Http\Controllers;

use App\Models\Linea;
use Illuminate\Http\Request;

class LineaController extends Controller 
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lineas = Linea::all(); 
        return view('configuracion.linea',['lineas'=>$lineas]);
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
        $Linea = new Linea;
        $Linea->Linea = $request->input('Linea');
        $Linea->save();

        return redirect()->route('linea.index')->with('msg','Linea guardada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Linea $linea)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Linea $linea)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $Linea = Linea::find($request->input('IdLinea'));
        $Linea->Linea = $request->input('Linea');
        $Linea->save();

        return redirect()->route('linea.index')->with('msg','Linea modificada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Linea $linea)
    {
        //
    }
}
