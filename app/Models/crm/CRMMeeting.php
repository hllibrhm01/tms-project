<?php

namespace App\Models\crm;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class CRMMeeting extends Model
{
    use SoftDeletes;

    protected $table = 'crm_meetings';

    protected $fillable = ['user_id' , 'customer_id', 'type', 'header', 'description', 'schedule_date'];

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

    public function customer()
    {
        return $this->belongsTo(CRMCustomer::class, "customer_id", "id");
    }

    public function notes()
    {
        return $this->hasMany(CRMMeetingNote::class, "meeting_id", "id");
    }

    public static function getAllMeetings()
    {
        return self::with("customer")->get();
    }

    public static function getMeeting($id)
    {
        return self::with("customer")->whereId($id)->first();
    }

    public static function getMeetingByAllFields($customerId, $type, $header, $description, $scheduleDate)
    {
        return self::where("customer_id", $customerId)
            ->where("type", $type)
            ->where("header", $header)
            ->where("description", $description)
            ->where("schedule_date", $scheduleDate)
            ->first();
    }

    public static function getCustomerMeetings($customerId)
    {
        return self::with("customer")->where("customer_id", $customerId)->get();
    }

    public static function addMeeting($customerId, $type, $header, $description, $scheduleDate)
    {
        $meeting = self::getMeetingByAllFields($customerId, $type, $header, $description, $scheduleDate);
        if (!is_null($meeting))
            return null;

        $meeting = new self();
        $meeting->customer_id = $customerId;
        $meeting->type = $type;
        $meeting->header = $header;
        $meeting->description = $description;
        $meeting->schedule_date = $scheduleDate;
        $meeting->save();
        return $meeting;
    }

    public static function editMeeting($id, $customerId, $type, $header, $description, $scheduleDate)
    {
        $meeting = self::getMeetingByAllFields($customerId, $type, $header, $description, $scheduleDate);
        if (!is_null($meeting))
            return null;

        $meeting = self::find($id);
        $meeting->customer_id = $customerId;
        $meeting->type = $type;
        $meeting->header = $header;
        $meeting->description = $description;
        $meeting->schedule_date = $scheduleDate;
        $meeting->save();
        return $meeting;
    }

    public static function deleteMeeting($id)
    {
        $meeting = self::find($id);
        if (is_null($meeting))
            return false;

        $meeting->delete();
        return true;
    }
}
