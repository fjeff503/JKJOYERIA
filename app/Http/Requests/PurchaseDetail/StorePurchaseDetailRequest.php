<?php

namespace App\Http\Requests\PurchaseDetail;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseDetailRequest extends FormRequest
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
            'quantity'=>'required|integer',
            'price'=>'required|decimal',
            'idProduct'=>'required|integer|exists:App\Product,idProduct',
            'idPurchase'=>'required|integer|exists:App\Purchase,idPurchase'
        ];
    }

    public function messages(){
        //definimos los mensajes de error que nos mostrara
        return[
            'quantity.required'=>'Este campo es requerido.',
            'quantity.integer'=>'El valor del campo es incorrecto.',

            'price.required'=>'Este campo es requerido.',
            'price.decimal'=>'El valor del campo es incorrecto.',

            'idProduct.required'=>'Este campo es requerido.',
            'idProduct.integer'=>'El valor del campo es incorrecto.',
            'idProduct.exists'=>'El producto no existe.',

            'idPurchase.required'=>'Este campo es requerido.',
            'idPurchase.integer'=>'El valor del campo es incorrecto.',
            'idPurchase.exists'=>'La compra no existe.',

        ];
    }
}
