<?php

namespace App\Http\Requests\Parcel;

use Illuminate\Foundation\Http\FormRequest;

class StoreParcelRequest extends FormRequest
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
            'phone'=>'nullable|string|unique:clients|max:9',
            'whatsapp'=>'nullable|string|unique:clients|max:9',
            'facebook'=>'nullable|string|unique:clients|max:100'
        ];
    }

    public function messages(){
        //definimos los mensajes de error que nos mostrara
        return[
            'name.required'=>'Este campo es requerido.',
            'name.string'=>'El valor del campo es incorrecto.',
            'name.max'=>'Solo se permite 50 caracteres.',

            'phone.string'=>'El valor del campo es incorrecto.',
            'phone.max'=>'Solo se permite 9 caracteres.',
            'phone.unique'=>'El telefono ya se encuentra registrado.',

            'whatsapp.string'=>'El valor del campo es incorrecto.',
            'whatsapp.max'=>'Solo se permite 9 caracteres.',
            'whatsapp.unique'=>'El whatsapp ya se encuentra registrado.',

            'facebook.string'=>'El valor del campo es incorrecto.',
            'facebook.max'=>'Solo se permite 100 caracteres.',
            'facebook.unique'=>'El facebook ya se encuentra registrado.',

        ];
    }
}
