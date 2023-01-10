<?php

namespace App\Http\Requests\wms;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
       public function rules()
    {
        $rules = [
            "type" => "required",
            "owner_id" => "required",
            "weight" => "required|numeric",
            "phone" => "required|max:15",
            "city_id" => "required",
            "district_id" => "required|numeric",
            "address_description" => "required",
        ];

        return  $rules;
    }
    
    public function attributes()
    {
        return [
            "type" => "Tipi",
            "owner_id" => "Şirket Adı",
            "weight" => "Ağırlık",
            "phone" => "Telefon",
            "city_id" => "Şehir",
            "district_id" => "İlçe",
            "address_description" => "Adres Tarifi",
        ];
    }

    public function messages(){
        return [
            'required' => ':attribute giriniz.',
            'max' => ':attribute kısmını en fazla 15 karakter giriniz.',
            'numeric' => ':attribute kısmını rakam olarak giriniz.',
        ];
    }
}
