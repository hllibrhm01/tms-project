<?php

namespace App\Http\Controllers\tms;

use App\Http\Controllers\Controller;
use App\Http\Requests\tms\TMSEquipmentRequest;
use App\Http\Requests\tms\VehicleMaintainRequest;
use App\Models\tms\TMSVehicleMaintain;
use Illuminate\Http\Request;

class VehicleMaintainController extends Controller
{

    public function store(VehicleMaintainRequest $request)
    {
        TMSVehicleMaintain::addVehicleMaintain($request->vehicle_id, $request->date, $request->type, $request->cost, $request->kilometer);
        $maintains = TMSVehicleMaintain::getVehicleMaintains($request->vehicle_id);
        return response()->json((["error" => false, "message" => "Bakım eklendi.", "maintains" => $maintains]));
    }

    public function edit(Request $request)
    {
        if (!$request->exists("id"))
            return response()->json((["error" => true, "message" => "Bakım bulunamadı."]));

        $maintain = TMSVehicleMaintain::find($request->id);
        return response()->json((["error" => false, "message" => "Bakım getirildi.", "maintain" => $maintain]));
    }

    public function update(VehicleMaintainRequest $request)
    {
        if (!$request->exists("id"))
            return response()->json((["error" => true, "message" => "Bakım bulunamadı."]));

        TMSVehicleMaintain::updateVehicleMaintain($request->id, $request->vehicle_id, $request->date, $request->type, $request->kilometer, $request->cost);
        $maintains = TMSVehicleMaintain::getVehicleMaintains($request->vehicle_id);
        return response()->json((["error" => false, "message" => "Bakım güncellendi.", "maintains" => $maintains]));
    }

    public function delete(Request $request)
    {
        if (!$request->exists("id"))
            return response()->json((["error" => true, "message" => "Bakım bulunamadı."]));

        $vehicleId = -1;
        $maintain = TMSVehicleMaintain::find($request->id);
        if (!is_null($maintain)) {
            $vehicleId = $maintain->vehicle_id;
            $maintain->delete();
        }

        if ($vehicleId == -1)
            return response()->json((["error" => true, "message" => "Bakım bulunamadı."]));

        $maintains = TMSVehicleMaintain::getVehicleMaintains($vehicleId);
        return response()->json((["error" => false, "message" => "Bakım silindi.", "maintains" => $maintains]));
    }
}
