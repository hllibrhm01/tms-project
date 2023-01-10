<?php

namespace App\Http\Controllers\tms;

use App\Http\Controllers\Controller;
use App\Http\Requests\tms\VehicleInspectionRequest;
use App\Models\tms\TMSVehicleInspection;
use Illuminate\Http\Request;

class VehicleInspectionController extends Controller
{
    public function store(VehicleInspectionRequest $request)
    {
        TMSVehicleInspection::addVehicleInpsection($request->vehicle_id, $request->date, $request->cost);
        $inspections = TMSVehicleInspection::getVehicleInspections($request->vehicle_id);
        return response()->json((["error" => false, "message" => "Muayene eklendi.", "inspections" => $inspections]));
    }

    public function edit(Request $request)
    {
        if (!$request->exists("id"))
            return response()->json((["error" => true, "message" => "Muayene bulunamadı."]));

        $inspection = TMSVehicleInspection::find($request->id);
        return response()->json((["error" => false, "message" => "Ekipman getirildi.", "inspection" => $inspection]));
    }

    public function update(VehicleInspectionRequest $request)
    {
        if (!$request->exists("id"))
            return response()->json((["error" => true, "message" => "Muayene bulunamadı."]));

        TMSVehicleInspection::updateVehicleInspection($request->id, $request->vehicle_id, $request->date, $request->cost);
        $inspections = TMSVehicleInspection::getVehicleInspections($request->vehicle_id);
        return response()->json((["error" => false, "message" => "Muayene güncellendi.", "inspections" => $inspections]));
    }

    public function delete(Request $request)
    {
        if (!$request->exists("id"))
            return response()->json((["error" => true, "message" => "Muayene bulunamadı."]));

        $vehicleId = -1;
        $inspection = TMSVehicleInspection::find($request->id);
        if (!is_null($inspection)) {
            $vehicleId = $inspection->vehicle_id;
            $inspection->delete();
        }

        if ($vehicleId == -1)
            return response()->json((["error" => true, "message" => "Muayene bulunamadı."]));

        $inspections = TMSVehicleInspection::getVehicleInspections($vehicleId);
        return response()->json((["error" => false, "message" => "Muayene silindi.", "inspections" => $inspections]));
    }
}
