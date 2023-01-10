<?php

namespace App\Http\Requests\tms;

use Illuminate\Foundation\Http\FormRequest;

class VehicleMaintainRequest extends FormRequest
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
            "date" => "required",
            "type" => "required",
            "kilometer" => "required",
            "cost" => "required",
        ];

        return  $rules;
    }

    public function attributes()
    {
        return [
            "date" => "Tarih",
            "type" => "Tip",
            "kilometer" => "Kilometre",
            "cost" => "Fiyat",
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
