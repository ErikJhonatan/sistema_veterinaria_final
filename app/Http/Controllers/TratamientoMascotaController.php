<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tratamiento\SaveTratamientoMascotaRequest;
use App\Models\TratamientoMascota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TratamientoMascotaController extends Controller
{
    public function index(Request $request) {

        $query = TratamientoMascota::query();
        $parametros = $request->all();

        $query = $query
                    ->when(isset($parametros["mascota_id"]), function($q) use($parametros){
                        return $q->where("mascota_id", $parametros["mascota_id"]);
                    })
                    ->when(isset($parametros["categoria_id"]), function($q) use($parametros){
                        return $q->where("categoria_id", $parametros["categoria_id"]);
                    })
                    ->when(isset($parametros["historia_clinica_id"]), function($q) use($parametros){
                        return $q->where("historia_clinica_id", $parametros["historia_clinica_id"]);
                    });

        return isset($parametros["page"]) ? $query->paginate() : $query->get();
    }

    public function save(SaveTratamientoMascotaRequest $request){

        DB::beginTransaction();
        try {
            


        $actualizar = [];
        $crear = [];

        $tipo_historia_clinica_id = $request->tipo_historia_clinica_id;
        $historia_clinica_id = $request->historia_clinica_id;
 
        foreach($request->tratamientos as $tratamiento) {
            if(isset($tratamiento["tratamiento_id"])){
                $actualizar[] = $tratamiento;
            }else {
                $crear[] = $tratamiento;
            }
        }

        foreach($actualizar as $tratamiento){
            $tratamientoMascota = TratamientoMascota::find($tratamiento["tratamiento_id"]);
            if($tratamientoMascota){
                $tratamientoMascota->producto_id = $tratamiento["producto_id"];
                $tratamientoMascota->observacion = $tratamiento["observacion"];
                $tratamientoMascota->save();
            }
        }

        foreach($crear as $tratamiento){
            $nuevoTratamiento = new TratamientoMascota();
            $nuevoTratamiento->producto_id = $tratamiento["producto_id"];
            $nuevoTratamiento->observacion = $tratamiento["observacion"];
            $nuevoTratamiento->mascota_id = $tratamiento["mascota_id"];
            $nuevoTratamiento->historia_clinica_id = $historia_clinica_id;
            $nuevoTratamiento->tipo_historia_clinica_id = $tipo_historia_clinica_id;
            $nuevoTratamiento->save();
        }

        $tratamientos = TratamientoMascota::with([
                                            'producto',
                                            
                                                ])
                                            ->where("historia_clinica_id", $historia_clinica_id)
                                            ->where("tipo_historia_clinica_id" , $tipo_historia_clinica_id)
                                            ->get();

        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(["message" => "Error al guardar"], 500);
        }

        DB::commit();
        
        return response()->json($tratamientos, 201);
    }

    
    public function delete($id){
        $tratamiento = TratamientoMascota::find($id);

        if(!$tratamiento){
            return response()->json(["message" => "Tratamiento no encontrado"], 404);
        }

        $tratamiento->delete();
    }
}
