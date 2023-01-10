<?php

namespace App\Http\Requests\tms;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            "group_type" => "required",
            "owner_id" => "required",
            "weight" => "required|numeric",
            "orderer_name" => "required|max:255",
            "orderer_phone" => "required|max:25",
            "orderer_email" => "required|email|max:255",
            "city_id" => "required",
            "district_id" => "required|numeric",
            "address_description" => "required",
            "productId" => "required|array|min:1",
            "productCount" => "required|array|min:1",
        ];

    }
    

    public function attributes()
    {
        return [
            "group_type" => "Tipi",
            "owner_id" => "Şirket Adı",
            "weight" => "Ağırlık",
            "orderer_name" => "Sipariş Veren Adı",
            "orderer_phone" => "Sipariş Veren Telefonu",
            "orderer_email" => "Sipariş Veren Email",
            "city_id" => "Şehir",
            "district_id" => "İlçe",
            "address_description" => "Adres Tarifi",
            "productId" => "Ürün Seçimi",
            "productCount" => "Ürün Adedi",
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute giriniz.',
            'max' => ':attribute kısmını en fazla 15 karakter giriniz.',
            'numeric' => ':attribute kısmını rakam olarak giriniz.',
            'array' => ':attribute en az bir tane girilmelidir.',
        ];
    }
}
