<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use SoftDeletes;

    const STATUS_PENDING = 1;
    const STATUS_SENDING = 2;
    const STATUS_SENT = 3;
    const STATUS_FAILED = 4;


    protected $table = 'notifications';

    protected $fillable =  ['order_id',  'order_status',  'name',  'phone', 'email', 'content', 'status', 'result'];

    public static function scopeOrderId($query, $orderId)
    {
        return $query->where("order_id", $orderId);
    }

    public static function scopeOrderStatus($query, $orderStatus)
    {
        return $query->where("order_status", $orderStatus);
    }

    public static function getPendingNotifications($limit)
    {
        return self::where('status', self::STATUS_PENDING)->limit($limit)->get();
    }

    public static function updateStatus($ids)
    {
        return self::whereIn('id', $ids)->update(['status' => self::STATUS_SENDING]);
    }

    public static function addNotification($orderId , $orderStatus , $name, $phone, $email, $content)
    {
        $notification = self::orderId($orderId)->orderStatus($orderStatus)->first();
        if(!is_null($notification))
            return null;
            
        $notification = new self();
        $notification->name = $name;
        $notification->order_id = $orderId;
        $notification->order_status = $orderStatus;
        $notification->phone = $phone;
        $notification->email = $email;
        $notification->content = $content;
        $notification->status = self::STATUS_PENDING;
        $notification->save();
        return $notification;
    }
}
