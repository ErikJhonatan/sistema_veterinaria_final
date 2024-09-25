<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExamenAuxiliar\SaveExamenAuxiliarMascotaRequest;
use App\Models\ExamenAuxiliar;
use App\Models\ExamenAuxiliarMascota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamenAuxiliarMascotaController extends Controller
{
    public function index(Request $request) {
        $query = ExamenAuxiliarMascota::query();
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

    public function save(SaveExamenAuxiliarMascotaRequest $request){
  
        DB::beginTransaction();

        try {
            
            $actualizar = [];
            $crear = [];

            $historia_clinica_id = $request->historia_clinica_id;

            foreach($request->examen_auxiliar_mascota as $examen_auxiliar) {
                if(isset($examen_auxiliar["examen_auxiliar_mascota_id"])){
                    $actualizar[] = $examen_auxiliar;
                }else {
                    $crear[] = $examen_auxiliar;
                }
            }   

            
            foreach($actualizar as $examenAuxiliar){
                $examenAuxiliar = ExamenAuxiliarMascota::find($examenAuxiliar["examen_auxiliar_mascota_id"]);
                if($examenAuxiliar){
                    $examenAuxiliar->examen_auxiliar_id = $examenAuxiliar["examen_auxiliar_id"];
                    $examenAuxiliar->observacion = $examenAuxiliar["observacion"];
                    $examenAuxiliar->save();
                }
            }

            foreach($crear as $tratamiento){
                $nuevoExamenAuxiliar = new ExamenAuxiliarMascota();
                $nuevoExamenAuxiliar->examen_auxiliar_id = $tratamiento["examen_auxiliar_id"];
                $nuevoExamenAuxiliar->observacion = $tratamiento["observacion"];
                $nuevoExamenAuxiliar->mascota_id = $tratamiento["mascota_id"];
                $nuevoExamenAuxiliar->historia_clinica_id = $historia_clinica_id;
                $nuevoExamenAuxiliar->save();
            }

            $examenesAuxiliaresMascotas = ExamenAuxiliarMascota::with([
                                                    'examenAuxiliar'
                                                ])
                                                ->where("historia_clinica_id", $historia_clinica_id)
                                                ->get();

            } catch (\Throwable $th) {
                DB::rollback();
               
                return response()->json(["message" => "Error al guardar"], 500);
            }

            DB::commit();
            return response()->json($examenesAuxiliaresMascotas, 201);
    }


    public function delete($id){
        $examenAuxiliar = ExamenAuxiliarMascota::find($id);

        if(!$examenAuxiliar){
            return response()->json(["message" => "Examen auxiliar no encontrado"], 404);
        }

        $examenAuxiliar->delete();
    }

}
