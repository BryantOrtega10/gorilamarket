<?php

namespace App\Http\Requests\Reclutador;

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
            'cedula' => [
                'required',
                Rule::unique('reclutador','cedula')->ignore($this->cedula_ant,'cedula'),
            ],
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => [
                'required',
                Rule::unique('reclutador','email')->ignore($this->email_ant,'email'),
            ],
            'celular' => [
                'required',
                Rule::unique('users','email')->ignore($this->user_ant,'email'),
            ],
        ];
    }

    public function prepareForValidation()
    {
        if ($this->has('celular'))
            $this->merge(['celular'=>'*'.$this->celular.'*']);
    }
}
