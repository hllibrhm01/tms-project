<?php

namespace App\Http\Requests\tms;

use Illuminate\Foundation\Http\FormRequest;

class CustomerAuthorRequest extends FormRequest
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
            'customer_id' => 'required|numeric|gt:0',
            'name' => 'required|max:255',
            'title' => 'required|max:255',
            'phone' => 'required|max:20',
            'email' => 'required|email'
        ];
    }
}
