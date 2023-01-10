<?php

namespace App\Http\Controllers\tms;

use App\Http\Controllers\Controller;
use App\Http\Requests\tms\TMSEquipmentRequest;
use App\Models\tms\TMSVehicleEquipment;
use Illuminate\Http\Request;

class VehicleEquipmentController extends Controller
{
    public function store(TMSEquipmentRequest $request)
    {
        TMSVehicleEquipment::addVehicleEquipment($request->vehicle_id, $request->equipment_id, $request->count);
        $equipments = TMSVehicleEquipment::getVehicleEquipments($request->vehicle_id);
        return response()->json((["error" => false, "message" => "Ekipman eklendi.", "equipments" => $equipments]));
    }

    public function edit(Request $request)
    {
        if (!$request->exists("id"))
            return response()->json((["error" => true, "message" => "Ekipman bulunamadı."]));

        $equipment = TMSVehicleEquipment::getEquipment($request->id);
        return response()->json((["error" => false, "message" => "Ekipman getirildi.", "equipment" => $equipment]));
    }

    public function update(TMSEquipmentRequest $request)
    {
        if (!$request->exists("id"))
            return response()->json((["error" => true, "message" => "Ekipman bulunamadı."]));

        TMSVehicleEquipment::updateVehicleEquipment($request->id, $request->vehicle_id, $request->equipment_id, $request->count);
        $equipments = TMSVehicleEquipment::getVehicleEquipments($request->vehicle_id);
        return response()->json((["error" => false, "message" => "Ekipman güncellendi.", "equipments" => $equipments]));
    }

    public function delete(Request $request)
    {
        if (!$request->exists("id"))
            return response()->json((["error" => true, "message" => "Ekipman bulunamadı."]));

        $vehicleId = -1;
        $equipment = TMSVehicleEquipment::getEquipment($request->id);
        if (!is_null($equipment)) {
            $vehicleId = $equipment->vehicle_id;
            $equipment->delete();
        }

        if ($vehicleId == -1)
            return response()->json((["error" => true, "message" => "Ekipman bulunamadı."]));

        $equipments = TMSVehicleEquipment::getVehicleEquipments($vehicleId);
        return response()->json((["error" => false, "message" => "Ekipman silindi.", "equipments" => $equipments]));
    }
}
