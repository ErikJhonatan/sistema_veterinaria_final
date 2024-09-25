<?php

namespace App\Http\Controllers;

use App\Http\Requests\HistoriaClinica\SaveHistoriaClinicaRequest;
use App\Models\Diagnostico;
use App\Models\DiagnosticoMascota;
use App\Models\ExamenAuxiliar;
use App\Models\ExamenAuxiliarMascota;
use App\Models\HistoriaClinica;
use App\Models\HistoriaClinicaAdjunto;
use App\Models\Producto;
use App\Models\TipoHistoriaClinica;
use App\Models\TratamientoMascota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoriaClinicaController extends Controller
{
    const RELACIONES_MASCOTA = [
        'tipoHistoriaClinica',
        'tratamientoMascota.producto',
        'vacunas.producto',
        'antiparasitarios.producto',
        'antipulgas.producto',
        'examenAuxiliarMascota.examenAuxiliar',
        'diagnosticoMascota.diagnostico'
    ];

    public function findAll(Request $request){
        if(!$request->mascota_id){
            return response()->json(["message" => "Mascota no encontrada"], 404);
        }
        $historiasClinicas = HistoriaClinica::with(self::RELACIONES_MASCOTA)
        ->when(isset($request->mascota_id), function($query) use ($request){
            $query->where('idMascota', $request->mascota_id);
        })
        ->orderBy("created_at", 'desc')
        ->get();
        return response()->json($historiasClinicas, 200);
    }
  
    public function store(SaveHistoriaClinicaRequest $request){
        
       
        DB::beginTransaction();
        try {
            
            $historiaClinica = new HistoriaClinica();
            $historiaClinica->idMascota = $request->idMascota;
            $historiaClinica->tipo_historia_clinica_id = $request->tipo_historia_clinica_id;
            $historiaClinica->descripcion = $request->descripcion;
            $historiaClinica->temperatura = $request->temperatura;
            $historiaClinica->peso = $request->peso;
            $historiaClinica->presion_arterial = $request->presion_arterial;
            $historiaClinica->frecuencia_cardiaca = $request->frecuencia_cardiaca;
            $historiaClinica->porcentaje_deshidratacion = $request->porcentaje_deshidratacion;
            $historiaClinica->examen_tacto_rectal = $request->examen_tacto_rectal;
            $historiaClinica->frecuencia_respiratoria = $request->frecuencia_respiratoria;
            $historiaClinica->tiempo_llenado_capilar = $request->tiempo_llenado_capilar;
            $historiaClinica->examen_clinico = $request->examen_clinico;
            $historiaClinica->conformidad_pago = $request->conformidad_pago;
            $historiaClinica->documentacion_firmada = $request->documentacion_firmada;
            $historiaClinica->riesgo_quirurgico = $request->riesgo_quirurgico;
            $historiaClinica->miccion = $request->miccion;
            $historiaClinica->deposicion = $request->deposicion;
            $historiaClinica->ayuno_previo = $request->ayuno_previo;
            
            $historiaClinica->motivo_atencion = $request->motivo_atencion;
            $historiaClinica->fecha_atencion = $request->fecha_atencion;
            $historiaClinica->nombre_cirugia = $request->nombre_cirugia;
            

            $historiaClinica->save();

            if($request->diagnosticos_mascotas){
                foreach($request->diagnosticos_mascotas as $diagnostico){
                    DiagnosticoMascota::insert([
                        "mascota_id" => $request->idMascota,
                        "diagnostico_id" => $diagnostico["diagnostico_id"],
                        "historia_clinica_id" => $historiaClinica->id,
                        "observacion" => isset($diagnostico["observacion"]) ? $diagnostico["observacion"] : null    
                    ]);

                }
            }

            if($request->examenes_auxiliares_mascotas){
                foreach($request->examenes_auxiliares_mascotas as $examen){
       
                ExamenAuxiliarMascota::insert([
                    "mascota_id" => $request->idMascota,
                    "examen_auxiliar_id" => $examen["examen_auxiliar_id"],
                    "historia_clinica_id" => $historiaClinica->id,
                    "observacion" => isset($examen["observacion"]) ? $examen["observacion"] : null
                ]); 
                }
            }

            if($request->tratamientos){
                foreach($request->tratamientos as $tratamiento){
                    TratamientoMascota::insert([
                        "mascota_id" => $request->idMascota,
                        "producto_id" => $tratamiento["producto_id"],
                        "observacion" => isset($tratamiento["observacion"]) ? $tratamiento["observacion"] : null,
                        "historia_clinica_id" => $historiaClinica->id,
                        "tipo_historia_clinica_id" => TipoHistoriaClinica::TRATAMIENTO
                    ]);
                }
            }

            if($request->vacunas){
                foreach($request->vacunas as $vacuna){
                    TratamientoMascota::insert([
                        "mascota_id" => $request->idMascota,
                        "producto_id" => $vacuna["producto_id"],
                        "observacion" => isset($vacuna["observacion"]) ? $vacuna["observacion"] : null,
                        "historia_clinica_id" => $historiaClinica->id,
                        "tipo_historia_clinica_id" => TipoHistoriaClinica::VACUNA

                    ]);
                }
            }

            if($request->anti_parasitarios){
                foreach($request->anti_parasitarios as $anti){
                    TratamientoMascota::insert([
                        "mascota_id" => $request->idMascota,
                        "producto_id" => $anti["producto_id"],
                        "observacion" => isset($anti["observacion"]) ? $anti["observacion"] : null,
                        "historia_clinica_id" => $historiaClinica->id,
                        "tipo_historia_clinica_id" => TipoHistoriaClinica::ANTIPARASITARIO
                    ]);
                }
            }

            if($request->anti_pulgas){
                foreach($request->anti_pulgas as $anti){
                    TratamientoMascota::insert([
                        "mascota_id" => $request->idMascota,
                        "producto_id" => $anti["producto_id"],
                        "observacion" => isset($anti["observacion"]) ? $anti["observacion"] : null,
                        "tipo_historia_clinica_id" => TipoHistoriaClinica::ANTIPULGAS,
                        "historia_clinica_id" => $historiaClinica->id,
                    ]);
                }
            }

            if($request->adjuntos){

                foreach($request->adjuntos as $adjunto){
                    $historiaClinicaAdjunto = new HistoriaClinicaAdjunto();
                    $historiaClinicaAdjunto->historia_clinica_id = $historiaClinica->id;
                    $path = $this->guardarArchivoAdjunto($adjunto, $historiaClinica->id);
                    $historiaClinicaAdjunto->path = $path;
                    $historiaClinicaAdjunto->save();
                }
            }

        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(["message" => "Error al guardar la historia clinica"], 500);
        }

        DB::commit();
        return response()->json($historiaClinica->load(self::RELACIONES_MASCOTA), 201);
   
        // todo
        // si viene sala de espera guardar en sala de espera
        // si viene evento guardar en eventos
    }

    public function guardarArchivoAdjunto($archivo, $historiaCliniaId){
        $nombreArchivo = $archivo->getClientOriginalName().'_'.$historiaCliniaId.'.'.$archivo->getClientOriginalExtension();
        $path = $archivo->storeAs('historias_clinicas', $nombreArchivo, 'public');
        return $path;
    }

    public function update(SaveHistoriaClinicaRequest $request, $id) {

        $historiaClinica = HistoriaClinica::find($id);
        if(!$historiaClinica){
            return response()->json(["message" => "Historia Clinica no encontrada"], 404);
        }

        DB::beginTransaction();
        try {
        
            $historiaClinica->idMascota = $request->idMascota ?? $historiaClinica->idMascota;
            $historiaClinica->tipo_historia_clinica_id = $request->tipo_historia_clinica_id ?? $historiaClinica->tipo_historia_clinica_id;
            $historiaClinica->descripcion = $request->descripcion ?? $historiaClinica->descripcion;
            $historiaClinica->temperatura = $request->temperatura ?? $historiaClinica->temperatura;
            $historiaClinica->peso = $request->peso ?? $historiaClinica->peso;
            $historiaClinica->presion_arterial = $request->presion_arterial ?? $historiaClinica->presion_arterial;
            $historiaClinica->frecuencia_cardiaca = $request->frecuencia_cardiaca ?? $historiaClinica->frecuencia_cardiaca;
            $historiaClinica->porcentaje_deshidratacion = $request->porcentaje_deshidratacion ?? $historiaClinica->porcentaje_deshidratacion;
            $historiaClinica->examen_tacto_rectal = $request->examen_tacto_rectal ?? $historiaClinica->examen_tacto_rectal;
            $historiaClinica->frecuencia_respiratoria = $request->frecuencia_respiratoria ?? $historiaClinica->frecuencia_respiratoria;
            $historiaClinica->tiempo_llenado_capilar = $request->tiempo_llenado_capilar ?? $historiaClinica->tiempo_llenado_capilar;
            $historiaClinica->examen_clinico = $request->examen_clinico ?? $historiaClinica->examen_clinico;
            $historiaClinica->conformidad_pago = $request->conformidad_pago ?? $historiaClinica->conformidad_pago;
            $historiaClinica->documentacion_firmada = $request->documentacion_firmada ?? $historiaClinica->documentacion_firmada;
            $historiaClinica->riesgo_quirurgico = $request->riesgo_quirurgico ?? $historiaClinica->riesgo_quirurgico;
            $historiaClinica->miccion = $request->miccion ?? $historiaClinica->miccion;
            $historiaClinica->deposicion = $request->deposicion ?? $historiaClinica->deposicion;
            $historiaClinica->ayuno_previo = $request->ayuno_previo ?? $historiaClinica->ayuno_previo;
            $historiaClinica->motivo_atencion = $request->motivo_atencion ?? $historiaClinica->motivo_atencion;
            $historiaClinica->fecha_atencion = $request->fecha_atencion ?? $historiaClinica->fecha_atencion;
            $historiaClinica->nombre_cirugia = $request->nombre_cirugia ?? $historiaClinica->nombre_cirugia;
            
            $historiaClinica->save();

        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(["message" => "Error al guardar la historia clinica"], 500);
        }

        DB::commit();
        return response()->json($historiaClinica->load(self::RELACIONES_MASCOTA), 201);
    }

    public function delete($id){
        $historiaClinica = HistoriaClinica::find($id);
        if(!$historiaClinica){
            return response()->json(["message" => "Historia Clinica no encontrada"], 404);
        }
        $this->eliminarDiagnosticosMascotasPorHistorialClinicaId($historiaClinica->id);
        $this->eliminarExamenesAuxiliaresMascotasPorHistorialClinicaId($historiaClinica->id);
        $this->eliminarTratamientosMascotasPorHistorialClinicaId($historiaClinica->id);
        $historiaClinica->delete();
        return response()->json(["message" => "Historia Clinica eliminada"], 200);
    }

    private function eliminarDiagnosticosMascotasPorHistorialClinicaId($historiaClinicaId){
        DiagnosticoMascota::where('historia_clinica_id', $historiaClinicaId)->delete();
    }

    private function eliminarExamenesAuxiliaresMascotasPorHistorialClinicaId($historiaClinicaId){
        ExamenAuxiliarMascota::where('historia_clinica_id', $historiaClinicaId)->delete();
    }

    private function eliminarTratamientosMascotasPorHistorialClinicaId($historiaClinicaId){
        TratamientoMascota::where('historia_clinica_id', $historiaClinicaId)->delete();
    }
    

}