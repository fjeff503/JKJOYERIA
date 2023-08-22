<?php

namespace App\Http\Requests\PaymentState;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePaymentStateRequest extends FormRequest
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
            'name' => [
                'required',
                Rule::unique('payment_states', 'name')->whereNull('deleted_at'),
                'string',
                'max:15',
            ],
            'description' => 'nullable|string|max:250'
        ];
    }

    public function messages(){
        //definimos los mensajes de error que nos mostrara
        return [
            'name.required' => 'Este campo es requerido.',
            'name.string' => 'El valor del campo es incorrecto.',
            'name.unique' => 'El nombre ya está registrado.',
            'name.max' => 'Solo se permite 15 caracteres.',

            'description.string' => 'El valor del campo es incorrecto.',
            'description.max' => 'Solo se permite 250 caracteres.'

        ];
    }
}
