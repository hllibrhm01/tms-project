<?php

namespace App\Models\tms;

use App\Http\Requests\tms\VehicleExpenseRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TMSVehicleExpense extends Model
{
    use SoftDeletes;

    const DAILY_MEAL_PRICE = 45;

    protected $table = 'tms_vehicle_expenses';

    protected $fillable = [
        'date', 'vehicle_id', 'employee_count', 'missing_employee_count', 'overtimer_employee_count',
        'work_finish_time', 'driven_km', 'fuel_taken_per_litre', 'fuel_taken_with_tl', 'fuel_consumption_per_km',
        'fuel_consumption_percentage_per_km', 'rental_cost', 'employee_cost', 'daily_meal_cost',
        'daily_overtime_meal_cost', 'highway_expenses', 'day_laborer', 'supplies_cost', 'total_cost', 'total_revenue'
    ];

    public static function scopeDate($query, $date)
    {
        return $query->where("date", $date);
    }

    public static function scopeVehicleId($query, $vehicleId)
    {
        return $query->where("vehicle_id", $vehicleId);
    }

    public function vehicle()
    {
        return  $this->belongsTo(TMSVehicle::class, 'vehicle_id');
    }

    public static function getExpensesByDate($date)
    {
        $vehicles = TMSVehicle::getAllVehicles();
        $expenses = self::with('vehicle')->date($date)->get();
        $isChanged = false;
        foreach ($vehicles as $vehicle) {
            $expense = $expenses->filter(function ($item) use ($vehicle, $date) {
                return $item->vehicle_id == $vehicle->id;
            })->first();

            if (is_null($expense)) {
                $isChanged = true;
                $expense = new self();
                $expense->vehicle_id = $vehicle->id;
                $expense->date = $date;
                $expense->employee_count =  0;
                $expense->missing_employee_count =  0;
                $expense->overtimer_employee_count =  0;
                $expense->work_finish_time = Carbon::parse("18:00");
                $expense->driven_km =  0;
                $expense->fuel_taken_per_litre =  0;
                $expense->rental_cost =  0;
                $expense->employee_cost =  0;
                $expense->daily_overtime_meal_cost =  0;
                $expense->highway_expenses =  0;
                $expense->day_laborer =  0;
                $expense->supplies_cost = 0;
                $expense->fuel_taken_with_tl =  0;
                $expense->fuel_consumption_per_km =  0;
                $expense->fuel_consumption_percentage_per_km =  0;
                $expense->daily_meal_cost = 0;
                $expense->total_cost = 0;
                $expense->total_revenue = self::getTotalRevenue($vehicle->id, $date);
                $expense->save();
            }
        }
        if ($isChanged)
            $expenses = self::with('vehicle')->date($date)->get();

        return $expenses;
    }

    public static function updateVehicleExpense(VehicleExpenseRequest $request)
    {
        $expense = self::date($request->date)->vehicleId($request->vehicle_id)->first();
        if (is_null($expense))
            $expense = new self();

        $expense->date = $request->date;
        $expense->vehicle_id = $request->vehicle_id;
        $expense->employee_count = $request->employee_count;
        $expense->missing_employee_count = $request->missing_employee_count;
        $expense->overtimer_employee_count = $request->overtimer_employee_count;
        $expense->work_finish_time = $request->work_finish_time;
        $expense->driven_km = str_replace(',', '', $request->driven_km);
        $expense->fuel_taken_per_litre = str_replace(',', '', $request->fuel_taken_per_litre);
        $expense->rental_cost = str_replace(',', '', $request->rental_cost);
        $expense->employee_cost = str_replace(',', '', $request->employee_cost);
        $expense->daily_overtime_meal_cost = str_replace(',', '', $request->daily_overtime_meal_cost);
        $expense->highway_expenses = str_replace(',', '', $request->highway_expenses);
        $expense->day_laborer = str_replace(',', '', $request->day_laborer);
        $expense->supplies_cost = str_replace(',', '', $request->supplies_cost);
        $expense->fuel_taken_with_tl = str_replace(',', '', $request->fuel_taken_with_tl);
        $expense->fuel_consumption_per_km = str_replace(',', '', $request->fuel_consumption_per_km);
        $expense->fuel_consumption_percentage_per_km = str_replace(',', '', $request->fuel_consumption_percentage_per_km);
        $expense->daily_meal_cost = str_replace(',', '', $request->daily_meal_cost);
        $expense->total_cost = str_replace(',', '', $request->total_cost);
        $expense->total_revenue = self::getTotalRevenue($request->vehicle_id, $request->date);
        $expense->save();
        return $expense;
    }


    private static function getTotalCost($expense)
    {
        $cost = $expense->rental_cost + $expense->employee_cost +  $expense->daily_overtime_meal_cost;
        $cost += $expense->highway_expenses + $expense->day_laborer + $expense->daily_meal_cost;
        return $cost;
    }

    private static function getTotalRevenue($vehicleId, $date)
    {
        $totalRevenue = 0;
        $vehicle = TMSVehicle::getVehicle($vehicleId);
        if (is_null($vehicle))
            return $totalRevenue;

        if (!is_null($vehicle->dedicated_customer_id) || $vehicle->dedicated_customer_id > 0) {
            $customer = TMSCustomer::getCustomer($vehicle->dedicated_customer_id);
            if (!is_null($customer)) {
                if ($customer->progress_payment_type == TMSCustomer::PROGRESS_PAYMENT_TYPES["TEK FİYAT"]) {
                    $totalRevenue = $customer->progress_payment_rate;
                    return $totalRevenue;
                }
            }
        }
        $vehiclePlans = TMSVehiclePlan::getVehiclePlanByPlanDate($vehicleId, $date);


        foreach ($vehiclePlans as $vehiclePlan) {
            $order = $vehiclePlan->order;
            $orderer = $vehiclePlan->order->customer;
            $orderRevenue = 0;
            switch ($orderer->progress_payment_type) {
                case 1:  // ORAN
                    $orderProducts = $order->products;
                    foreach ($orderProducts as $orderProduct) {
                        $price = $orderProduct->product->price;
                        $revenue = $price / $orderer->progress_payment_rate;
                        $orderRevenue += $revenue * $orderProduct->count;
                    }
                    break;
                case 2:  // TEK FİYAT
                    $orderRevenue = $orderer->progress_payment_rate;
                    break;
                case 3:  // ÜRÜN LİSTESİ
                    $orderProducts = $order->products;
                    foreach ($orderProducts as $orderProduct) {
                        $price = $orderProduct->product->price;
                        $orderRevenue += $price * $orderProduct->count;
                    }
                    break;
            }

            $totalRevenue += $orderRevenue;
        }
        return $totalRevenue;
    }
}
