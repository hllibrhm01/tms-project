<?php

namespace App\Http\Controllers\cms;

use App\Http\Controllers\Controller;
use App\Http\Requests\cms\CityRequest;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CityController extends Controller
{
    public function index($countryId)
    {
        $cities = City::getAllCitiesByCountryId($countryId);
        return view('cms.city.index', compact('cities', 'countryId'));
    }

    public function add($countryId)
    {
        return view('cms.city.add', compact('countryId'));
    }

    public function store(CityRequest $request)
    {
        City::addCity($request->name, $request->country_id);
        return Redirect::route('get.cms.city.index', ["countryId" => $request->country_id]);
    }

    public function edit($id)
    {
        $city = City::find($id);
        if (is_null($city))
            return Redirect::route('get.cms.city.index');

        return view('cms.city.edit', compact('city'));
    }

    public function update($id, CityRequest $request)
    {
        City::editCity($id, $request->name, $request->country_id);
        return Redirect::route('get.cms.city.index' , ["countryId" => $request->country_id]);
    }

    public function destroy($id)
    {
        $city = City::find($id);
        $countryId = $city->country_id;
        City::deleteCity($id);
        return Redirect::route('get.cms.city.index', ["countryId" => $countryId]);
    }

    public function getCityName(Request $request)
    {
        $data = City::all();
        return response()->json($data);
    }
}
