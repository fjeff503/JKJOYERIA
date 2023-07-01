<?php

namespace App\Http\Requests\Provider;

use Illuminate\Foundation\Http\FormRequest;

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
            'name'=>'required|string|max:50',
            'address'=>'required|string|max:150',
            'phone'=>'required|string|max:12|min:9|unique:providers',
            'facebook'=>'required|string|max:50',
            'whatsapp'=>'required|string|max:12|min:9',
            'description'=>'nullable|string|max:150'
        ];
    }

    public function messages(){
        //definimos los mensajes de error que nos mostrara
        return[
            'name.required'=>'Este campo es requerido.',
            'name.string'=>'El valor del campo es incorrecto.',
            'name.max'=>'Solo se permite 50 caracteres.',

            'address.required'=>'Este campo es requerido.',
            'address.string'=>'El valor del campo es incorrecto.',
            'address.max'=>'Solo se permite 150 caracteres.',

            'phone.required'=>'Este campo es requerido.',
            'phone.string'=>'El valor del campo es incorrecto.',
            'phone.max'=>'Solo se permite menos de 12 caracteres.',
            'phone.min'=>'Solo se permite más de 12 caracteres.',
            'phone.unique'=>'El telefono ya se encuentra registrado.',

            'facebook.required'=>'Este campo es requerido.',
            'facebook.string'=>'El valor del campo es incorrecto.',
            'facebook.max'=>'Solo se permite 50 caracteres.',

            'whatsapp.required'=>'Este campo es requerido.',
            'whatsapp.string'=>'El valor del campo es incorrecto.',
            'whatsapp.max'=>'Solo se permite menos de 12 caracteres.',
            'whatsapp.min'=>'Solo se permite más de 12 caracteres.',

            'description.string'=>'El valor del campo es incorrecto.',
            'description.max'=>'Solo se permite 150 caracteres.',
        ];
    }
}
