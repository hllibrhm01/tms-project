<?php

namespace App\Models\tms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TMSVehicleInspection extends Model
{
    use SoftDeletes;

    protected $table = 'tms_vehicle_inspections';

    protected $fillable = [
        'vehicle_id', 'date', 'cost'
    ];

    public function vehicle()
    {
        return $this->belongsTo(TMSVehicle::class, 'vehicle_id');
    }

    public static function getVehicleInspections($vehicleId)
    {
        return self::with('vehicle')->where('vehicle_id', $vehicleId)->get();
    }

    public static function addVehicleInpsection($vehicleId, $date, $cost)
    {
        $vehicleHasInspection = self::where('date', $date)->first();
        if ($vehicleHasInspection)
            return null;

        $vehicleInspection = new self();
        $vehicleInspection->vehicle_id = $vehicleId;
        $vehicleInspection->date = $date;
        $vehicleInspection->cost = str_replace(',', '.', $cost);
        $vehicleInspection->save();
        return $vehicleInspection;
    }

    public static function updateVehicleInspection($id, $vehicleId, $date, $cost)
    {
        $vehicleInspection = self::find($id);
        if (is_null($vehicleInspection)) {
            $vehicleInspection = new self();
            $vehicleInspection->vehicle_id = $vehicleId;
        }

        $vehicleInspection->date = $date;
        $vehicleInspection->cost = str_replace(',', '.', $cost);
        $vehicleInspection->save();
        return $vehicleInspection;
    }

    public static function deleteVehicleInspection($id)
    {
        $vehicleInspection = self::find($id);
        if (is_null($vehicleInspection))
            return false;

        $vehicleInspection->delete();
        return true;
    }
}
