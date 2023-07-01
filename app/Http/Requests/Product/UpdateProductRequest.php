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
            //para la imagen ver video 4 min 15
            'codeProductProvider'=>'required|string|unique:products,codeProductProvider'.$this->route('product')->id.'|max:10',
            'name'=>'required|string|unique:products,name'.$this->route('product')->id.'|max:50',
            'sellPrice'=>'required|double',
            'description'=>'required|string|max:500',
            'idCategory'=>'required|integer|exists:App\Category,id',
            'idProvider'=>'required|integer|exists:App\Provider,id'
        ];
    }

    public function messages(){
        //definimos los mensajes de error que nos mostrara
        return[
            'codeProductProvider.required'=>'Este campo es requerido.',
            'codeProductProvider.string'=>'El valor del campo es incorrecto.',
            'codeProductProvider.max'=>'Solo se permite 10 caracteres.',
            'codeProductProvider.unique'=>'El codigo ya se encuentra registrado.',

            'name.required'=>'Este campo es requerido.',
            'name.string'=>'El valor del campo es incorrecto.',
            'name.max'=>'Solo se permite 50 caracteres.',
            'name.unique'=>'El nombre ya se encuentra registrado.',

            'sellPrice.required'=>'Este campo es requerido.',
            'sellPrice.double'=>'El valor del campo es incorrecto.',

            'description.required'=>'Este campo es requerido.',
            'description.integer'=>'El valor del campo es incorrecto.',
            'description.exists'=>'Solo se permite 500 caracteres.',

            'idCategory.required'=>'Este campo es requerido.',
            'idCategory.string'=>'El valor del campo es incorrecto.',
            'idCategory.max'=>'La categoria no existe.',

            'idProvider.required'=>'Este campo es requerido.',
            'idProvider.string'=>'El valor del campo es incorrecto.',
            'idProvider.max'=>'El proveedor no existe.',
        ];
    }
}
