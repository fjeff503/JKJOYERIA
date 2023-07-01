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
            'name'=>'required|string|max:50',
            'phone'=>'nullable|string|unique:parcels,phone'.$this->route('parcel')->id.'|max:9',
            'whatsapp'=>'nullable|string|unique:parcels,whatsapp'.$this->route('parcel')->id.'|max:9',
            'facebook'=>'nullable|string|unique:parcels,facebook'.$this->route('parcel')->id.'|max:100'
        ];
    }
}
