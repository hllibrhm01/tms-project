<?php

namespace App\Http\Requests\tms;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CustomerIncomeRequest extends FormRequest
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
            "customer_id" => "required|numeric",
            "date" => "required",
            "income" => "required",
        ];

        return  $rules;
    }
    public function attributes()
    {
        return [
            "date" => "Tarih",
            "income" => "Fiyat",
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
