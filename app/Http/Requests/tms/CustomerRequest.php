<?php

namespace App\Http\Requests\tms;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CustomerRequest extends FormRequest
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
            "group_type" => "required",
            "work_type" => "required",
            "billing_period" => "required",
            "payment_type" => "required",
            "iban" => "required",
            "company_name" => "required|unique:tms_customers",
            "tax_department_city_id" => "required",
            "tax_department_id" => "required",
            "tax_number" => "required|numeric|unique:tms_customers",
        ];

        if ($request->route("id")) {
            $rules["company_name"] = "required|unique:tms_customers,company_name," . $request->route("id");
            $rules["tax_number"] = "required|numeric|unique:tms_customers,tax_number," . $request->route("id");
        }

        return  $rules;
    }
    public function attributes()
    {
        return [
            "type" => "Tipi",
            "company_name" => "Şirket Adı",
            "tax_number" => "Vergi Numarası",
            "authorized_person" => "Yetkili Adı Soyadı",
            "phone" => "Telefon",
            "email" => "Email",
        ];
    }

    public function messages()
    {
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
