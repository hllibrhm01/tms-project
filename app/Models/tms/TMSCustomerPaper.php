<?php

namespace App\Models\tms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TMSCustomerPaper extends Model
{
    use SoftDeletes;

    protected $table = 'tms_customer_papers';

    protected $fillable = ['customer_id', 'type', 'description', 'path'];


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

        foreach ($papers as $paper) 
            $paper->type = config('constants.paper_types')[$paper->type];
      
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
