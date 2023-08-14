<?php

namespace App\Http\Requests\Administrador;

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
            'nombre' => 'required',
            'usuario' => [
                'required',
                Rule::unique('users','email')->ignore($this->user_ant,'email'),
            ],
            'pass' => 'nullable',
            'rpass' => 'required_with:pass|same:pass'
        ];
    }
}
