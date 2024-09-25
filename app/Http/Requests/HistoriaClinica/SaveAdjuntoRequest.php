<?php

namespace App\Http\Requests\HistoriaClinica;

use Illuminate\Foundation\Http\FormRequest;

class SaveAdjuntoRequest extends FormRequest
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
            "historia_clinica_id" => "required|exists:historias_clinicas,id",
            "file"  => "required|file"
        ];
    }
}
