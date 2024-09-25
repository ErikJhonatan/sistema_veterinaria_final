<?php

namespace App\Http\Requests\Diagnostico;

use Illuminate\Foundation\Http\FormRequest;

class SaveDiagnosticoMascotaRequest extends FormRequest
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
            "diagnostico_mascota"                           => "required|array",
            "diagnostico_mascota.*.diagnostico_id"          => "required|integer|exists:diagnosticos,id",
            "diagnostico_mascota.*.observacion"             => "nullable|string",
            "historia_clinica_id"                           => "required|integer|exists:historias_clinicas,id"
        ];

       
    }
}
