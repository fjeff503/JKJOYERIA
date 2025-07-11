<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'codeProductProvider' => 'string|max:25',
            'name' => 'required|string|max:50',
            'sellPrice' => 'required|numeric|min:0|max:9999.99',
            'buyPrice' => 'required|numeric|min:0|max:9999.99',
            'stock' => 'required|integer',
            'description' => 'nullable|string|max:200',
            'idCategory' => 'required|integer',
            'idProvider' => 'required|integer'
        ];
    }

    public function messages()
    {
        //definimos los mensajes de error que nos mostrara
        return [
            'codeProductProvider.string' => 'El valor del campo es incorrecto.',
            'codeProductProvider.max' => 'Solo se permite 25 caracteres.',

            'name.required' => 'El nombre es requerido.',
            'name.string' => 'El valor del campo es incorrecto.',
            'name.max' => 'Solo se permite 50 caracteres.',
            'name.unique' => 'El producto ya se encuentra registrado.',

            'sellPrice.required' => 'El precio de venta es necesario.',
            'sellPrice.numeric' => 'El precio de venta debe ser un número válido.',
            'sellPrice.min' => 'El precio de venta no puede ser negativo.',
            'sellPrice.max' => 'El precio de venta excede el valor máximo permitido.',
                    
            'buyPrice.required' => 'El precio de compra es necesario.',
            'buyPrice.numeric' => 'El precio de compra debe ser un número válido.',
            'buyPrice.min' => 'El precio de compra no puede ser negativo.',
            'buyPrice.max' => 'El precio de compra excede el valor máximo permitido.',

            'stock.required' => 'El stock es requerido.',
            'stock.integer' => 'El valor del campo es incorrecto.',

            'description.string' => 'El valor del campo es incorrecto.',
            'description.max' => 'Solo se permite 200 caracteres.',

            'idCategory.required' => 'La categoría es requerida.',
            'idCategory.integer' => 'El valor del campo es incorrecto.',
            'idCategory.exists' => 'La categoría no existe.',

            'idProvider.required' => 'El proveedor es requerido.',
            'idProvider.integer' => 'El valor del campo es incorrecto.',
            'idProvider.exists' => 'El proveedor no existe.'
        ];
    }
}
