<?php
namespace App\Http\Requests\Contabilidad;
use Illuminate\Foundation\Http\FormRequest;

class GastoStoreRequest extends FormRequest
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
            // fecha antes de o igual a la fecha actual
            'anio' => 'required|integer|min:2024',
            'tipo_transaccion' => 'required|string|in:gasto_personal,gasto_servicio,gasto_impuesto',
            // servicio obligatorio si el tipo de transaccion es gasto_servicio
            'servicio' => 'required_if:tipo_transaccion,gasto_servicio|string|in:luz,agua,internet,alquiler,maquinaria,equipo',
            'fecha' => 'required|date|before_or_equal:now',
            'monto' => 'required|numeric|min:0.01',
            'forma_pago' => 'required|string|in:efectivo,transferencia',
            'concepto' => 'required|string'
        ];
    }
}
