<?php

namespace App\Http\Controllers;

use App\Models\SubCategoria;
use App\Models\Categoria;
use Illuminate\Http\Request;

class SubCategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subCategorias = SubCategoria::all(); 
        $categorias  = Categoria::all(); 
        return view('configuracion.subCategoria',['subCategorias'=>$subCategorias, 'categorias'=>$categorias ]);
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
        $subCcategoria = new SubCategoria;
        $subCcategoria->IdCategoria = $request->input('Categoria');
        $subCcategoria->SubCategoria = $request->input('SubCategoria');
        $subCcategoria->save();

        return redirect()->route('subCategoria.index')->with('msg','Sub Categoria guardada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SubCategoria $subCategoria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubCategoria $subCategoria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $subCategoria= SubCategoria::find($request->input('IdSubCategoria'));
        $subCategoria->IdCategoria = $request->input('IdCategoria');
        $subCategoria->SubCategoria = $request->input('SubCategoria');
        $subCategoria->save();

        return redirect()->route('subCategoria.index')->with('msg','Sub Categoria modificada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubCategoria $subCategoria)
    {
        //
    }
}
