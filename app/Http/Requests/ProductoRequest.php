<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoRequest extends FormRequest
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
            'descripcion' => 'required',
            'precio' => 'required',
            'unidades' => 'required',
            'destacado' => 'required',
            'fk_categorias' => 'required',
            'cd_barras' => 'required',
            'orden' => 'required'
        ];
    }
}
