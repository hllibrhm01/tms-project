<?php

namespace App\Models\crm;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class CRMMultiEmail extends Model
{
    use SoftDeletes;

    protected $table = 'crm_sent_multi_emails';

    protected $fillable = ['user_id' , 'type', 'template_id', 'group_name', 'sent_time'];

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

    public static function addMultiEmail($type, $templateId, $groupName, $sentTime)
    {
        $multiEmail = new self();
        $multiEmail->type = $type;
        $multiEmail->template_id = $templateId;
        $multiEmail->group_name = $groupName;
        $multiEmail->sent_time = $sentTime;
        $multiEmail->save();
        return $multiEmail;
    }
}
