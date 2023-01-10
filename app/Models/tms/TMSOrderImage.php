<?php

namespace App\Models\tms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TMSOrderImage extends Model
{
    use SoftDeletes;

    protected $table = 'tms_orders_images';

    protected $fillable = [
        'order_id', 'image_path', 'status'
    ];

    public static function getOrderImagesAll($orderId)
    {
        //return self::with('order')->where('order_id', $orderId)->get();
        return self::where('order_id', $orderId)->get();
    }

    public static function addImage($orderId , $imagePath, $status)
    {
        $orderImage = new TMSOrderImage();
        $orderImage->order_id = $orderId;
        $orderImage->image_path = $imagePath;
        $orderImage->status = $status;
        $orderImage->save();
    }

    public static function getOrderImages($orderId)
    {
        return self::where('order_id', $orderId)->get();
    }
}
