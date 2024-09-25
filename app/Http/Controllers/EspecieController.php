<?php

namespace App\Http\Controllers;

use App\Models\Especie;
use Illuminate\Http\Request;

class EspecieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $especies = Especie::all(); 
        return view('configuracion.especie',['especies'=>$especies]);
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
        $especie = new Especie;
        $especie->Especie = $request->input('EspecieNew');
        $especie->save();

        return redirect()->route('especie.index')->with('msg','Especie guardada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Especie $especie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Especie $especie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $especie = Especie::find($request->input('IdEspecie'));
        $especie->Especie = $request->input('Especie');
        $especie->save();

        return redirect()->route('especie.index')->with('msg','Especie modificada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Especie $especie)
    {
        //
    }
}
