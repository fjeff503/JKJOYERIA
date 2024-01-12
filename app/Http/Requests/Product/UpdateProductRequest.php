<?php

namespace App\Http\Requests\DeliveryPoint;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDeliveryPointRequest extends FormRequest
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
            'codeProduct'=>'required|string|max:25',
            'codeProductProvider'=>'string|max:25',
            'name'=>'required|string|max:50',
            'sellPrice'=>'required|string|max:15',
            'stock'=>'required|integer',
            'description'=>'nullable|string|max:200',
            'idCategory'=>'required|integer',
            'idProvider'=>'required|integer'
        ];
    }

    public function messages(){
        //definimos los mensajes de error que nos mostrara
        return[
            'codeProduct.required'=>'El código del producto es requerido.',
            'codeProduct.string'=>'El valor del campo es incorrecto.',
            'codeProduct.max'=>'Solo se permite 25 caracteres.',

            'codeProductProvider.string'=>'El valor del campo es incorrecto.',
            'codeProductProvider.max'=>'Solo se permite 25 caracteres.',

            'name.required'=>'El nombre es requerido.',
            'name.string'=>'El valor del campo es incorrecto.',
            'name.max'=>'Solo se permite 50 caracteres.',
            'name.unique'=>'El producto ya se encuentra registrado.',

            'sellPrice.required'=>'El precio de venta es necesario.',
            'sellPrice.string'=>'El valor del campo es incorrecto.',
            'sellPrice.max'=>'Solo se permite 15 caracteres.',

            'stock.required'=>'El stock es requerido.',
            'stock.integer'=>'El valor del campo es incorrecto.',

            'description.string'=>'El valor del campo es incorrecto.',
            'description.max'=>'Solo se permite 200 caracteres.',

            'idCategory.required'=>'La categoría es requerida.',
            'idCategory.integer'=>'El valor del campo es incorrecto.',
            'idCategory.exists'=>'La categoría no existe.',

            'idProvider.required'=>'El proveedor es requerido.',
            'idProvider.integer'=>'El valor del campo es incorrecto.',
            'idProvider.exists'=>'El proveedor no existe.'
        ];
    }
}
