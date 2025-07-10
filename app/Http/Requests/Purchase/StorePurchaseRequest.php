<?php

namespace App\Http\Requests\Purchase;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseRequest extends FormRequest
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
            // TOTAL
            'total.required' => 'El campo Total es obligatorio.',
            'total.numeric' => 'El Total debe ser un número válido.',
            'total.min' => 'El Total no puede ser negativo.',
            
            // VOUCHER
            'voucher.file' => 'El comprobante debe ser un archivo.',
            'voucher.mimes' => 'El comprobante debe ser un archivo JPG, PNG o PDF.',
            'voucher.max' => 'El comprobante no debe superar los 2MB.',
            
            // IDPROVIDER
            'idProvider.required' => 'Debe seleccionar un proveedor.',
            'idProvider.integer' => 'El proveedor seleccionado no es válido.',
            'idProvider.exists' => 'El proveedor seleccionado no existe en la base de datos.',
        ];
    }
}
