<?php

namespace App\Http\Controllers;

use App\Models\FormaPago;
use Illuminate\Http\Request;

class FormaPagoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $formaPagos = FormaPago::all(); 
        return view('configuracion.formaPago',['formaPagos'=>$formaPagos]);
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
        $formaPago = new FormaPago;
        $formaPago->FormaDePago = $request->input('FormaPago');
        $formaPago->save();

        return redirect()->route('formaPago.index')->with('msg','Forma de pago guardada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(FormaPago $formaPago)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FormaPago $formaPago)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $formaPago = FormaPago::find($request->input('IdFormaPago'));
        $formaPago->FormaDePago = $request->input('FormaPago');
        $formaPago->save();

        return redirect()->route('formaPago.index')->with('msg','Forma de pago  modificado correctamente.');

   
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FormaPago $formaPago)
    {
        //
    }
}
