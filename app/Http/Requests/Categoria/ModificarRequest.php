<?php

namespace App\Http\Requests\Categoria;

use Illuminate\Foundation\Http\FormRequest;

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
            'm_nombre' => 'required',
            'm_tipo' => 'required',
            'm_padre_gen' => 'required_if:tipo,2'
        ];
    }

    public function messages(): array
    {
        return [
            'm_nombre.required' => 'El nombre es obligatorio',
            'm_tipo.required' => 'El tipo es obligatorio',
            'm_padre_gen.required_if' => 'Seleccione la categoria general'
        ];
    }
}
