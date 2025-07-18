<?php

namespace App\Http\Requests\Parcel;

use Illuminate\Foundation\Http\FormRequest;

class UpdateParcelRequest extends FormRequest
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
            'phone' => 'nullable|max:11|min:9',
            'whatsapp' => 'required|string|max:11|min:9',
            'facebook' => 'nullable|string|max:255'
        ];
    }

    public function messages()
    {
        //definimos los mensajes de error que nos mostrara
        return [
            'name.required' => 'Este campo es requerido.',
            'name.string' => 'El valor del campo es incorrecto.',
            'name.max' => 'Solo se permite 50 caracteres.',

            'phone.string' => 'El valor del campo es incorrecto.',
            'phone.max' => 'Solo se permite menos de 10 caracteres.',
            'phone.min' => 'Solo se permite más de 8 caracteres.',
            'phone.unique' => 'El telefono ya se encuentra registrado.',

            'whatsapp.string' => 'El valor del campo es incorrecto.',
            'whatsapp.max' => 'Solo se permite menos de 10 caracteres.',
            'whatsapp.min' => 'Solo se permite más de 8 caracteres.',
            'whatsapp.unique' => 'El whatsapp ya se encuentra registrado.',

            'facebook.string' => 'El valor del campo es incorrecto.',
            'facebook.max' => 'Solo se permite 255 caracteres.',
            'facebook.unique' => 'El facebook ya se encuentra registrado.',

        ];
    }
}
