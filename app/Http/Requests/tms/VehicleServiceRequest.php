<?php

namespace App\Http\Requests\tms;

use Illuminate\Foundation\Http\FormRequest;

class VehicleServiceRequest extends FormRequest
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
            "author" => "required|max:255",
            "name" => "required|max:255",
            "phone" => "required|max:255",
            "email" => "required|email",
            "address" => "required",
        ];
    }

    public function attributes()
    {
        return [
            "author" => "Yetkili Adı",
            "name" => "Servisin Adı",
            "phone" => "Servisin Telefon Numarası",
            "email" => "Servisin Emaili",
            "address" => "Servisin Adresi",
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
