<?php

namespace App\Http\Requests\Purchase;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePurchaseRequest extends FormRequest
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
            'total' => 'required|numeric|min:0',
            'voucher' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'idProvider' => 'required|integer|exists:providers,idProvider',
        ];
    }

    public function messages()
    {
        //definimos los mensajes de error que nos mostrara
        return [
            'total.required' => 'Este campo es requerido.',
            'total.numeric' => 'El valor debe ser un número válido.',
            'total.min' => 'El total no puede ser negativo.',

            'voucher.file' => 'Debe seleccionar un archivo válido.',
            'voucher.mimes' => 'Solo se permiten imágenes JPG, PNG o PDF.',
            'voucher.max' => 'El archivo no debe pesar más de 2MB.',

            'idProvider.required' => 'Este campo es requerido.',
            'idProvider.integer' => 'El valor del campo es incorrecto.',
            'idProvider.exists' => 'El proveedor no existe.',

        ];
    }
}
