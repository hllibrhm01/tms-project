<?php

namespace App\Http\Requests\tms;

use Illuminate\Foundation\Http\FormRequest;

class TMSEquipmentRequest extends FormRequest
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
            'vehicle_id' => 'required|numeric|gt:0',
            'equipment_id' => 'required|numeric|gt:0',
            'count' => 'required|numeric|gt:0',
        ];
    }
}
