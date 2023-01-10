<?php

namespace App\Http\Requests\tms;

use Illuminate\Foundation\Http\FormRequest;

class VehicleExpenseRequest extends FormRequest
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
            "date" => "required",
            "vehicle_id" => "required",
            "employee_count" => "required",
            "missing_employee_count" => "required",
            "overtimer_employee_count" => "required",
            "work_finish_time" => "required",
            "driven_km" => "required",
            "fuel_taken_per_litre" => "required",
            "rental_cost" => "required",
            "employee_cost" => "required",
            "daily_overtime_meal_cost" => "required",
            "highway_expenses" => "required",
            "day_laborer" => "required",
            "supplies_cost" => "required",
        ];
    }
}
