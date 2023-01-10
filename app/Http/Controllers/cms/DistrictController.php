<?php

namespace App\Http\Controllers\cms;

use App\Http\Controllers\Controller;
use App\Models\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function getDistrictName(Request $request)
    {
        $data = District::where("city_id", $request->city_id)->get(["name", "id"]);
        return response()->json($data);
    }
    
    public function getTaxDistrictName(Request $request)
    {
        $data = District::where("city_id", $request->tax_department_city_id)->get(["name", "id"]);
        return response()->json($data);
    }
}
