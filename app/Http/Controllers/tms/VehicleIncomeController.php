<?php

namespace App\Http\Controllers\tms;

use App\Http\Controllers\Controller;
use App\Http\Requests\tms\VehicleIncomeRequest;
use Illuminate\Http\Request;
use App\Models\tms\TMSVehicleIncome;

class VehicleIncomeController extends Controller
{

    public function store(VehicleIncomeRequest $request)
    {
        TMSVehicleIncome::addVehicleIncome($request->vehicle_id, $request->date, $request->income);
        $incomes = TMSVehicleIncome::getVehicleIncomes($request->vehicle_id);
        return response()->json((["error" => false, "message" => "Hakediş eklendi.", "incomes" => $incomes]));
    }

    public function edit(Request $request)
    {
        if (!$request->exists("id"))
            return response()->json((["error" => true, "message" => "Hakediş bulunamadı."]));

        $income = TMSVehicleIncome::find($request->id);
        return response()->json((["error" => false, "message" => "Hakediş getirildi.", "income" => $income]));
    }

    public function update(VehicleIncomeRequest $request)
    {
        if (!$request->exists("id"))
            return response()->json((["error" => true, "message" => "Hakediş bulunamadı."]));

        TMSVehicleIncome::updateVehicleIncome($request->id, $request->vehicle_id, $request->date, $request->income);
        $incomes = TMSVehicleIncome::getVehicleIncomes($request->vehicle_id);
        return response()->json((["error" => false, "message" => "Hakediş güncellendi.", "incomes" => $incomes]));
    }

    public function delete(Request $request)
    {
        if (!$request->exists("id"))
            return response()->json((["error" => true, "message" => "Hakediş bulunamadı."]));

        $vehicleId = -1;
        $income = TMSVehicleIncome::find($request->id);
        if (!is_null($income)) {
            $vehicleId = $income->vehicle_id;
            $income->delete();
        }

        if ($vehicleId == -1)
            return response()->json((["error" => true, "message" => "Hakediş bulunamadı."]));

        $incomes = TMSVehicleIncome::getVehicleIncomes($vehicleId);
        return response()->json((["error" => false, "message" => "Hakediş silindi.", "incomes" => $incomes]));
    }

}
