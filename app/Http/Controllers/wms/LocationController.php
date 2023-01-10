<?php

namespace App\Http\Controllers\wms;

use App\Http\Controllers\Controller;
use App\Http\Requests\wms\LocationRequest;
use App\Models\City;
use App\Models\District;
use App\Models\wms\WMSLocation;
use Illuminate\Support\Facades\Redirect;

class LocationController extends Controller
{
 public function index () 
    {
        $locations = WMSLocation::all();

        return view('wms.location.index', compact('locations'));
    }

    public function add () 
    {
        $locations = WMSLocation::all();
        $cities = City::all();
        $districts = District::getCityDistricts($cities->first()->id);
        return view('wms.location.add', compact('locations', 'cities', 'districts'));
    }
    
    public function store (LocationRequest $request) 
    {
        $location = WMSLocation::addLocation($request);
        
        return Redirect::route('get.wms.location.index');
    }

    public function edit ($id) 
    {
        $location = WMSLocation::find($id);

        return view('wms.location.edit', compact('location'));
    }

    public function update(LocationRequest $request, $id)
    {
        WMSLocation::editLocation($id, $request);

        return Redirect::route('get.wms.location.index');
    }

    public function delete($id) 
    {
        $customer = WMSLocation::find($id);
        if (!is_null($customer))
            WMSLocation::deleteLocation($id);

        return Redirect::route('get.wms.location.index');
    }
}
