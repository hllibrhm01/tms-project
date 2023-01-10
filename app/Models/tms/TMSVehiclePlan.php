<?php

namespace App\Models\tms;

use App\Models\tms\TMSOrder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TMSVehiclePlan extends Model
{
    use SoftDeletes;

    const STATUS_ACTIVE = 1;
    const STATUS_PASSIVE = 2;

    protected $table = 'tms_vehicles_plans';

    protected $fillable = [
        'vehicle_id',
        'order_id',
        'plan_date',
        'position'
    ];

    public function order()
    {
        return $this->hasOne(TMSOrder::class, 'id', 'order_id')->with(['customer', 'products']);
    }

    public static function clearVehiclePlanByPlanDate($vehicleId, $planDate)
    {
        self::where('vehicle_id', $vehicleId)
            ->where('plan_date', $planDate)
            ->delete();
    }

    public static function checkOrderPlanned($vehicleId, $orderId, $planDate)
    {
        $plan = self::where('vehicle_id', '<>', $vehicleId)
            ->where('order_id', $orderId)
            ->where('plan_date', '<>', $planDate)
            ->first();

        if ($plan)
            return true;

        return false;
    }

    public static function updateVehiclePlan($vehicleId, $planDate, $orders)
    {
        $planCount = TMSVehiclePlan::where('vehicle_id', $vehicleId)
            ->where('plan_date', $planDate)
            ->count();

        if ($planCount > 0)
            self::clearVehiclePlanByPlanDate($vehicleId, $planDate);

        $position = 1;
        foreach ($orders as $order) {
            $isOrderPlanned = self::checkOrderPlanned($vehicleId, $order, $planDate);
            if ($isOrderPlanned)
                continue;

            $orderInfo = TMSOrder::getOrderByOrderId($order);
            if($orderInfo->status == TMSOrder::STATUS_NOT_COMPLETED)
                TMSOrder::setOrderAsReceived($order);

            $plan = new TMSVehiclePlan();
            $plan->vehicle_id = $vehicleId;
            $plan->order_id = $order;
            $plan->plan_date = $planDate;
            $plan->position = $position;
            $plan->save();

            TMSOrder::updateOrderVehicle($order, $vehicleId);

            $position++;
        }
    }

    public static function getVehiclePlanByPlanDate($vehicleId, $planDate)
    {
        return self::with('order')
            ->where('vehicle_id', $vehicleId)
            ->where('plan_date', $planDate)
            ->orderBy('position', 'asc')
            ->get();
    }

    public function getOrder()
    {
        return $this->belongsTo(TMSOrder::class, 'order_id');
    }

    public static function getOrderDetails()
    {
        return self::with('getOrder')->get();
    }

    public static function deletePlan($planId)
    {
        $plan = self::find($planId);
        if (!$plan)
            return false;
        $plan->delete();
        return true;
    }

    public static function getPlanByOrder($orderId)
    {
        return self::where('order_id', $orderId)->first();
    }

    public static function getVehiclePlanByPlanId($planId)
    {
        return self::where('id', $planId)->first();
    }

    public static function getVehiclePlanByVehicleId($vehicleId)
    {
        return self::where('vehicle_id', $vehicleId)->get();
    }
}
