<?php

namespace App\Http\Controllers\tms;

use App\Http\Controllers\Controller;
use App\Http\Requests\tms\VehicleExpenseRequest;
use App\Models\GeneralSetting;
use App\Models\tms\TMSVehicle;
use App\Models\tms\TMSVehicleExpense;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VehicleExpenseController extends Controller
{

    public function index(Request $request)
    {
        $date = Carbon::now()->format('Y-m-d');
        if ($request->exists('date'))
            $date = $request->get('date');
        $expenses = TMSVehicleExpense::getExpensesByDate($date);
        $setting = GeneralSetting::getSettings();
        $dailyMailPrice = $setting->daily_meal_price;
        return view('tms.vehicle.expense', compact('expenses', 'date', 'dailyMailPrice'));
    }

    public function expense(Request $request)
    {
        $date = Carbon::now()->format('Y-m-d');
        if ($request->exists('date'))
            $date = $request->get('date');
        $expenses = TMSVehicleExpense::getExpensesByDate($date);
        $setting = GeneralSetting::getSettings();
        $dailyMailPrice = $setting->daily_meal_price;
        return view('tms.vehicle.expense', compact('expenses', 'date', 'dailyMailPrice'));
    }

    public function update(VehicleExpenseRequest $request)
    {
        $expense = TMSVehicleExpense::updateVehicleExpense($request);
        return response()->json((["error" => false, "message" => "Evrak eklendi.", "expense" => $expense]));
    }
}
