<?php

namespace App\Http\Requests\Reclutador;

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
            'cedula' => 'required|unique:reclutador,cedula',
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required|unique:reclutador,email',
            'celular' => 'required|unique:users,email'
        ];
    }


    public function prepareForValidation()
    {
        if ($this->has('celular'))
            $this->merge(['celular'=>'*'.$this->celular.'*']);
    }
}
