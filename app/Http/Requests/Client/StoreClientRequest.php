<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreClientRequest extends FormRequest
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
            'name' => 'required|string|max:50',
            'phone' => [
                'required',
                Rule::unique('clients', 'phone')->whereNull('deleted_at'),
                'string',
                'max:9',
                'min:9',
            ],
            'whatsapp' => [
                'required',
                Rule::unique('clients', 'whatsapp')->whereNull('deleted_at'),
                'string',
                'max:9',
            ],
        ];
    }

    public function messages()
    {
        //definimos los mensajes de error que nos mostrara
        return [
            'name.required' => 'Este campo es requerido.',
            'name.string' => 'El valor del campo es incorrecto.',
            'name.max' => 'Solo se permite 50 caracteres.',

            'phone.required' => 'Este campo es requerido.',
            'phone.string' => 'El valor del campo es incorrecto.',
            'phone.max' => 'Solo se permite 9 caracteres.',
            'phone.min' => 'El numero está incompleto.',
            'phone.unique' => 'El telefono ya se encuentra registrado.',

            'whatsapp.required' => 'Este campo es requerido.',
            'whatsapp.string' => 'El valor del campo es incorrecto.',
            'whatsapp.max' => 'Solo se permite 9 caracteres.',
            'whatsapp.min' => 'El numero está incompleto.',
            'whatsapp.unique' => 'El whatsapp ya se encuentra registrado.',
        ];
    }
}
