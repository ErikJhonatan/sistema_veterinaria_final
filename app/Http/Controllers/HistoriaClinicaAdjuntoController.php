<?php

namespace App\Http\Controllers;

use App\Http\Requests\HistoriaClinica\SaveAdjuntoRequest;
use App\Models\HistoriaClinicaAdjunto;
use Illuminate\Http\Request;

class HistoriaClinicaAdjuntoController extends Controller
{
    public function findAll(Request $request){
        $parametros = $request->all();
        $query = HistoriaClinicaAdjunto::query();
        $adjuntos = $query
                ->when(isset($parametros["historia_clinica_id"]), function($q) use($parametros){
                    return $q->where("historia_clinica_id", $parametros["historia_clinica_id"]);
                })
                ->get();

        return  response()->json($adjuntos);
    }

    public function store(SaveAdjuntoRequest $request){
       
        $historiaClinicaAdjunto = new HistoriaClinicaAdjunto();
        $historiaClinicaAdjunto->historia_clinica_id = $request->historia_clinica_id;
        $path = $this->guardarArchivoAdjunto($request->file, $request->historia_clinica_id);
        
        $historiaClinicaAdjunto->path = $path;
        $historiaClinicaAdjunto->save();
        
        return response()->json($historiaClinicaAdjunto, 201);
    }

    public function guardarArchivoAdjunto($archivo, $historiaCliniaId){
        $nombreArchivo = $archivo->getClientOriginalName().'_'.$historiaCliniaId.'.'.$archivo->getClientOriginalExtension();
        $path = $archivo->storeAs('historias_clinicas', $nombreArchivo, 'public');
        return $path;
    }

    public function delete(Request $request, int $id){
        $adjunto = HistoriaClinicaAdjunto::find($id);
        if($adjunto){
            $adjunto->delete();
            return response()->json(["message" => "Registro eliminado"]);
        }else{
            return response()->json(["message" => "Registro no encontrado"], 404);
        }
        
    }

}
