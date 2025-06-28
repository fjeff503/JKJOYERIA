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
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($userId, 'id')->whereNull('deleted_at'),
            ],
            'idRole' => ['required', 'exists:roles,idRole'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Este campo es requerido.',
            'name.string' => 'El valor del nombre es incorrecto.',
            'name.min' => 'El nombre no puede tener menos de 6 caracteres.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',

            'email.required' => 'El correo es requerido.',
            'email.email' => 'Debe ingresar un correo válido.',
            'email.unique' => 'Este correo ya está registrado.',

            'idRole.required' => 'Debe seleccionar un rol.',
            'idRole.exists' => 'El rol seleccionado no es válido.',

            'password.string' => 'La contraseña debe ser texto.',
            'password.min' => 'Debe tener al menos 6 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ];
    }
}
