<?php

namespace App\Models\tms;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Exception;

class TMSVehicle extends Model
{
    use SoftDeletes;

    protected $table = "tms_vehicles";
    protected $fillable = [
        'driver_id',
        'dedicated_customer_id',
        'relations_name_surname',
        'relations_phone',
        'degree_of_proximity',
        'trademark',
        'model',
        'licence_plate',
        'model_date',
        'fixed_address',
        'kilometer',
        'ownership',
        'care_kilometer',
        'inspection_date',
        'average_fuel_consumption',
        'capacity',
        'width',
        'size',
        'height',
        'vehicle_tracking_system',
        'vehicle_recognition',
        'maintenance_agreement_signature',
        'embezzlement_form',
        'service_description',
        'service_id',
        'supplier_id',
        'lat',
        'lng'
    ];

    public function driver()
    {
        return  $this->belongsTo(User::class, 'driver_id');
    }

    public function service()
    {
        return  $this->belongsTo(TMSVehicleService::class, 'service_id');
    }

    public function hgs()
    {
        return $this->hasMany(TMSVehicleHGS::class, 'vehicle_id');
    }

    public function equipments()
    {
        return $this->hasMany(TMSVehicleEquipment::class, 'vehicle_id');
    }

    public function inspections()
    {
        return $this->hasMany(TMSVehicleInspection::class, 'vehicle_id');
    }

    public function maintains()
    {
        return $this->hasMany(TMSVehicleMaintain::class, 'vehicle_id');
    }

    public function incomes()
    {
        return $this->hasMany(TMSVehicleIncome::class, 'vehicle_id');
    }

    public function papers()
    {
        return $this->hasMany(TMSVehiclePaper::class, 'vehicle_id');
    }

    public function expenses()
    {
        return $this->hasMany(TMSVehicleExpense::class, 'vehicle_id')->orderBy('date', 'desc');
    }

    public static function getVehicle($id)
    {
        return self::with('driver', 'expenses', 'equipments.equipment', 'hgs', 'inspections', 'maintains', 'incomes', 'papers', 'service')
            ->whereId($id)->first();
    }

    public static function getVehicleId($driverId)
    {
        return self::where('driver_id', $driverId)->first();
    }

    public static function getAllVehicles()
    {
        return self::with('driver')->get();
    }

    public static function addVehicle($request)
    {
        $existVehicle = self::where('licence_plate', $request->licence_plate)->first();
        if (!is_null($existVehicle))
            return null;

        if ($request->dedicated_customer_id  == 0)
            $request->dedicated_customer_id  = null;

        $vehicle = new self();
        $vehicle->driver_id = $request->driver_id;
        $vehicle->dedicated_customer_id = $request->dedicated_customer_id;
        $vehicle->relations_name_surname = strtoupper($request->relations_name_surname);
        $vehicle->relations_phone = $request->relations_phone;
        $vehicle->degree_of_proximity = strtoupper($request->degree_of_proximity);
        $vehicle->trademark = strtoupper($request->trademark);
        $vehicle->model = strtoupper($request->model);
        $vehicle->licence_plate = strtoupper($request->licence_plate);
        $vehicle->model_date = $request->model_date;
        $vehicle->fixed_address = $request->fixed_address;
        $vehicle->kilometer = $request->kilometer;
        $vehicle->ownership = $request->ownership;
        $vehicle->care_kilometer = $request->care_kilometer;
        $vehicle->inspection_date = $request->inspection_date;
        $vehicle->average_fuel_consumption = str_replace(',', '.', $request->average_fuel_consumption);
        $vehicle->capacity = str_replace(',', '.', $request->capacity);
        $vehicle->width = str_replace(',', '.', $request->width);
        $vehicle->size = str_replace(',', '.', $request->size);
        $vehicle->height = str_replace(',', '.', $request->height);
        $vehicle->vehicle_tracking_system = $request->has('vehicle_tracking_system');
        $vehicle->vehicle_recognition = $request->has('vehicle_recognition');
        $vehicle->maintenance_agreement_signature = $request->has('maintenance_agreement_signature');
        $vehicle->embezzlement_form = $request->has('embezzlement_form');
        $vehicle->supplier_id = $request->supplier_id;
        $vehicle->lat = $request->lat;
        $vehicle->lng = $request->lng;

        if ($request->service_id == null) {
            $vehicle->service_description = 0;
        } else {
            $vehicle->service_description = 1;
        }
        if ($request->has('service_description') == false) {
            $vehicle->service_id = null;
        } else {
            $vehicle->service_id = $request->service_id;
        }
        $vehicle->save();
        $vehicle = self::getVehicle($vehicle->id);
        return $vehicle;
    }

    public static function editVehicle($id, $request)
    {
        $existVehicle = self::where('licence_plate', $request->licence_plate)->first();
        if ($existVehicle != null && $existVehicle->id != $id)    return null;

        $vehicle = self::find($id);
        if ($vehicle == null)
            return null;

        if ($request->dedicated_customer_id  == 0)
            $request->dedicated_customer_id  = null;

        $vehicle->driver_id = $request->driver_id;
        $vehicle->dedicated_customer_id = $request->dedicated_customer_id;
        $vehicle->relations_name_surname = strtoupper($request->relations_name_surname);
        $vehicle->relations_phone = $request->relations_phone;
        $vehicle->degree_of_proximity = strtoupper($request->degree_of_proximity);
        $vehicle->trademark = strtoupper($request->trademark);
        $vehicle->model = strtoupper($request->model);
        $vehicle->licence_plate = strtoupper($request->licence_plate);
        $vehicle->model_date = $request->model_date;
        $vehicle->fixed_address = $request->fixed_address;
        $vehicle->kilometer = $request->kilometer;
        $vehicle->ownership = $request->ownership;
        $vehicle->care_kilometer = $request->care_kilometer;
        $vehicle->inspection_date = $request->inspection_date;
        $vehicle->average_fuel_consumption = str_replace(',', '.', $request->average_fuel_consumption);
        $vehicle->capacity = str_replace(',', '.', $request->capacity);
        $vehicle->width = str_replace(',', '.', $request->width);
        $vehicle->size = str_replace(',', '.', $request->size);
        $vehicle->height = str_replace(',', '.', $request->height);
        $vehicle->vehicle_tracking_system = $request->has('vehicle_tracking_system');
        $vehicle->vehicle_recognition = $request->has('vehicle_recognition');
        $vehicle->maintenance_agreement_signature = $request->has('maintenance_agreement_signature');
        $vehicle->embezzlement_form = $request->has('embezzlement_form');
        $vehicle->supplier_id = $request->supplier_id;
        $vehicle->lat = $request->lat;
        $vehicle->lng = $request->lng;
        if ($request->service_id == null) {
            null;
        } else {
            $vehicle->service_description = $request->has('service_description');
        }
        if ($request->has('service_description') == false) {
            $vehicle->service_id = null;
        } else {
            $vehicle->service_id = $request->service_id;
        }
        $vehicle->save();
        $vehicle = self::getVehicle($vehicle->id);
        return $vehicle;
    }

    public static function deleteVehicle($id)
    {
        $vehicle = self::find($id);

        if (is_null($vehicle))
            return false;

        $vehicle->delete();
        return true;
    }

    public static function search($request)
    {
        return self::with('driver')
            ->when(!empty($request->licence_plate), function ($query) use ($request) {
                $query->where('licence_plate', 'like', '%' . $request->licence_plate . '%');
            })->get();
    }

    public static function updateVehicleLocationById($id, $data)
    {
        TMSVehicle::where('id', $id)->update($data);
    }

    public static function getVehicleLocation($vehicleId, $orderId)
    {
        $data = self::select('lat', 'lng')
            ->join('tms_vehicles_plans', 'tms_vehicles.id', '=', 'tms_vehicles_plans.vehicle_id')
            ->where('tms_vehicles_plans.order_id', '=', $orderId)
            ->first();
        return $data;
    }

    public static function getVehicleStats($vehicleId)
    {
        $stats = [
            "etiquette_point" => 0,
            "safefy_rule_point" => 0,
            "work_area_cleaning_point" => 0,
            "service_quality_point" => 0,
        ];
        try {
            $vehiclePoints = TMSSurvey::getVehicleSurveys($vehicleId);
            $count = $vehiclePoints->count();
            if ($count > 0) {
                $etiquettePoint = $vehiclePoints->sum('etiquette_point');
                $safetyRulePoint = $vehiclePoints->sum('safefy_rule_point');
                $workAreaCleaningPoint = $vehiclePoints->sum('work_area_cleaning_point');
                $serviceQualityPoint = $vehiclePoints->sum('service_quality_point');

                $stats = [
                    "etiquette_point" => round(($etiquettePoint / $count), 2),
                    "safefy_rule_point" => round(($safetyRulePoint / $count), 2),
                    "work_area_cleaning_point" => round(($workAreaCleaningPoint / $count), 2),
                    "service_quality_point" => round(($serviceQualityPoint / $count), 2),
                ];
            }
        } catch (Exception $e) {
        }
        return $stats;
    }
}
