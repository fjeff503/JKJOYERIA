<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
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
            'phone'=>'nullable|string|unique:clients,phone'.$this->route('client')->id.'|max:9',
            'whatsapp'=>'nullable|string|unique:clients,whatsapp'.$this->route('client')->id.'|max:9'
        ];
    }
}
