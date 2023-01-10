<?php

namespace App\Models\tms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TMSOrderProduct extends Model
{
    use SoftDeletes;

    protected $table = 'tms_order_products';

    protected $fillable = [
        'order_id', 'product_id', 'count'
    ];

    public function order()
    {
        return $this->belongsTo(TMSOrder::class, 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(TMSCustomerProduct::class, 'product_id');
    }

    public static function scopeProductId($query, $productId)
    {
        return $query->where("product_id", $productId);
    }

    public static function scopeOrderId($query, $orderId)
    {
        return $query->where("order_id", $orderId);
    }

    public static function deleteOrderProducts($orderId)
    {
        self::orderId($orderId)->delete();
    }

    public static function addOrderProducts($orderId, $productId, $count)
    {
        $orderProduct = new self();
        $orderProduct->order_id = $orderId;
        $orderProduct->product_id = $productId;
        $orderProduct->count = $count;
        $orderProduct->save();
        return $orderProduct;
    }
}
