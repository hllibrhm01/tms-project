<?php

namespace App\Models\tms;

use Illuminate\Database\Eloquent\Model;

class TMSSurvey extends Model
{
    protected $table = 'tms_surveys';

    protected $fillable = [
        'vehicle_id', 'order_id', 'etiquette_point', 'safefy_rule_point',
        'work_area_cleaning_point', 'service_quality_point'
    ];

    public function scopeVehicleId($query, $vehicleId)
    {
        return $query->where("vehicle_id", $vehicleId);
    }

    public function scopeOrderId($query, $orderId)
    {
        return $query->where("order_id", $orderId);
    }

    public static function getVehicleSurveys($vehicleId)
    {
        return self::vehicleId($vehicleId)->get();
    }

    public static function isSurveyAnswered($vehicleId, $orderId)
    {
        return self::vehicleId($vehicleId)->orderId($orderId)->count() != 0;
    }

    public static function addSurvey($orderId, $vehicleId, $etiquettePoint, $safetyRulePoint, $workAreaCleaningPoint, $serviceQualityPoint)
    {
        $survey = self::vehicleId($vehicleId)->orderId($orderId)->first();
        if (!is_null($survey))
            return null;

        $survey = new self();
        $survey->vehicle_id = $vehicleId;
        $survey->order_id = $orderId;
        $survey->etiquette_point = $etiquettePoint;
        $survey->safefy_rule_point = $safetyRulePoint;
        $survey->work_area_cleaning_point = $workAreaCleaningPoint;
        $survey->service_quality_point = $serviceQualityPoint;
        $survey->save();
        return $survey;
    }
}
