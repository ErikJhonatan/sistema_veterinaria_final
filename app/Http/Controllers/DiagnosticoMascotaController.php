<?php

namespace App\Http\Controllers;

use App\Http\Requests\Diagnostico\SaveDiagnosticoMascotaRequest;
use App\Models\DiagnosticoMascota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiagnosticoMascotaController extends Controller
{

    public function index(Request $request) {
        
        $query = DiagnosticoMascota::query();
        $parametros = $request->all();

        $query = $query
                    ->when(isset($parametros["mascota_id"]), function($q) use($parametros){
                        return $q->where("mascota_id", $parametros["mascota_id"]);
                    })
                    ->when(isset($parametros["historia_clinica_id"]), function($q) use($parametros){
                        return $q->where("historia_clinica_id", $parametros["historia_clinica_id"]);
                    });

        return isset($parametros["page"]) ? $query->paginate() : $query->get();
    } 


    public function save(SaveDiagnosticoMascotaRequest $request){

        DB::beginTransaction();

        try {
            $actualizar = [];
            $crear = [];

            $historia_clinica_id = $request->historia_clinica_id;

            foreach($request->diagnostico_mascota as $diagnostico) {
                if(isset($diagnostico["diagnostico_mascota_id"])){
                    $actualizar[] = $diagnostico;
                }else {
                    $crear[] = $diagnostico;
                }
            }

            foreach($actualizar as $diagnostico){
                $diagnostico = DiagnosticoMascota::find($diagnostico["diagnostico_mascota_id"]);
                if($diagnostico){
                    $diagnostico->diagnostico_id = $diagnostico["diagnostico_id"];
                    $diagnostico->observacion = $diagnostico["observacion"];
                    $diagnostico->save();
                }
            }

            foreach($crear as $diagnostico){
                $nuevoDiagnostico = new DiagnosticoMascota();
                $nuevoDiagnostico->diagnostico_id = $diagnostico["diagnostico_id"];
                $nuevoDiagnostico->observacion = $diagnostico["observacion"];
                $nuevoDiagnostico->mascota_id = $diagnostico["mascota_id"];
                $nuevoDiagnostico->historia_clinica_id = $historia_clinica_id;
                $nuevoDiagnostico->save();
            }

            $diagnosticosMascotas = DiagnosticoMascota::with([
                'diagnostico'
            ])
            ->where("historia_clinica_id", $historia_clinica_id)
            ->get();

        
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(["message" => "Error al guardar"], 500);
        }

        DB::commit();
        return response()->json($diagnosticosMascotas, 201);
       
    }

    public function delete($id){
        $diagnostico = DiagnosticoMascota::find($id);

        if(!$diagnostico){
            return response()->json(["message" => "Diagnostico no encontrado"], 404);
        }

        $diagnostico->delete();
    }
}
