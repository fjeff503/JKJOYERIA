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
            'date' => 'required|datetime',
            'total' => 'required|decimal',
            'voucher' => 'required|string|max:150',
            'idProvider' => 'required|integer|exists:App\Provider,idProvider',
            'idUser' => 'required|integer|exists:App\User,idUser'
        ];
    }

    public function messages()
    {
        //definimos los mensajes de error que nos mostrara
        return [
            'date.required' => 'Este campo es requerido.',
            'date.datetime' => 'El valor del campo es incorrecto.',

            'total.required' => 'Este campo es requerido.',
            'total.decimal' => 'El valor del campo es incorrecto.',

            'voucher.required' => 'Este campo es requerido.',
            'voucher.string' => 'El valor del campo es incorrecto.',
            'voucher.max' => 'Solo se permite 150 caracteres.',

            'idProvider.required' => 'Este campo es requerido.',
            'idProvider.integer' => 'El valor del campo es incorrecto.',
            'idProvider.exists' => 'El proveedor no existe.',

            'idUser.required' => 'Este campo es requerido.',
            'idUser.integer' => 'El valor del campo es incorrecto.',
            'idUser.exists' => 'El usuario no existe.',

        ];
    }
}
