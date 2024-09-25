<?php

namespace App\Http\Requests\Tratamiento;

use Illuminate\Foundation\Http\FormRequest;

class SaveTratamientoMascotaRequest extends FormRequest
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
            "tratamientos"                              => "required|array",
            "tratamientos.*.mascota_id"                 => "required|integer|exists:mascotas,id",
            "tratamientos.*.producto_id"                => "required|integer|exists:productos,id",
            "tratamientos.*.observacion"                => "nullable|string",
            "tipo_historia_clinica_id"   => "required|integer|exists:tipos_historias_clinicas,id",
            "historia_clinica_id"        => "required|integer|exists:historias_clinicas,id"
        ];
    }
}
