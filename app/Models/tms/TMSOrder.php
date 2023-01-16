<?php

namespace App\Models\tms;

use App\Helper\TMSOrderHelper;
use App\Models\City;
use App\Models\District;
use App\Models\tms\TMSOrderStatusChange;
use App\Models\tms\TMSOrderImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class TMSOrder extends Model
{
    use SoftDeletes;

    const ORDER_NUMBER_START_VALUE = 10000;
    const STATUS_RECEIVED = 1;
    const STATUS_ON_VEHICLE = 2;
    const STATUS_ON_ROAD = 3;
    const STATUS_ON_ADDRESS = 4;
    const STATUS_ON_EXPLORE = 5;
    const STATUS_READY_TO_INSTALL = 6;
    const STATUS_NOT_READY_TO_INSTALL = 7;
    const STATUS_WILL_BE_INSTALLED_LATER = 8;
    const STATUS_INSTALLED = 9;
    const STATUS_WAITING_FOR_CONFIRMATION = 10;
    const STATUS_CONFIRM_WITH_DELIVERY_RECEIPT = 11;
    const STATUS_PENDING_REVIEW = 12;
    const STATUS_BROKEN = 13;
    const STATUS_COMPLETED = 14;
    const STATUS_NOT_COMPLETED = 15;
    const ORDER_TYPE_REGULAR = 1;
    const ORDER_TYPE_FAST = 2;

    const OrderStatus = [
        "1" => "Sipariş Oluşturuldu",
        "2" => "Araçta",
        "3" => "Sipariş Yola Çıktı",
        "4" => "Adreste",
        "5" => "Keşifte",
        "6" => "Kuruluma Uygun",
        "7" => "Kuruluma Uygun Değil",
        "8" => "Daha Sonra Kurulacak",
        "9" => "Kuruldu",
        "10" => "Müşteri Onayı Bekliyor",
        "11" => "Teslimat Fişi İle Onaylandı",
        "12" => "Anket Bekleniyor",
        "13" => "Hasarlı Ürün",
        "14" => "Tamamlandı",
        "15" => "Tamamlanmadı",
    ];

    
    const PLANNER_NOTIFICATION_TYPE_PREORDER_RECEIVED = 1;
    const PLANNER_NOTIFICATION_TYPE_FAST_ORDER_RECEIVED = 2;

    protected $table = 'tms_orders';
    protected $fillable = [
        'order_number',
        'order_type',
        'owner_id',
        'group_type',
        'sms_verification_code',
        'weight',
        'orderer_name',
        'orderer_phone',
        'orderer_email',
        'country_id',
        'city_id',
        'district_id',
        'address_description',
        'note',
        'status',
        'attachment',
        'start_time',
        'end_time'
    ];

    public function customer()
    {
        return  $this->belongsTo(TMSCustomer::class, 'owner_id');
    }

    public function city()
    {
        return  $this->belongsTo(City::class, 'city_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function products()
    {
        return $this->hasMany(TMSOrderProduct::class, 'order_id')->with('product');
    }

    public static function getOrdersByStatus($id)
    {
        return self::with('city', 'district', 'customer', 'products')->where('status', $id)->get();
    }

    public static function getOrder($orderId)
    {
        return self::with('city', 'district', 'customer', 'products')->where('id', $orderId)->first();
    }

    public function getCompleteTime()
    {
        if (is_null($this->end_time) || is_null($this->start_time))
            return "";

        $diff = Carbon::parse($this->end_time)->diffInSeconds(Carbon::parse($this->start_time));
        return gmdate('H:i:s', $diff);
    }

    public function orders()
    {
        return $this->hasMany(TMSOrderImage::class, 'order_id');
    }

    public function getOrdererInfo()
    {
        return $this->orderer_name . "<br>" . $this->orderer_phone . "<br>" . $this->orderer_email;
    }

    public function getProductInfo()
    {
        $str = "";
        foreach ($this->products as $orderProduct)
            $str .= "<b>" . $orderProduct->count . " ADET " . $orderProduct->product->name .  "</b><br>";

        return $str;
    }

    public static function getOrderByOrderId($orderId)
    {
        return self::find($orderId);
    }

    public static function getOrders($id)
    {
        return self::with('orders')->whereId($id)->get();
    }

    public static function createOrderFromPreorder($preorder)
    {
        $tmsOrder = new self();
        $tmsOrder->owner_id = $preorder->customer->id;
        $tmsOrder->group_type = $preorder->customer->group_type;
        $tmsOrder->order_type = $preorder->order_type;
        $tmsOrder->orderer_name = $preorder->orderer_name;
        $tmsOrder->orderer_phone = $preorder->orderer_phone;
        $tmsOrder->orderer_email = $preorder->orderer_email;
        $tmsOrder->weight = str_replace(",", ".", $preorder->weight);
        $tmsOrder->city_id = $preorder->city_id;
        $tmsOrder->district_id = $preorder->district_id;
        $tmsOrder->address_description = $preorder->address_description;
        $tmsOrder->note = $preorder->note;
        $tmsOrder->attachment = "";
        $tmsOrder->sms_verification_code = generate_verification_code(6);
        $tmsOrder->status = self::STATUS_RECEIVED;
        $tmsOrder->save();
        $tmsOrder->order_number = self::ORDER_NUMBER_START_VALUE + $tmsOrder->id;
        $tmsOrder->save();

        foreach ($preorder->products as $product)
            TMSOrderProduct::addOrderProducts($tmsOrder->id, $product->product_id, $product->count);

        $tmsOrder = self::getOrder($tmsOrder->id);
        return $tmsOrder;
    }

    public static function addOrder($request, $attachment)
    {
        $tmsOrder = new self();
        $tmsOrder->owner_id = $request->owner_id;
        $tmsOrder->group_type = $request->group_type;
        $tmsOrder->order_type = $request->order_type;
        $tmsOrder->orderer_name = $request->orderer_name;
        $tmsOrder->orderer_phone = $request->orderer_phone;
        $tmsOrder->orderer_email = $request->orderer_email;
        $tmsOrder->weight = str_replace(',', '.', $request->weight);
        $tmsOrder->city_id = $request->city_id;
        $tmsOrder->district_id = $request->district_id;
        $tmsOrder->address_description = $request->address_description;
        $tmsOrder->note = strtoupper($request->note);
        $tmsOrder->attachment = $attachment;
        $tmsOrder->sms_verification_code = generate_verification_code(6);
        $tmsOrder->status = self::STATUS_RECEIVED;
        $tmsOrder->save();
        $tmsOrder->order_number = self::ORDER_NUMBER_START_VALUE + $tmsOrder->id;
        $tmsOrder->save();
        $tmsOrder = self::getOrder($tmsOrder->id);
        return $tmsOrder;
    }

    public static function editOrder($id, $request, $attachment)
    {
        $tmsOrder = self::find($id);
        if (is_null($id)) {
            return null;
        }

        $tmsOrder->owner_id = $request->owner_id;
        $tmsOrder->group_type = $request->group_type;
        $tmsOrder->order_type = $request->order_type;
        $tmsOrder->orderer_name = $request->orderer_name;
        $tmsOrder->orderer_phone = $request->orderer_phone;
        $tmsOrder->orderer_email = $request->orderer_email;
        $tmsOrder->weight = str_replace(',', '.', $request->weight);
        $tmsOrder->city_id = $request->city_id;
        $tmsOrder->district_id = $request->district_id;
        $tmsOrder->address_description = $request->address_description;
        $tmsOrder->note = $request->note;
        $tmsOrder->attachment = $attachment;
        $tmsOrder->status = self::STATUS_RECEIVED;
        $tmsOrder->save();
        $tmsOrder = self::getOrder($tmsOrder->id);
        return $tmsOrder;
    }

    public static function deleteOrder($id)
    {
        $tmsOrder = self::find($id);

        if (is_null($tmsOrder)) {
            return false;
        }

        $tmsOrder->delete();
        return true;
    }

    public static function getAllOrdersExceptVehicles($vehicleOrderIds)
    {
        return self::where('status', '<>', self::STATUS_COMPLETED)->whereNotIn("id", $vehicleOrderIds)->get();
    }

    public static function updateOrderVehicle($orderId, $vehicleId)
    {
        $order = self::find($orderId);
        if (is_null($order))
            return null;

        $order->vehicle_id = $vehicleId;
        $order->save();
        return $order;
    }

    public static function isUserHasActiveOrder($vehicleId, $orderId)
    {
        return self::join('tms_vehicles_plans', 'tms_vehicles_plans.order_id', '=', 'tms_orders.id')
            ->where('tms_vehicles_plans.id', '!=', $orderId)
            ->where('tms_vehicles_plans.vehicle_id', $vehicleId)
            ->where(function ($query) {
                $query->where('tms_orders.status', self::STATUS_ON_ADDRESS)
                    ->orWhere('tms_orders.status',  self::STATUS_ON_EXPLORE)
                    ->orWhere('tms_orders.status',  self::STATUS_READY_TO_INSTALL)
                    ->orWhere('tms_orders.status',  self::STATUS_INSTALLED)
                    ->orWhere('tms_orders.status',  self::STATUS_WAITING_FOR_CONFIRMATION)
                    ->orWhere('tms_orders.status',  self::STATUS_WILL_BE_INSTALLED_LATER);
            })
            ->where('tms_vehicles_plans.plan_date', Carbon::now())
            ->whereNotNull('tms_vehicles_plans.deleted_at')
            ->count() != 0;
    }

    public static function updateOrderStatus($id, $status, $note)
    {
        $order = self::find($id);
        if (is_null($order))
            return null;

        if (is_null($order->sms_verification_code))
            $order->sms_verification_code = generate_verification_code(6);

        $order->status = $status;

        switch ($status) {
            case self::STATUS_READY_TO_INSTALL:
                $order->start_time = Carbon::now();
                break;

            case self::STATUS_PENDING_REVIEW:
                $order->end_time = Carbon::now();
                break;

            case self::STATUS_BROKEN:
                $order->end_time = Carbon::now();
                break;

            case self::STATUS_NOT_READY_TO_INSTALL:
                $order->end_time = Carbon::now();
                break;
            
            case self::STATUS_NOT_COMPLETED:
                $order->end_time = Carbon::now();
                $planId = TMSVehiclePlan::where('order_id', $id)->first()->id;
                TMSVehiclePlan::deletePlan($planId);
                break;
            
            case self::STATUS_WILL_BE_INSTALLED_LATER:
                $order->end_time = Carbon::now();
                $planId = TMSVehiclePlan::where('order_id', $id)->first()->id;
                TMSVehiclePlan::deletePlan($planId);
                break;
        }

        $order->save();
        TMSOrderStatusChange::addOrderStatusChange($id, $status, $note);
        return $order;
    }

    public static function getNextStatus($orderId)
    {
        $order = self::find($orderId);
        if (is_null($order))
            return null;

        $nextStatus = TMSOrderHelper::getNextStatus($order);
        return $nextStatus;
    }

    public static function getNextStatusForMobile($orderId)
    {
        $order = self::find($orderId);
        if (is_null($order))
            return null;

        $nextStatus = TMSOrderHelper::getNextStatus($order);
        return $nextStatus;
    }

    public static function getVehicleLocation($orderId)
    {
        $vehicle = TMSVehicle::where('id', self::find($orderId)->vehicle_id)->first();
        return $vehicle;
    }

    public static function search($request)
    {
        return self::when($request->status > 0, function ($query) use ($request) {
            $query->where('status', $request->status);
        })->get();
    }

    public static function surveyCompleted($order)
    {
        $order->status = self::STATUS_COMPLETED;
        $order->save();
        return $order;
    }


    public static function getCustomerOrdersByStatus($customerId, $status)
    {
        return self::where('owner_id', $customerId)->with('customer', 'products')
            ->when($status > 0, function ($query) use ($status) {
                $query->where('status', $status);
            })->get();
    }

    public static function getOrderByStatusAndDate($id, $date, $status)
    {
        return self::where('owner_id', $id)->with('customer', 'products')
            ->when($status > 0, function ($query) use ($status) {
                $query->where('status', $status);
            })->whereDate('created_at', $date)->get();
    }

    public static function getOrdersOnStatusOpen($getOrderId)
    {
        return self::where(
            function ($query) {
                $query->where('status', '=', self::STATUS_RECEIVED)
                    ->orWhere('status', '=', self::STATUS_NOT_COMPLETED)
                    ->orWhere('status', '=', self::STATUS_WILL_BE_INSTALLED_LATER);
            }
        )->whereNotIn('id', $getOrderId)->get();
    }

    public static function setOrderAsReceived($id)
    {
        return self::find($id)->update(['status' => Self::STATUS_RECEIVED]);
    }
}
