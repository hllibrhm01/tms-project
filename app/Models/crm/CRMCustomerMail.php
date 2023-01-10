<?php

namespace App\Models\crm;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class CRMCustomerMail extends Model
{
    use SoftDeletes;

    protected $table = 'crm_customer_mails';

    protected $fillable = ['user_id', 'customer_id', 'type', 'body', 'sent_time'];


    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $user = Auth::user();
            $model->user_id = $user->id;
        });
        static::updating(function ($model) {
            $user = Auth::user();
            $model->user_id = $user->id;
        });
        static::deleting(function ($model) {
            $user = Auth::user();
            $model->user_id = $user->id;
        });
    }

    public static function getCustomerMails($customerId)
    {
        return self::where("customer_id", $customerId)->get();
    }

    public static function addCustomerMail($customerId, $type, $body)
    {
        $customerMail = new self();
        $customerMail->customer_id = $customerId;
        $customerMail->type = $type;
        $customerMail->body = $body;
        $customerMail->sent_time = Carbon::now();
        $customerMail->save();
        return $customerMail;
    }

    public static function importCustomerMail($customerId, $type, $body, $sentTime)
    {
        $customerMail = new self();
        $customerMail->customer_id = $customerId;
        $customerMail->type = $type;
        $customerMail->body = $body;
        $customerMail->sent_time = Carbon::parse($sentTime);
        $customerMail->save();
        return $customerMail;
    }
}
