<?php

namespace App\Http\Controllers;

use App\Models\Raza;
use App\Models\Especie;
use Illuminate\Http\Request;

class RazaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $especies = Especie::all(); 
        $razas = Raza::all(); 
        return view('configuracion.raza',['especies'=>$especies, 'razas'=>$razas ]);
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
        $raza = new Raza;
        $raza->idEspecie = $request->input('Especie');
        $raza->Raza = $request->input('Raza');
        $raza->save();

        return redirect()->route('raza.index')->with('msg','Raza guardada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Raza $raza)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Raza $raza)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $raza = Raza::find($request->input('IdRaza'));
        $raza->idEspecie = $request->input('IdEspecie');
        $raza->Raza= $request->input('Raza');
        $raza->save();

        return redirect()->route('raza.index')->with('msg','Raza modificada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Raza $raza)
    {
        //
    }
}
