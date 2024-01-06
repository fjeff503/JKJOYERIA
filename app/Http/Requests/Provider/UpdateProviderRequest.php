<?php

namespace App\Http\Requests\Provider;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProviderRequest extends FormRequest
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
            'name'=>'required|string|max:50',
            'address'=>'required|string|max:150',
            'phone'=>'nullable|max:13|min:11',
            'facebook'=>'required|string|max:50',
            'whatsapp'=>'required|string|max:13|min:11',
            'description'=>'nullable|string|max:150'
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
            'address.max'=>'Solo se permite 150 caracteres.',

            'phone.required'=>'Este campo es requerido.',
            'phone.string'=>'El valor del campo es incorrecto.',
            'phone.max'=>'Solo se permite menos de 10 caracteres.',
            'phone.min'=>'El numero está incompleto.',
            'phone.unique'=>'El telefono ya se encuentra registrado.',

            'facebook.required'=>'Este campo es requerido.',
            'facebook.string'=>'El valor del campo es incorrecto.',
            'facebook.max'=>'Solo se permite 50 caracteres.',

            'whatsapp.required'=>'Este campo es requerido.',
            'whatsapp.string'=>'El valor del campo es incorrecto.',
            'whatsapp.max'=>'Solo se permite menos de 10 caracteres.',
            'whatsapp.min'=>'El numero está incompleto.',

            'description.string'=>'El valor del campo es incorrecto.',
            'description.max'=>'Solo se permite 150 caracteres.',
        ];
    }
}
