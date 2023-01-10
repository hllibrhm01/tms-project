<?php

namespace App\Models\tms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TMSVehicleIncome extends Model
{
    use SoftDeletes;

    protected $table = 'tms_vehicle_incomes';

    protected $fillable = [
        'vehicle_id', 'date', 'income'
    ];

    public function vehicle()
    {
        return $this->belongsTo(TMSVehicle::class, 'vehicle_id');
    }

    public static function getVehicleIncomes($vehicleId)
    {
        return self::with('vehicle')->where('vehicle_id', $vehicleId)->get();
    }

    public static function addVehicleIncome($vehicleId, $date, $income)
    {
        $vehicleHasIncome = self::where('date', $date)->first();
        if ($vehicleHasIncome)
            return null;

        $vehicleIncome = new self();
        $vehicleIncome->vehicle_id = $vehicleId;
        $vehicleIncome->date = $date;
        $vehicleIncome->income= str_replace(',', '.', $income);
        $vehicleIncome->save();
        return $vehicleIncome;
    }

    public static function updateVehicleIncome($id, $vehicleId, $date, $income)
    {
        $vehicleIncome = self::find($id);
        if (is_null($vehicleIncome)) {
            $vehicleIncome = new self();
            $vehicleIncome->vehicle_id = $vehicleId;
        }

        $vehicleIncome->date = $date;
        $vehicleIncome->income = str_replace(',', '.', $income);
        $vehicleIncome->save();
        return $vehicleIncome;
    }

    public static function deleteVehicleIncome($id)
    {
        $vehicleIncome = self::find($id);
        if (is_null($vehicleIncome))
            return false;

        $vehicleIncome->delete();
        return true;
    }

}
