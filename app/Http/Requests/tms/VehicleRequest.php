<?php

namespace App\Http\Requests\tms;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class VehicleRequest extends FormRequest
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
    public function rules(Request $request)
    {
        $rules = [
            "driver_id" => "required|numeric|gt:0",
            "dedicated_customer_id" => "nullable|numeric|gte:0",
            "trademark" => "required",
            "model" => "required",
            "model_date" => "required|numeric",
            "kilometer" => "required|numeric",
            "care_kilometer" => "required|numeric",
            "inspection_date" => "required|date",
            "ownership" => "required",
            "average_fuel_consumption" => "required",
            "licence_plate" => "required|unique:tms_vehicles",
            "capacity" => "required|numeric",
            "width" => "required|numeric",
            "size" => "required|numeric",
            "height" => "required|numeric"
        ];

        if ($request->route("id"))
            $rules["licence_plate"] = "required|exists:tms_vehicles";

        return $rules;
    }

    public function attributes()
    {
        return [
            "driver_id" => "Sürücü Adı Soyadı",
            "dedicated_customer_id" => "Atanmış Müşteri",
            "licence_plate" => "Plaka",
            "trademark" => "Araç Markası",
            "model" => "Araç Modeli",
            "model_date" => "Araç Model Tarihi",
            "kilometer" => "Araç Kilometresi",
            "care_kilometer" => "Araç Bakım Kilometresi",
            "inspection_date" => "Araç Muayene Tarihi",
            "ownership" => "Araç Kime Ait",
            "average_fuel_consumption" => "Aracın Ortalama Yakıt Tüketimi(100km)",
            "capacity" => "Taşıma Kapasitesi",
            "width" => "Aracın Eni",
            "size" => "Aracın Boyu",
            "height" => "Aracın Yüksekliği"
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
