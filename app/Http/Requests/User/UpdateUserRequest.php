<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user'); // Esto obtiene el ID del usuario desde la ruta
    
        return [
            'name' => 'required|string|max:255|min:6',
            'lastname' => 'required|string|max:255|min:6',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($userId, 'id')->whereNull('deleted_at'),
            ],
            'phone' => 'required|string|max:12|min:6',
            'address' => 'required|string|max:255|min:6',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'idRole' => ['sometimes', 'exists:roles,idRole'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Este campo es requerido.',
            'name.string' => 'El valor del nombre es incorrecto.',
            'name.min' => 'El nombre no puede tener menos de 6 caracteres.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',
    
            'lastname.required' => 'El apellido es requerido.',
            'lastname.string' => 'El valor del apellido es incorrecto.',
            'lastname.min' => 'El apellido no puede tener menos de 6 caracteres.',
            'lastname.max' => 'El apellido no puede tener más de 255 caracteres.',
    
            'email.required' => 'El correo es requerido.',
            'email.email' => 'Debe ingresar un correo válido.',
            'email.unique' => 'Este correo ya está registrado.',
    
            'phone.required' => 'El teléfono es requerido.',
            'phone.string' => 'El valor del teléfono es incorrecto.',
            'phone.min' => 'El teléfono debe tener al menos 6 caracteres.',
            'phone.max' => 'El teléfono no puede tener más de 12 caracteres.',
    
            'address.required' => 'La dirección es requerida.',
            'address.string' => 'El formato de la dirección es inválido.',
            'address.min' => 'La dirección debe tener al menos 6 caracteres.',
            'address.max' => 'La dirección no puede tener más de 255 caracteres.',
    
            'profile_photo.image' => 'El archivo debe ser una imagen.',
            'profile_photo.mimes' => 'La imagen debe ser de tipo JPG, JPEG o PNG.',
            'profile_photo.max' => 'La imagen no debe pesar más de 2 MB.',
    
            'idRole.required' => 'Debe seleccionar un rol.',
            'idRole.exists' => 'El rol seleccionado no es válido.',
    
            'password.string' => 'La contraseña debe ser texto.',
            'password.min' => 'Debe tener al menos 6 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ];
    }
}
