<?php

namespace App\Http\Requests\Provider;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProviderRequest extends FormRequest
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
                Rule::unique('providers', 'name')->whereNull('deleted_at'),
                'string',
                'max:50',
            ],
            'address'=>'required|string|max:255',
            'phone' => [
                'required',
                Rule::unique('providers', 'phone')->whereNull('deleted_at'),
                'string',
                'max:13',
                'min:11',
            ],
            'whatsapp' => [
                'required',
                Rule::unique('providers', 'whatsapp')->whereNull('deleted_at'),
                'string',
                'max:13',
                'min:11',
            ],
            'facebook' => [
                'required',
                Rule::unique('providers', 'facebook')->whereNull('deleted_at'),
                'string',
                'max:255',
            ],
            'description'=>'nullable|string|max:255'
        ];
    }

    public function messages(){
        //definimos los mensajes de error que nos mostrara
        return[
            'name.required'=>'Este campo es requerido.',
            'name.string'=>'El valor del campo es incorrecto.',
            'name.max'=>'Solo se permite 50 caracteres.',
            'name.unique'=>'El proveedor ya se encuentra registrado.',

            'address.required'=>'Este campo es requerido.',
            'address.string'=>'El valor del campo es incorrecto.',
            'address.max'=>'Solo se permite 255 caracteres.',

            'phone.required'=>'Este campo es requerido.',
            'phone.string'=>'El valor del campo es incorrecto.',
            'phone.max'=>'Solo se permite menos de 10 caracteres.',
            'phone.min'=>'El numero está incompleto.',
            'phone.unique'=>'El telefono ya se encuentra registrado.',

            'facebook.required'=>'Este campo es requerido.',
            'facebook.string'=>'El valor del campo es incorrecto.',
            'facebook.max'=>'Solo se permite 50 caracteres.',
            'facebook.unique'=>'El facebook ya se encuentra registrado.',

            'whatsapp.required'=>'Este campo es requerido.',
            'whatsapp.string'=>'El valor del campo es incorrecto.',
            'whatsapp.max'=>'Solo se permite menos de 10 caracteres.',
            'whatsapp.min'=>'El numero está incompleto.',
            'whatsapp.unique'=>'El whatsapp ya se encuentra registrado.',

            'description.string'=>'El valor del campo es incorrecto.',
            'description.max'=>'Solo se permite 255 caracteres.',
        ];
    }
}
