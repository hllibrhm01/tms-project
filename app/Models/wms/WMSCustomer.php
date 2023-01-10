<?php

namespace App\Models\wms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WMSCustomer extends Model
{
    use HasFactory;

    protected $table = "wms_customers";
    protected $fillable = [
        'type',
        'company_name',
        'tax_number',
        'authorized_person',
        'phone',
        'email',
        'address',
        'note'
    ];


    public static function addCustomer($request)
    {
        $wmsCustomers = new self();
        $wmsCustomers->type = $request->type;
        $wmsCustomers->company_name = strtoupper($request->company_name);
        $wmsCustomers->tax_number = $request->tax_number;
        $wmsCustomers->authorized_person = strtoupper($request->authorized_person);
        $wmsCustomers->phone= $request->phone;
        $wmsCustomers->email= strtolower($request->email);
        $wmsCustomers->address= strtoupper($request->address);
        $wmsCustomers->note= $request->note;
        $wmsCustomers->save();
        return $wmsCustomers;
    }

    public static function editCustomer($id, $request)
    {
        $wmsCustomer = self::find($id);
        if(is_null($id))
            return null;

        $wmsCustomer->type = $request->type;
        $wmsCustomer->company_name = strtoupper($request->company_name);
        $wmsCustomer->tax_number = $request->tax_number;
        $wmsCustomer->authorized_person = $request->authorized_person;
        $wmsCustomer->authorized_person = strtoupper($request->authorized_person);
        $wmsCustomer->phone= $request->phone;
        $wmsCustomers->email= strtolower($request->email);
        $wmsCustomers->address= strtoupper($request->address);
        $wmsCustomer->note= $request->note;
        $wmsCustomer->save();
        return $wmsCustomer;
    }

    public static function deleteCustomer($id)
    {
        $wmsCustomer = self::find($id);

        if(is_null($wmsCustomer))
            return false;

        $wmsCustomer->delete();
        return true;
    }

}
