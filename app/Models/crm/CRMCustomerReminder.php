<?php

namespace App\Models\crm;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class CRMCustomerReminder extends Model
{
    use SoftDeletes;

    protected $table = 'crm_customer_reminders';

    protected $fillable = ['user_id' , 'customer_id', 'email', 'abstract', 'body' , 'is_completed', 'finish_time'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->user_id = Auth::check() ? Auth::user()->id : 1;
        });
        static::updating(function ($model) {
            $model->user_id = Auth::check() ? Auth::user()->id : 1;
        });
        static::deleting(function ($model) {
            $model->user_id = Auth::check() ? Auth::user()->id : 1;
        });
    }
    
    public static function getCustomerReminders($customerId)
    {
        return self::where("customer_id" , $customerId)->orderBy("finish_time")->get();
    }

    public static function getUncompletedReminders()
    {
        return self::where("is_completed" , 0)->where("finish_time" , "<" , Carbon::now())->get();
    }

    public static function addCustomerReminder($customerId, $email , $abstract , $body , $isCompleted , $finishTime)
    {
        $reminder = new self();
        $reminder->customer_id = $customerId;
        $reminder->email = $email;
        $reminder->abstract = $abstract;
        $reminder->body = $body;
        $reminder->is_completed = $isCompleted;
        $reminder->finish_time = $finishTime;
        $reminder->save();
        return $reminder;
    }

    
    public static function editCustomerReminder($id , $customerId, $email , $abstract , $body , $isCompleted, $finishTime)
    {
        $reminder = self::find($id);
        $reminder->customer_id = $customerId;
        $reminder->email = $email;
        $reminder->abstract = $abstract;
        $reminder->body = $body;
        $reminder->is_completed = $isCompleted;
        $reminder->finish_time = $finishTime;
        $reminder->save();
        return $reminder;
    }
}

