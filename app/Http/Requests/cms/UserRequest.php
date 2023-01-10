<?php

namespace App\Http\Requests\cms;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $id = $this->route("id");
        $rules = [
            "name" => "required",
            "email" => "required",
            "role_id" => "required|gt:0",
        ];

        if (is_null($id))
            $rules["password"] = "required";

        return  $rules;
    }
}
