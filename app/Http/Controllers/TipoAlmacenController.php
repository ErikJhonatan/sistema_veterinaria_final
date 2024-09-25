<?php

namespace App\Http\Controllers;

use App\Models\TipoAlmacen;
use Illuminate\Http\Request;

class TipoAlmacenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipoAlmacen = TipoAlmacen::all(); 
        return view('configuracion.tipoAlmacen',['tipoAlmacen'=>$tipoAlmacen]);
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
        $tipoAlmacen = new TipoAlmacen;
        $tipoAlmacen->TipoAlmacen = $request->input('TipoAlmacen');
        $tipoAlmacen->save();

        return redirect()->route('tipoAlmacen.index')->with('msg','Tipo de Almacen guardado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TipoAlmacen $tipoAlmacen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TipoAlmacen $tipoAlmacen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        dd($request);
        $tipoAlmacen = TipoAlmacen::find($request->input('IdTipoAlmacen'));
        $tipoAlmacen->TipoAlamcen = $request->input('TipoAlmacen');
        $tipoAlmacen->save();

        return redirect()->route('tipoAlmacen.index')->with('msg','Tipo de Almacen modificado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoAlmacen $tipoAlmacen)
    {
        //
    }
}
