<?php

namespace App\Http\Requests\wms;

use Illuminate\Foundation\Http\FormRequest;

class LocationRequest extends FormRequest
{
    public function rules()
    {
        $rules = [
            "city_id" => "required",
            "district_id" => "required",
            "address_description" => "required",
            "authorized_person" => "required",
            "email" => "required|email",
            "phone" => "required|max:15",
            "capacity" => "required|numeric",
        ];

        return  $rules;
    }
    public function attributes()
    {
        return [
            "city_id" => "Şehir",
            "district_id" => "İlçe",
            "address_description" => "Adres Tarifi",
            "authorized_person" => "Yetkili Adı Soyadı",
            "email" => "Email",
            "phone" => "Telefon",
            "capacity" => "Kapasite",
        ];
    }

    public function messages(){
        return [
            'required' => ':attribute giriniz.',
            'email' => ':attribute adresi şeklinde giriniz.',
            'max' => ':attribute kısmını en fazla 15 karakter giriniz.',
            'numeric' => ':attribute kısmını rakam olarak giriniz.',
            'regex' => ':attribute formatını doğru şekilde giriniz.',
        ];
    }
}
