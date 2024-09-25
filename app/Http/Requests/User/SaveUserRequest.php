<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class SaveUserRequest extends FormRequest
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
        $rules = [
            "name"      => "required|string",
            "rol_id"    => "required|exists:roles,id",
            "sede_id"   => "required|exists:sedes,id",
        ];

        if($this->method() == "POST"){
            $rules["email"] = "required|string|email|unique:users,email";
            $rules["password"] = "required|string";
        } else {
            $rules["password"] = "nullable|string";
        }

        return $rules;
       
    }
}
