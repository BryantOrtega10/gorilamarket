<?php

namespace App\Http\Requests\Domiciliario;

use Illuminate\Foundation\Http\FormRequest;

class CrearRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'cedula' => 'required',
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required|unique:domiciliario,email',
            'celular' => 'required',
            'usuario' => 'required|unique:users,email',
            'pass' => 'required',
            'rpass' => 'required|same:pass'
        ];
    }
}
