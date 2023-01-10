<?php

namespace App\Models\tms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TMSVehicleHGS extends Model
{
    use SoftDeletes;

    protected $table = 'tms_vehicle_hgs';

    protected $fillable = [
        'vehicle_id', 'date', 'cost'
    ];

    public function vehicle()
    {
        return $this->belongsTo(TMSVehicle::class, 'vehicle_id');
    }

    public static function getVehicleHGS($vehicleId)
    {
        return self::with('vehicle')->where('vehicle_id', $vehicleId)->get();
    }

    public static function addVehicleHGS($vehicleId, $date, $cost)
    {
        $vehicleHasHGS = self::where('date', $date)->first();
        if ($vehicleHasHGS)
            return null;

        $hgs = new self();
        $hgs->vehicle_id = $vehicleId;
        $hgs->date = $date;
        $hgs->cost = str_replace(',', '.', $cost);
        $hgs->save();
        return $hgs;
    }

    public static function updateVehicleHGS($id, $vehicleId, $date, $cost)
    {
        $hgs = self::find($id);
        if (is_null($hgs))
            return null;
            
        $hgs->vehicle_id = $vehicleId;
        $hgs->date = $date;
        $hgs->cost = str_replace(',', '.', $cost);
        $hgs->save();
        return $hgs;
    }

    public static function deleteVehicleHGS($id)
    {
        $hgs = self::find($id);
        if (is_null($hgs))
            return false;

        $hgs->delete();
        return true;
    }
}
