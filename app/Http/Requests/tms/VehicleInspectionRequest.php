<?php

namespace App\Http\Requests\tms;

use Illuminate\Foundation\Http\FormRequest;

class VehicleInspectionRequest extends FormRequest
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
        return [
            'vehicle_id' => 'required|numeric',
            'date' => 'required',
            'cost' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            "vehicle_id" => "Araç",
            "date" => "Tarih",
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
