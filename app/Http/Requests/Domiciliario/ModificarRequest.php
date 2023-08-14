<?php

namespace App\Http\Requests\Domiciliario;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ModificarRequest extends FormRequest
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
            'email' => [
                'required',
                Rule::unique('domiciliario','email')->ignore($this->email_ant,'email'),
            ],
            'celular' => 'required',
            'usuario' => [
                'required',
                Rule::unique('users','email')->ignore($this->user_ant,'email'),
            ],
            'pass' => 'nullable',
            'rpass' => 'required_with:pass|same:pass'
        ];
    }
}
