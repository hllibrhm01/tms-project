<?php

namespace App\Http\Requests\wms;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    public function rules()
    {
        $rules = [
            "type" => "required",
            "company_name" => "required|unique:wms_customers",
            "tax_number" => "required|numeric|unique:wms_customers",
            "authorized_person" => "required",
            "phone" => "required|max:15|unique:wms_customers",
            "email" => "required|email|unique:wms_customers",
            "address" => "required|unique:wms_customers",
            "note" => "required",
        ];

        return  $rules;
    }
    public function attributes()
    {
        return [
            "type" => "Şehir",
            "company_name" => "Şirket Adı",
            "tax_number" => "Vergi Numarası",
            "authorized_person" => "Yetkili Adı Soyadı",
            "phone" => "Telefon",
            "email" => "Email",
            "address" => "Adres",
            "note" => "Not",
        ];
    }

    public function messages(){
        return [
            'required' => ':attribute giriniz.',
            'email' => ':attribute adresi şeklinde giriniz.',
            'max' => ':attribute kısmını en fazla 15 karakter giriniz.',
            'numeric' => ':attribute kısmını rakam olarak giriniz.',
            'regex' => ':attribute formatını doğru şekilde giriniz.',
            'unique' => ':attribute bu veri kayıtlarda bulunmaktadır.',
        ];
    }
}
