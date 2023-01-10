<?php

namespace App\Models\tms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TMSVehicleSupplier extends Model
{
    use SoftDeletes;

    protected $table = 'tms_vehicle_suppliers';

    protected $fillable = [
        'author',  'name', 'phone', 'email', 'address'
    ];

    public static function getVehicleSupplier($id)
    {
        return self::whereId($id)->first();
    }

    public static function addVehicleSupplier($request)
    {
        $vehicleHasService = self::where('name', $request->name)->first();
        if ($vehicleHasService)
            return null;

        $supplier = new self();
        $supplier->author = strtoupper($request->author);
        $supplier->name = strtoupper($request->name);
        $supplier->phone = $request->phone;
        $supplier->email = strtolower($request->email);
        $supplier->address = strtoupper($request->address);
        $supplier->save();
        return $supplier;
    }

    public static function editVehicleSupplier($id, $request)
    {
        $supplier = self::find($id);
        if (is_null($supplier)) {
            $supplier = new self();
            $supplier->id = $id;
        }

        $supplier->author = strtoupper($request->author);
        $supplier->name = strtoupper($request->name);
        $supplier->phone = $request->phone;
        $supplier->email = strtolower($request->email);
        $supplier->address = strtoupper($request->address);
        $supplier->save();
        return $supplier;
    }

    public static function deleteVehicleSupplier($id)
    {
        $supplier = self::find($id);
        if (is_null($supplier))
            return false;

        $supplier->delete();
        return true;
    }

    public static function search($request)
    {
        return self::when(!empty($request->name), function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->name . '%');
        })->get();
    }
}
