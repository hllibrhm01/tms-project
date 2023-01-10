<?php

namespace App\Http\Controllers\cms;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class AddressController extends Controller
{

    public function getCities()
    {
        $cities = City::getTurkeyCities();
        return  response()->json($cities);
    }

    public function getCitiesByCountryId(Request $request)
    {
        $cities = City::getCitiesByCountryId($request->country_id);
        return  response()->json($cities);
    }
}
