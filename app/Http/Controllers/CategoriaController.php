<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Linea;
use Illuminate\Http\Request; 

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = Categoria::all(); 
        $lineas = Linea::all(); 
        return view('configuracion.categoria',['categorias'=>$categorias, 'lineas'=>$lineas ]);
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
        $categoria = new Categoria;
        $categoria->IdLinea = $request->input('Linea');
        $categoria->Categoria = $request->input('Categoria');
        $categoria->save();

        return redirect()->route('categoria.index')->with('msg','Categoria guardada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Categoria $categoria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categoria $categoria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $categoria= Categoria::find($request->input('IdCategoria'));
        $categoria->IdLinea = $request->input('IdLinea');
        $categoria->Categoria = $request->input('Categoria');
        $categoria->save();

        return redirect()->route('categoria.index')->with('msg','Categoria modificada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categoria $categoria)
    {
        //
    }
}
