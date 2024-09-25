<?php

namespace App\Http\Requests\ExamenAuxiliar;

use Illuminate\Foundation\Http\FormRequest;

class SaveExamenAuxiliarMascotaRequest extends FormRequest
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
        return [
            "examen_auxiliar_mascota"                       => "required|array",
            "examen_auxiliar_mascota.*.mascota_id"          => "required|integer|exists:mascotas,id",
            "examen_auxiliar_mascota.*.examen_auxiliar_id"  => "required|integer|exists:examenes_auxiliares,id",
            "examen_auxiliar_mascota.*.observacion"         => "nullable|string",
            "tipo_historia_clinica_id"                      => "required|integer|exists:tipos_historias_clinicas,id",
            "historia_clinica_id"                           => "required|integer|exists:historias_clinicas,id"
        ];
    }
}
