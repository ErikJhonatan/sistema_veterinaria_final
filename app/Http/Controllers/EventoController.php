<?php

namespace App\Http\Controllers;

use App\Config\PermisosValue;
use App\Http\Requests\Evento\SaveEventoRequest;
use App\Http\Services\PermisoService;
use App\Models\Evento;
use App\Models\Cliente;
use App\Models\Mascota;
use App\Models\TipoEvento;
use App\Models\EstadoEvento;
use App\Models\Notificacion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        PermisoService::autorizadoOrFail(
            PermisosValue::EVENTO_VER_MODULO,
            PermisoService::permisosRol(Auth::user()->rol_id)
        );

        $cliente = Cliente::all();
        $tiposEvento = TipoEvento::all();
        $estadoEvento = EstadoEvento::all();
        $notidicacionEvento = Notificacion::all();
        $usuarios = User::all();
        $eventos = Evento::all(); // withTrashed();
        $allEventos = [];
        foreach($eventos  as $evento){
            $allEventos[] = [
                'idDb' => $evento->id,
                'idCliente' => $evento->idCliente,
                'idMascota' => $evento->idMascota,
                'idTipoEvento' => $evento->idTipoEvento,
                'idEstadoEvento' => $evento->idEstadoEvento,
                'idUsuario' => $evento->idUsuario,
                'idNotificacion' => $evento->idNotificacion,
                'Observacion' => $evento->Observacion,
                'title'=> $evento->Evento,
                'FechaInicio'=> $evento->FechaInicio,
                'FechaFin'=> $evento->FechaFin,
                'start'=> $evento->FechaInicio,
                'end'=> $evento->FechaFin,
            ];
        }

  	    return view('eventos.index',[
            'allEventos' =>$allEventos,
            'clientes' =>$cliente,
            'tiposEvento' => $tiposEvento,
            'estadoEvento' => $estadoEvento,
            'notificacion' =>$notidicacionEvento,
            'users' =>$usuarios]);
    }

    public function list()
    {
        $eventos = Evento::all();
        return view('eventos.list',['eventos'=>$eventos]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveEventoRequest $request)
    {
        $usuario = User::find($request->usuarioAutenticadoId);
        PermisoService::autorizadoOrFail(
            PermisosValue::EVENTO_CREAR,
            PermisoService::permisosRol($usuario->rol_id)
        );

        $evento = new Evento;
        $evento->idCliente = $request->input('idCliente');
        $evento->idUsuario = $request->input('idUsuario');
        $evento->idNotificacion = $request->input('idNotificacion');
        $evento->Evento = $request->input('Evento');
        $evento->idTipoEvento = $request->input('idTipoEvento');
        $evento->idEstadoEvento = $request->input('idEstadoEvento');
        $evento->FechaInicio = $request->input('FechaInicio');
        $evento->FechaFin = $request->input('FechaFin');
        $evento->Observacion = $request->input('Observacion');
        $evento->idMascota = $request->input('idMascota');
        $evento->save();

        return response()->json($evento, 200);

    }

    /**
     * Display the specified resource.
     */
    public function show(Evento $evento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Evento $evento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveEventoRequest $request, int $id)
    {

        $usuario = User::find($request->usuarioAutenticadoId);
        PermisoService::autorizadoOrFail(
            PermisosValue::EVENTO_EDITAR,
            PermisoService::permisosRol($usuario->rol_id)
        );

        $evento = Evento::find($id);
        if(!$evento){
            return response()->json(['message' => 'Evento no encontrado'], 404);
        }

        $evento->idCliente = $request->input('idCliente') ?? $evento->idCliente;
        $evento->idUsuario = $usuario->id;
        $evento->idNotificacion = $request->input('idNotificacion') ?? $evento->idNotificacion;
        $evento->Evento = $request->input('Evento') ?? $evento->Evento;
        $evento->idTipoEvento = $request->input('idTipoEvento') ?? $evento->idTipoEvento;
        $evento->idEstadoEvento = $request->input('idEstadoEvento') ?? $evento->idEstadoEvento;
        $evento->FechaInicio = $request->input('FechaInicio') ?? $evento->FechaInicio;
        $evento->FechaFin = $request->input('FechaFin') ??  $evento->FechaFin;
        $evento->Observacion = $request->input('Observacion') ?? $evento->Observacion;
        $evento->idMascota = $request->input('idMascota') ?? $evento->idMascota;
        $evento->save();


        return response()->json($evento, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Evento $evento, $id)
    {
        $evento->where('id', $id)->delete();

        return redirect()->back()->with('msg', 'Evento eliminado correctamente.');
    }
}
