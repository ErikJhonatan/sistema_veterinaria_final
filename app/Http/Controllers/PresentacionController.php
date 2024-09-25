<?php

namespace App\Http\Controllers;

use App\Models\Presentacion;
use Illuminate\Http\Request;

class PresentacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $presentacion = Presentacion::all(); 
        return view('configuracion.presentacion',['presentacion'=>$presentacion]);
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
        $presentacion = new Presentacion;
        $presentacion->Presentacion = $request->input('Presentacion');
        $presentacion->save();

        return redirect()->route('presentacion.index')->with('msg','Presentacion guardada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Presentacion $presentacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Presentacion $presentacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $Presentacion = Presentacion::find($request->input('IdPresentacion'));
        $Presentacion->Presentacion = $request->input('Presentacion');
        $Presentacion->save();

        return redirect()->route('presentacion.index')->with('msg','Presentacion modificada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Presentacion $presentacion)
    {
        //
    }
}
