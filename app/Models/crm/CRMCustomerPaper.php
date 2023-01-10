<?php

namespace App\Models\crm;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class CRMCustomerPaper extends Model
{
    use SoftDeletes;

    protected $table = 'crm_customer_papers';

    protected $fillable = ['user_id' , 'customer_id', 'type', 'description', 'path'];

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

    public static function getCustomerPaper($id)
    {
        return self::find($id);
    }

    public static function getCustomerPapers($customerId)
    {
        return self::where("customer_id", $customerId)->get();
    }

    public static function getCustomerPapersToDisplay($customerId)
    {
        $papers = self::where("customer_id", $customerId)->get();

        foreach ($papers as $paper) {
            $paper->type = config('constants.paper_types')[$paper->type];
            $paper->path = env('DO_SPACE_URL') . "/" . $paper->path;
        }

        return $papers;
    }

    public static function addCustomerPaper($customerId, $type, $description, $path)
    {

        $paper = new self();
        $paper->customer_id = $customerId;
        $paper->type = $type;
        $paper->description = $description;
        $paper->path = $path;
        $paper->save();
        return $paper;
    }

    public static function editCustomerPaper($id, $customerId, $type, $description, $path)
    {
        $paper = self::find($id);
        if (is_null($paper))
            return null;

        $paper->customer_id = $customerId;
        $paper->type = $type;
        $paper->description = $description;
        $paper->path = $path;
        $paper->save();
        return $paper;
    }
}
