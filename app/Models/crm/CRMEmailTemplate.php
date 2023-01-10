<?php

namespace App\Models\crm;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class CRMEmailTemplate extends Model
{
    use SoftDeletes;

    protected $table = 'crm_email_templates';

    protected $fillable = ['user_id' , 'type', 'name', 'subject', 'body'];

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

    public static function getAllEmailTemplates()
    {
        return self::all();
    }

    public static function getEmailTemplate($id)
    {
        return self::whereId($id)->first();
    }


    public static function getEmailTemplateByName($name)
    {
        return self::where("name", $name)->first();
    }

    public static function addEmailTemplate($type, $name,  $subject, $body)
    {
        $emailTemplate = self::getEmailTemplateByName($name);
        if ($emailTemplate != null)
            return null;

        $emailTemplate = new self();
        $emailTemplate->type = $type;
        $emailTemplate->subject = $subject;
        $emailTemplate->name = $name;
        $emailTemplate->body = $body;
        $emailTemplate->save();
        return $emailTemplate;
    }

    public static function editEmailTemplate($id, $type, $name, $subject, $body)
    {
        $emailTemplate = self::find($id);
        if (is_null($emailTemplate))
            return null;

        $emailTemplate->type = $type;
        $emailTemplate->subject = $subject;
        $emailTemplate->name = $name;
        $emailTemplate->body = $body;
        $emailTemplate->save();
        return $emailTemplate;
    }

    public static function deleteEmailTemplate($id)
    {
        $emailTemplate = self::find($id);
        if (is_null($emailTemplate))
            return false;

        $emailTemplate->delete();
        return true;
    }
}
