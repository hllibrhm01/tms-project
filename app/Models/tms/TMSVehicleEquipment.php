<?php

namespace App\Models\tms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TMSVehicleEquipment extends Model
{
    use SoftDeletes;

    protected $table = 'tms_vehicle_equipments';

    protected $fillable = [
        'vehicle_id', 'equipment_id', 'count'
    ];

    public function vehicle()
    {
        return $this->belongsTo(TMSVehicle::class, 'vehicle_id');
    }

    public function equipment()
    {
        return $this->belongsTo(TMSEquipment::class, 'equipment_id');
    }

    public static function checkVehicleHasEquipment($vehicleId, $equipmentId)
    {
        $equipment = self::where('vehicle_id', $vehicleId)->where('equipment_id', $equipmentId)->first();
        if (is_null($equipment))
            return false;
        return true;
    }

    public static function getVehicleEquipments($vehicleId)
    {
        return self::with('equipment')->where('vehicle_id', $vehicleId)->get();
    }

    public static function getEquipment($equipmentId)
    {
        return self::with('equipment')->where('id', $equipmentId)->first();
    }

    public static function addVehicleEquipment($vehicleId, $equipmentId, $count)
    {
        $vehicleHasEquipment = self::checkVehicleHasEquipment($vehicleId, $equipmentId);
        if ($vehicleHasEquipment)
            return null;

        $vehicleEquipment = new self();
        $vehicleEquipment->vehicle_id = $vehicleId;
        $vehicleEquipment->equipment_id = $equipmentId;
        $vehicleEquipment->count = $count;
        $vehicleEquipment->save();
        return $vehicleEquipment;
    }

    public static function updateVehicleEquipment($id, $vehicleId, $equipmentId, $count)
    {
        $vehicleHasEquipment = self::checkVehicleHasEquipment($vehicleId, $equipmentId);
        if ($vehicleHasEquipment)
            return null;

        $vehicleEquipment = self::find($id);
        if (is_null($vehicleEquipment)) {
            $vehicleEquipment = new self();
            $vehicleEquipment->vehicle_id = $vehicleId;
        }

        $vehicleEquipment->equipment_id = $equipmentId;
        $vehicleEquipment->count = $count;
        $vehicleEquipment->save();
        return $vehicleEquipment;
    }

    public static function deleteVehicleEquipment($id)
    {
        $vehicleEquipment = self::find($id);
        if (is_null($vehicleEquipment))
            return false;

        $vehicleEquipment->delete();
        return true;
    }
}
