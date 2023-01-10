<?php

namespace App\Http\Requests\tms;

use Illuminate\Foundation\Http\FormRequest;

class SurveyRequest extends FormRequest
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
        $data = [];
        if (request()->method() == "GET") {
            $data = [
            ];
        } else {
            $data = [
                "oid" => "required",
                "vid" => "required",
                "etiquette_point" => "required|gt:0|lt:5",
                "safefy_rule_point" => "required|gt:0|lt:5",
                "work_area_cleaning_point" => "required|gt:0|lt:5",
                "service_quality_point" => "required|gt:0|lt:5",
            ];
        }
        return $data;
    }
}
