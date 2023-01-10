<?php

namespace App\Models\tms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TMSVehicleService extends Model
{
    use SoftDeletes;

    protected $table = 'tms_vehicle_services';

    protected $fillable = [
        'author',  'name', 'phone', 'email', 'address'
    ];

    public static function getVehicleService($id)
    {
        return self::whereId($id)->first();
    }

    public static function addVehicleService($request)
    {
        $vehicleHasService = self::where('name', $request->name)->first();
        if ($vehicleHasService)
            return null;

        $vehicleService = new self();
        $vehicleService->author = strtoupper($request->author);
        $vehicleService->name = strtoupper($request->name);
        $vehicleService->phone = $request->phone;
        $vehicleService->email = strtolower($request->email);
        $vehicleService->address = strtoupper($request->address);
        $vehicleService->save();
        return $vehicleService;
    }

    public static function editVehicleService($id, $request)
    {
        $vehicleService = self::find($id);
        if (is_null($vehicleService)) {
            $vehicleService = new self();
            $vehicleService->id = $id;
        }

        $vehicleService->author = strtoupper($request->author);
        $vehicleService->name = strtoupper($request->name);
        $vehicleService->phone = $request->phone;
        $vehicleService->email = strtolower($request->email);
        $vehicleService->address = strtoupper($request->address);
        $vehicleService->save();
        return $vehicleService;
    }

    public static function deleteVehicleService($id)
    {
        $vehicleService = self::find($id);
        if (is_null($vehicleService))
            return false;

        $vehicleService->delete();
        return true;
    }

    public static function search($request)
    {
        return self::when(!empty($request->name), function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->name . '%');
        })->get();
    }
}
