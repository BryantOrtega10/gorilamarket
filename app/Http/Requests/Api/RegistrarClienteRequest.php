<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegistrarClienteRequest extends FormRequest
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
            'apellido' => 'required',
            'correo' => 'required|email:rfc,dns|unique:cliente,email',
            'celular' => 'required|unique:users,email',
            'distribuidor' => 'nullable',
            'rut' => 'required_with:distribuidor'
        ];
    }


    public function prepareForValidation()
    {
        if ($this->has('celular'))
            $this->merge(['celular'=>'*'.$this->celular.'*']);
    }
}
