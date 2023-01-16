<?php

namespace App\Models\tms;

use App\Models\City;
use App\Models\District;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TMSPreorder extends Model
{
    use SoftDeletes;

    protected $table = 'tms_preorders';

    protected $fillable = [
        'tms_customer_id',
        'order_type',
        'weight',
        'orderer_name',
        'orderer_phone',
        'orderer_email',
        'country_id',
        'city_id',
        'district_id',
        'address_description',
        'note',
        'status'
    ];

    public function customer()
    {
        return $this->belongsTo(TMSCustomer::class, 'tms_customer_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function products()
    {
        return $this->hasMany(TMSPreorderItem::class, 'order_id')->with('product');
    }

    public function getOrdererInfo()
    {
        return $this->orderer_name . "<br>" . $this->orderer_phone . "<br>" . $this->orderer_email;
    }

    public function getProductInfo()
    {
        $str = "";
        foreach ($this->products as $orderProduct)
            $str .= "<b>" . $orderProduct->count . " ADET " . $orderProduct->product->name . "</b><br>";

        return $str;
    }

    public static function getAllOrders()
    {
        return self::with('city', 'district', 'products', 'customer')->get();
    }

    public static function getCustomerOrdersByStatus($customerId, $status)
    {
        return self::with('city', 'district', 'products', 'customer')
            ->where('tms_customer_id', $customerId)
            ->when($status > 0, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->get();
    }

    public static function getOrdersByStatus($status)
    {
        return self::with('city', 'district', 'products', 'customer')
            ->when($status > 0, function ($query) use ($status) {
                $query->where('status', $status);
            })->get();
    }

    public static function getOrders($id)
    {
        return self::with('products')->whereId($id)->get();
    }

    public static function getPreorder($orderId)
    {
        return self::with('city', 'district', 'products', 'customer')->where('id', $orderId)->first();
    }

    public static function addOrder($request)
    {
        $preorder = new self();
        $preorder->tms_customer_id = $request->customer_id;
        $preorder->order_type = $request->order_type;
        $preorder->orderer_name = $request->orderer_name;
        $preorder->orderer_phone = $request->orderer_phone;
        $preorder->orderer_email = $request->orderer_email;
        $preorder->weight = $request->weight;
        $preorder->city_id = $request->city_id;
        $preorder->district_id = $request->district_id;
        $preorder->address_description = $request->address_description;
        $preorder->note = $request->note;
        $preorder->save();
        $preorder = self::getPreorder($preorder->id);
        return $preorder;
    }

    public static function editOrder($id, $request)
    {
        $preorder = self::find($id);
        if (is_null($preorder))
            return null;

        $preorder->tms_customer_id = $request->customer_id;
        $preorder->order_type = $request->order_type;
        $preorder->orderer_name = $request->orderer_name;
        $preorder->orderer_phone = $request->orderer_phone;
        $preorder->orderer_email = $request->orderer_email;
        $preorder->weight = $request->weight;
        $preorder->city_id = $request->city_id;
        $preorder->district_id = $request->district_id;
        $preorder->address_description = $request->address_description;
        $preorder->note = $request->note;
        $preorder->save();
        $preorder = self::getPreorder($preorder->id);
        return $preorder;
    }

    public static function deleteOrder($id)
    {
        $preorder = self::find($id);
        if (is_null($preorder))
            return false;

        $preorder->delete();
        return true;
    }

    public static function closeOrder($id)
    {
        $preorder = self::find($id);
        if (is_null($preorder))
            return null;

        $preorder->status = 2;
        $preorder->save();
        return $preorder;
    }
}