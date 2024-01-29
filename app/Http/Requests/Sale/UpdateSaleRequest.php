<?php

namespace App\Http\Requests\Sale;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSaleRequest extends FormRequest
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
            'description' => 'required|string|max:255',
            'idPackageState' => 'required|integer|exists:App\PackageState,idPackageState',
            'idPaymentState' => 'required|integer|exists:App\PaymentState,idPaymentState',
            'idClient' => 'required|integer|exists:App\Client,idClient',
            'idDeliveryPoint' => 'required|integer|exists:App\DeliveryPoint,idDeliveryPoint',
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

            'description.required' => 'Este campo es requerido.',
            'description.string' => 'El valor del campo es incorrecto.',
            'description.max' => 'Solo se permite 255 caracteres.',

            'idPackageState.required' => 'Este campo es requerido.',
            'idPackageState.integer' => 'El valor del campo es incorrecto.',
            'idPackageState.exists' => 'El estado del paquete no existe.',

            'idPaymentState.required' => 'Este campo es requerido.',
            'idPaymentState.integer' => 'El valor del campo es incorrecto.',
            'idPaymentState.exists' => 'El estado de pago no existe.',

            'idClient.required' => 'Este campo es requerido.',
            'idClient.integer' => 'El valor del campo es incorrecto.',
            'idClient.exists' => 'El cliente no existe.',

            'idDeliveryPoint.required' => 'Este campo es requerido.',
            'idDeliveryPoint.integer' => 'El valor del campo es incorrecto.',
            'idDeliveryPoint.exists' => 'El destino no existe.',

            'idUser.required' => 'Este campo es requerido.',
            'idUser.integer' => 'El valor del campo es incorrecto.',
            'idUser.exists' => 'El usuario no existe.',

        ];
    }
}
