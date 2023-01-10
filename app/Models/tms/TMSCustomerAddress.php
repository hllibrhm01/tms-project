<?php

namespace App\Models\tms;

use App\Models\City;
use App\Models\District;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TMSCustomerAddress extends Model
{
    use SoftDeletes;

    protected $table = "tms_customer_addresses";

    protected $fillable = [
        'customer_id', 'city_id', 'district_id', 'address', 'is_invoice_address'
    ];

    public function city()
    {
        return  $this->belongsTo(City::class, 'city_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public static function getOrdersByStatus($id)
    {
        return self::with('city', 'district', 'customer')->where('status', $id)->get();
    }

    public function customer()
    {
        return $this->belongsTo(TMSCustomer::class, 'customer_id');
    }

    public static function getCustomerAddresses($customerId)
    {
        return self::with('customer', 'city', 'district')->where('customer_id', $customerId)->get();
    }

    public static function getAddress($cityId)
    {
        return self::with('city')->where('id', $cityId)->first();
    }

    public static function hasInvoiceAddress($customerId)
    {
        return self::where("customer_id",  $customerId)->where("is_invoice_address", 1)->count() > 0;
    }

    public static function addCustomerAddress($customerId, $cityId, $districtId, $address, $isInvoiceAddress)
    {
        $customerHasAddress = self::where('city_id', $cityId)
            ->where('district_id', $districtId)
            ->where('address', $address)
            ->first();

        if ($customerHasAddress)
            return null;

        $hasInvoiceAdress = self::hasInvoiceAddress($customerId);
        if ($hasInvoiceAdress) 
            self::where("customer_id",  $customerId)->update(["is_invoice_address" => 0]);

        $customerAddress = new self();
        $customerAddress->customer_id = $customerId;
        $customerAddress->city_id = $cityId;
        $customerAddress->district_id = $districtId;
        $customerAddress->address = strtoupper($address);
        $customerAddress->is_invoice_address = $isInvoiceAddress;
        $customerAddress->save();
        return $customerAddress;
    }

    public static function updateCustomerAddress($id, $customerId, $cityId, $districtId, $address, $isInvoiceAddress)
    {
        $customerAddress = self::find($id);
        if (is_null($customerAddress)) {
            $customerAddress = new self();
        }

        $hasInvoiceAdress = self::hasInvoiceAddress($customerId);
        if ($hasInvoiceAdress) {
            if ($isInvoiceAddress)
                self::where("customer_id",  $customerId)->update(["is_invoice_address" => 0]);
        } else
            $isInvoiceAddress = true;

        $customerAddress->customer_id = $customerId;
        $customerAddress->city_id = $cityId;
        $customerAddress->district_id = $districtId;
        $customerAddress->address = strtoupper($address);
        $customerAddress->is_invoice_address = $isInvoiceAddress;
        $customerAddress->save();
        return $customerAddress;
    }

    public static function deleteCustomerAddress($id)
    {
        $address = self::find($id);
        if (is_null($address))
            return false;

        $address->delete();
        return true;
    }
}
