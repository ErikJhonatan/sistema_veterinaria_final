<?php

namespace App\Http\Requests\Evento;

use Illuminate\Foundation\Http\FormRequest;

class SaveEventoRequest extends FormRequest
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
            "idCliente"         => "required|exists:clientes,id",
            "idUsuario"         => "required|exists:users,id",
            "idNotificacion"    => "required",
            "idEstadoEvento"    => "required|exists:estados_eventos,id",
            "Evento"            => "required|string",
            "FechaInicio"       => "required|date",
            "FechaFin"          => "required|date",
            "Observacion"       => "nullable|string",
            "idMascota"         => "required|exists:mascotas,id",
            "idTipoEvento"      => "required|exists:tipos_eventos,id",
            "usuarioAutenticadoId" => "required|exists:users,id",
        ];
    }
}
