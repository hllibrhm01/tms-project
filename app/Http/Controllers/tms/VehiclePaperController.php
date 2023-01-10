<?php

namespace App\Http\Controllers\tms;

use App\Http\Controllers\Controller;
use App\Http\Requests\tms\VehiclePaperRequest;
use App\Models\tms\TMSVehiclePaper;
use Illuminate\Http\Request;

class VehiclePaperController extends Controller
{

    public function store(VehiclePaperRequest $request)
    {
        $filePath = "";
        if ($request->has("file"))
            $filePath = $request->file('file')->store('vehicle_papers', 'do_space');

        TMSVehiclePaper::addVehiclePaper($request->vehicle_id, $request->paper_type, $request->description, $filePath);
        $papers = TMSVehiclePaper::getVehiclePapersToDisplay($request->vehicle_id);
        return response()->json((["error" => false, "message" => "Evrak eklendi.", "papers" => $papers]));
    }

    public function edit(Request $request)
    {
        if (!$request->exists("id"))
            return response()->json((["error" => true, "message" => "Evrak bulunamadı."]));

        $paper = TMSVehiclePaper::find($request->id);
        return response()->json((["error" => false, "message" => "Evrak getirildi.", "paper" => $paper]));
    }

    public function update(VehiclePaperRequest $request)
    {
        if (!$request->exists("id") || !$request->exists("vehicle_id"))
            return response()->json((["error" => true, "message" => "Evrak bulunamadı."]));


        $paper = TMSVehiclePaper::getVehiclePaper($request->id);
        $filePath = $paper->path;

        if ($request->has("file"))
            $filePath = $request->file('file')->store('vehicle_papers', 'do_space');

        TMSVehiclePaper::editVehiclePaper($request->id, $request->vehicle_id, $request->paper_type, $request->description, $filePath);
        $papers = TMSVehiclePaper::getVehiclePapersToDisplay($request->vehicle_id);
        return response()->json((["error" => false, "message" => "Evrak güncellendi.", "papers" => $papers]));
    }

    public function delete(Request $request)
    {
        if (!$request->exists("id") || !$request->exists("vehicle_id"))
            return response()->json((["error" => true, "message" => "Evrak bulunamadı."]));

        $paper = TMSVehiclePaper::find($request->id);
        if (!is_null($paper))
            $paper->delete();

        $papers = TMSVehiclePaper::getVehiclePapersToDisplay($request->vehicle_id);
        return response()->json((["error" => false, "message" => "Evrak silindi.", "papers" => $papers]));
    }
}
