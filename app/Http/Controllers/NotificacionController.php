<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use Illuminate\Http\Request;

class NotificacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notificacion = Notificacion::all(); 
        return view('configuracion.notificacion',['notificacion'=>$notificacion ]);
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
        $notificacion = new Notificacion;
        $notificacion->Notificacion = $request->input('Notificacion');
        $notificacion->save();

        return redirect()->route('notificacion.index')->with('msg','Notificacion guardada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Notificacion $notificacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notificacion $notificacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $Notificacion = Notificacion::find($request->input('IdNotificacion'));
        $Notificacion->Notificacion = $request->input('Notificacion');
        $Notificacion->save();

        return redirect()->route('notificacion.index')->with('msg','Notificacion modificado correctamente.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notificacion $notificacion)
    {
        //
    }
}
