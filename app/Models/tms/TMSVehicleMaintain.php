<?php

namespace App\Models\tms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TMSVehicleMaintain extends Model
{
    use SoftDeletes;

    protected $table = 'tms_vehicle_maintains';

    protected $fillable = [
        'vehicle_id', 'date', 'type', 'kilometer', 'cost'
    ];
    public function vehicle()
    {
        return $this->belongsTo(TMSVehicle::class, 'vehicle_id');
    }

    public static function getVehicleMaintains($vehicleId)
    {
        return self::with('vehicle')->where('vehicle_id', $vehicleId)->get();
    }

    public static function addVehicleMaintain($vehicleId, $date, $type, $kilometer, $cost)
    {
        $vehicleHasMaintain = self::where('date', $date)->first();
        if ($vehicleHasMaintain)
            return null;

        $vehicleMaintain = new self();
        $vehicleMaintain->vehicle_id = $vehicleId;
        $vehicleMaintain->date = $date;
        $vehicleMaintain->type= $type;
        $vehicleMaintain->kilometer= $kilometer;
        $vehicleMaintain->cost = str_replace(',', '.', $cost);
        $vehicleMaintain->save();
        return $vehicleMaintain;
    }

    public static function updateVehicleMaintain($id, $vehicleId, $date, $type, $kilometer, $cost)
    {
        $vehicleMaintain = self::find($id);
        if (is_null($vehicleMaintain)) {
            $vehicleMaintain = new self();
            $vehicleMaintain->vehicle_id = $vehicleId;
        }

        $vehicleMaintain->date = $date;
        $vehicleMaintain->type= $type;
        $vehicleMaintain->kilometer= $kilometer;
        $vehicleMaintain->cost = str_replace(',', '.', $cost);
        $vehicleMaintain->save();
        return $vehicleMaintain;
    }

    public static function deleteVehicleInspection($id)
    {
        $vehicleMaintain = self::find($id);
        if (is_null($vehicleMaintain))
            return false;

        $vehicleMaintain->delete();
        return true;
    }
}
