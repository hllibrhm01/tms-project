<?php

namespace App\Models\tms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TMSOrderStatusChange extends Model
{
    use SoftDeletes;

    const STATUS_RECEIVED = 1;
    const STATUS_ON_VEHICLE = 2;
    const STATUS_INSTALLING = 3;
    const STATUS_INSTALLED = 4;
    const STATUS_PENDING_REVIEW = 5;
    const STATUS_BROKEN = 6;
    const STATUS_COMPLETED = 7;

    protected $table = 'order_status_changes';

    protected $fillable = [
        'order_id', 'note', 'status'
    ];

    public static function getOrderMovements($orderId)
    {
        return self::where('order_id', $orderId)->orderBy('created_at', 'desc')->get();
    }

    public static function addOrderStatusChange($orderId, $status, $note)
    {
        $orderStatusChange = new TMSOrderStatusChange();
        $orderStatusChange->order_id = $orderId;
        $orderStatusChange->note = $note;
        $orderStatusChange->status = $status;
        $orderStatusChange->save();
    }
}
