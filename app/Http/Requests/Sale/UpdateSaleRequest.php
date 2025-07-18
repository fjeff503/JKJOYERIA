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
            'total' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:255',
            'idClient' => 'required|integer|exists:clients,idClient',
            'idPackageState' => 'required|integer|exists:package_states,idPackageState',
            'idPaymentState' => 'required|integer|exists:payment_states,idPaymentState',
            'idDeliveryPoint' => 'required|integer|exists:delivery_points,idDeliveryPoint',
        ];
    }

    public function messages()
    {
        //definimos los mensajes de error que nos mostrara
        return [
            // TOTAL
            'total.required' => 'El campo Total es obligatorio.',
            'total.decimal' => 'El Total debe ser un número decimal válido.',
            'total.min' => 'El Total no puede ser negativo.',

            // DESCRIPTION
            'description.string' => 'La descripción debe ser un texto válido.',
            'description.max' => 'La descripción no debe exceder los 255 caracteres.',

            // CLIENT
            'idClient.required' => 'Debe seleccionar un cliente.',
            'idClient.integer' => 'El cliente seleccionado no es válido.',
            'idClient.exists' => 'El cliente seleccionado no existe en la base de datos.',

            // PACKAGESTATE
            'idPackageState.required' => 'Debe seleccionar un estado de paquete.',
            'idPackageState.integer' => 'El estado de paquete seleccionado no es válido.',
            'idPackageState.exists' => 'El estado de paquete seleccionado no existe en la base de datos.',

            // PAYMENTSTATE
            'idPaymentState.required' => 'Debe seleccionar un estado de pago.',
            'idPaymentState.integer' => 'El estado de pago seleccionado no es válido.',
            'idPaymentState.exists' => 'El estado de pago seleccionado no existe en la base de datos.',

            // DELIVERYPOINT
            'idDeliveryPoint.required' => 'Debe seleccionar un punto de entrega.',
            'idDeliveryPoint.integer' => 'El punto de entrega seleccionado no es válido.',
            'idDeliveryPoint.exists' => 'El punto de entrega seleccionado no existe en la base de datos.',

        ];
    }
}
