<?php

namespace App\Http\Requests\tms;

use Illuminate\Foundation\Http\FormRequest;

class VehicleEquipmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            "vehicle_id" => "required",
            "equipment_id" => "required",
            "count" => "required",
        ];

        return  $rules;
    }

    public function attributes()
    {
        return [
            "equipment_id" => "Ekipman",
            "count" => "Sayı",
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute giriniz.',
            'max' => ':attribute kısmını en fazla 15 karakter giriniz.',
            'numeric' => ':attribute kısmını rakam olarak giriniz.',
            'unique' => ':attribute bu veri kayıtlarda bulunmaktadır.',
        ];
    }
}
