<?php

namespace App\Models\wms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\City;
use App\Models\District;
use Illuminate\Database\Eloquent\SoftDeletes;

class WMSOrder extends Model
{
    use SoftDeletes;

    const STATUS_RECEIVED = 1;
    const STATUS_ON_VEHICLE = 2;
    const STATUS_INSTALLING = 3;
    const STATUS_INSTALLED = 4;
    const STATUS_PENDING_REVIEW = 5;
    const STATUS_BROKEN = 6;
    const STATUS_COMPLETED = 7;

    const OrderStatus = [
        "1" => "Sipariş Alındı ",
        "2" => "Taşımada",
        "3" => "Kurulumda",
        "4" => "Kuruldu",
        "5" => "Anket Bekleniyor",
        "6" => "Hasarlı Ürün",
        "7" => "Tamamlandı",
    ];

    protected $table = 'wms_orders';
    protected $fillable = [
        'owner_id',
        'weight',
        'phone',
        'country',
        'city_id',
        'district_id',
        'product_info',
        'address_description',
        'note',
        'status',
    ];

    public function customer()
    {
        return  $this->belongsTo(WMSCustomer::class, 'owner_id');
    }

    public function city()
    {
        return  $this->belongsTo(City::class, 'city_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public static function getOrdersByType($id) {
        return self::with('city', 'district', 'customer')->where('type', $id)->get();
    }

    public static function getOrdersByOwnerTypeAndOrderType($id, $status)
    {
        return self::with('city' , 'district', 'customer')->where('type', $id)->where('status', $status)->get();
    }


    public static function addOrder($request)
    {
        $wmsOrder = new self();
        $wmsOrder->type = $request->type;
        $wmsOrder->owner_id = $request->owner_id;
        $wmsOrder->weight = $request->weight;
        $wmsOrder->phone = $request->phone;
        // $wmsOrder->country= $request->country;
        $wmsOrder->city_id = $request->city_id;
        $wmsOrder->district_id = $request->district_id;
        $wmsOrder->product_info = $request->product_info;
        $wmsOrder->address_description = $request->address_description;
        $wmsOrder->note = $request->note;
        $wmsOrder->save();
        return $wmsOrder;
    }

    public static function editOrder($id, $request)
    {
        $wmsOrder = self::find($id);
        if (is_null($id)) {
            return null;
        }

        $wmsOrder->type = $request->type;
        $wmsOrder->owner_id = $request->owner_id;
        $wmsOrder->weight = $request->weight;
        $wmsOrder->phone = $request->phone;
        // $wmsOrder->country= $request->country;
        $wmsOrder->city_id = $request->city_id;
        $wmsOrder->district_id = $request->district_id;
        $wmsOrder->product_info = $request->product_info;
        $wmsOrder->address_description = $request->address_description;
        $wmsOrder->note = $request->note;
        $wmsOrder->status = $request->status;
        $wmsOrder->save();
        return $wmsOrder;
    }

    public static function deleteOrder($id)
    {
        $wmsOrder = self::find($id);

        if (is_null($wmsOrder)) {
            return false;
        }

        $wmsOrder->delete();
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
}
