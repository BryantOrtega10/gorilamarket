<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PromocionRequest extends FormRequest
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
            'fk_producto' => 'required',
            'porcentaje' => 'required',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required'
        ];
    }
}
