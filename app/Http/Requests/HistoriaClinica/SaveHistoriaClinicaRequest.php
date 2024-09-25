<?php

namespace App\Http\Requests\HistoriaClinica;

use App\Models\TipoHistoriaClinica;
use Illuminate\Foundation\Http\FormRequest;

class SaveHistoriaClinicaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules =  [
            "idMascota" => "required|integer|exists:mascotas,id",
            "tipo_historia_clinica_id"  => "required|integer|exists:tipos_historias_clinicas,id",
            "descripcion" => "nullable|string",
            "temperatura" => "nullable|string",
            "peso" => "nullable|string",
            "presion_arterial" => "nullable|string",
            "frecuencia_cardiaca" => "nullable|string",
            "porcentaje_deshidratacion" => "nullable|string",
            "examen_tacto_rectal" => "nullable|string",
            "frecuencia_respiratoria" => "nullable|string",
            "tiempo_llenado_capilar" => "nullable|string",
            "examen_clinico" => "nullable|string",
            "conformidad_pago" => "nullable|bool",
            "documentacion_firmada" => "nullable|bool",
            "riesgo_quirurgico" =>  "nullable|bool",
            "miccion" => "nullable|bool",
            "deposicion" => "nullable|bool",
            "ayuno_previo" => "nullable|bool",
            "motivo_atencion" => "nullable|string",

        ];
        if($this->method() == "POST"){
            $rules = array_merge($rules, $this->agregarReglas());
        }

        return $rules;
    }

    public function agregarReglas () {
        return [
            "diagnosticos_mascotas" => "nullable|array",
            "diagnosticos_mascotas.*.diagnostico_id" => "required_with:diagnosticos_mascotas|exists:diagnosticos,id",
            "diagnosticos_mascotas.*.observacion" => "nullable|string",
            
            "examenes_auxiliares_mascotas" => "nullable|array",
            "examenes_auxiliares_mascotas.*.mascota_id" => "required_with:examenes_auxiliares_mascotas|exists:mascotas,id",
            "examenes_auxiliares_mascotas.*.examen_auxiliar_id" => "required_with:examenes_auxiliares_mascotas|exists:examenes_auxiliares,id",
            "examenes_auxiliares_mascotas.*.observacion" => "nullable|string",

            "tratamientos" => "nullable|array",
            "tratamientos.*.producto_id" => "required_with:tratamientos|exists:productos,id",
            "tratamientos.*.observacion" => "nullable|string",
            "tratamientos.*.cantidad" => "numeric",

            "vacunas" => "nullable|array",
            "vacunas.*.producto_id" => "required_with:vacunas|exists:productos,id",
            "vacunas.*.observacion" => "nullable|string",
            "vacunas.*.cantidad" => "numeric",
            
            "anti_parasitarios" => "nullable|array",
            "anti_parasitarios.*.producto_id" => "required_with:anti_parasitarios|exists:productos,id",
            "anti_parasitarios.*.observacion" => "nullable|string",
            "anti_parasitarios.*.cantidad" => "numeric",

            "anti_pulgas" => "nullable|array",
            "anti_pulgas.*.producto_id" => "required_with:anti_pulgas|exists:productos,id",
            "anti_pulgas.*.observacion" => "nullable|string",
            "anti_pulgas.*.cantidad" => "numeric",
        ];
    }

    
}
