<?php

namespace App\Models\tms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TMSCustomerProduct extends Model
{
    use SoftDeletes;

    protected $table = 'tms_customer_products';

    protected $fillable = ['customer_id', 'name', 'price'];

    public static function getCustomerProduct($id)
    {
        return self::find($id);
    }

    public static function getCustomerProducts($customerId)
    {
        return self::where("customer_id", $customerId)->get();
    }

    public static function addCustomerProduct($customerId, $name, $price)
    {

        $product = new self();
        $product->customer_id = $customerId;
        $product->name = strtoupper($name);
        $product->price = str_replace(',', '.', $price);
        $product->save();
        return $product;
    }

    public static function editCustomerProduct($id, $customerId, $name, $price)
    {
        $product = self::find($id);
        if (is_null($product))
            return null;

        $product->customer_id = $customerId;
        $product->name = strtoupper($name);
        $product->price = str_replace(',', '.', $price);
        $product->save();
        return $product;
    }

    public static function deleteCustomerProduct($id)
    {
        $product = self::find($id);
        if (is_null($product))
            return false;

        $product->delete();
        return true;
    }
}
