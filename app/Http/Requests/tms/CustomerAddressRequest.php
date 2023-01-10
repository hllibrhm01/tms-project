<?php

namespace App\Http\Requests\tms;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CustomerAddressRequest extends FormRequest
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
            "is_invoice_address" => "required|unique:tms_customer_addresses",
        ];

        return  $rules;
    }
    public function attributes()
    {
        return [
            "is_invoice_address" => "required|unique:tms_customer_addresses",
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
