<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CuponesRequest extends FormRequest
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
            'cupon' => 'required',
            'no_cupones' => 'required',
            'valor' => 'required|min:0',
            'tipoValor' => 'required',
            'apFechas' => 'nullable',
            'fecha_inicio' => 'required_if:apFechas,1',
            'fecha_fin' => 'required_if:apFechas,1',
            'apPrecio' => 'nullable',
            'precioMin' => 'required_if:apPrecio,1',
            'precioMax' => 'required_if:apPrecio,1',
        ];
    }
}
