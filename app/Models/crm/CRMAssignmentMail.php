<?php

namespace App\Models\crm;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class CRMAssignmentMail extends Model
{
    use SoftDeletes;

    protected $table = 'crm_assignment_mails';

    protected $fillable = ['user_id', 'assignment_id', 'type', 'body', 'sent_time'];

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

    public static function getAssignmentMails($assignmentId)
    {
        return self::where("assignment_id", $assignmentId)->get();
    }

    public static function addAssignmentMail($assignmentId, $type, $body)
    {
        $customerMail = new self();
        $customerMail->assignment_id = $assignmentId;
        $customerMail->type = $type;
        $customerMail->body = $body;
        $customerMail->sent_time = Carbon::now();
        $customerMail->save();
        return $customerMail;
    }

    public static function importAssignmentMail($assignmentId, $type, $body, $sentTime)
    {
        $customerMail = new self();
        $customerMail->assignment_id = $assignmentId;
        $customerMail->type = $type;
        $customerMail->body = $body;
        $customerMail->sent_time = Carbon::parse($sentTime);
        $customerMail->save();
        return $customerMail;
    }
}
