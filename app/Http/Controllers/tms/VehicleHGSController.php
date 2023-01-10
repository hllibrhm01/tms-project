<?php

namespace App\Http\Controllers\tms;

use App\Http\Controllers\Controller;
use App\Http\Requests\tms\VehicleHGSRequest;
use App\Models\tms\TMSVehicleHGS;
use Illuminate\Http\Request;

class VehicleHGSController extends Controller
{
    public function store(VehicleHGSRequest $request)
    {
        TMSVehicleHGS::addVehicleHGS($request->vehicle_id, $request->date, $request->cost);
        $hgs = TMSVehicleHGS::getVehicleHGS($request->vehicle_id);
        return response()->json((["error" => false, "message" => "HGS eklendi.", "hgs" => $hgs]));
    }

    public function edit(Request $request)
    {
        if (!$request->exists("id"))
            return response()->json((["error" => true, "message" => "HGS kayıtı bulunamadı."]));

        $hgs = TMSVehicleHGS::find($request->id);
        return response()->json((["error" => false, "message" => "HGS kayıtı getirildi.", "hgs" => $hgs]));
    }

    public function update(VehicleHGSRequest $request)
    {
        if (!$request->exists("id"))
            return response()->json((["error" => true, "message" => "HGS kayıtı bulunamadı."]));

        TMSVehicleHGS::updateVehicleHGS($request->id, $request->vehicle_id, $request->date, $request->cost);
        $hgs = TMSVehicleHGS::getVehicleHGS($request->vehicle_id);
        return response()->json((["error" => false, "message" => "HGS kayıtı güncellendi.", "hgs" => $hgs]));
    }

    public function delete(Request $request)
    {
        if (!$request->exists("id"))
            return response()->json((["error" => true, "message" => "HGS kayıtı bulunamadı."]));

        $vehicleId = -1;
        $hgs = TMSVehicleHGS::find($request->id);
        if (!is_null($hgs)) {
            $vehicleId = $hgs->vehicle_id;
            $hgs->delete();
        }

        if ($vehicleId == -1)
            return response()->json((["error" => true, "message" => "HGS kayıtı bulunamadı."]));

        $hgs = TMSVehicleHGS::getVehicleHGS($vehicleId);
        return response()->json((["error" => false, "message" => "HGS kayıtı silindi.", "hgs" => $hgs]));
    }
}
