<?php

namespace App\Http\Requests\DeliveryPoint;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDeliveryPointRequest extends FormRequest
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
            'hour'=>'required|string|max:15',
            'description'=>'nullable|string|max:200',
            'idParcel'=>'required|integer',
            'idDay'=>'required|integer'
        ];
    }

    public function messages(){
        //definimos los mensajes de error que nos mostrara
        return[
            'name.required'=>'El nombre es requerido.',
            'name.string'=>'El valor del campo es incorrecto.',
            'name.max'=>'Solo se permite 50 caracteres.',

            'hour.required'=>'La hora es requerida.',
            'hour.string'=>'El valor del campo es incorrecto.',
            'hour.max'=>'Solo se permite 15 caracteres.',

            'description.string'=>'El valor del campo es incorrecto.',
            'description.max'=>'Solo se permite 200 caracteres.',

            'idParcel.required'=>'El encomendista es requerido.',
            'idParcel.integer'=>'El valor del campo es incorrecto.',
            'idParcel.exists'=>'La encomienda no existe.',

            'idDay.required'=>'El dia es requerido.',
            'idDay.integer'=>'El valor del campo es incorrecto.',
            'idDay.exists'=>'La encomienda no existe.'
        ];
    }
}
