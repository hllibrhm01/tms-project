<?php

namespace App\Http\Controllers\tms;

use App\Http\Controllers\Controller;
use App\Http\Requests\tms\VehicleServiceRequest;
use App\Models\tms\TMSVehicleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class VehicleServiceController extends Controller
{

    public function index()
    {
        $services = TMSVehicleService::all();
        return view('tms.vehicle.service.index', compact('services'));
    }

    public function show($id)
    {
        $service = TMSVehicleService::getVehicleService($id);
        return view('tms.vehicle.service.view', compact('service'));
    }

    public function add()
    {
        $service = TMSVehicleService::all();
        return view('tms.vehicle.service.add', compact('service'));
    }

    public function store(VehicleServiceRequest $request)
    {
        $service = TMSVehicleService::addVehicleService($request);
        if (is_null($service))
            return redirect()->route('tms.vehicle.index');

        return Redirect::route('get.tms.vehicle.service.view', ['id' => $service->id]);
    }

    public function edit($id)
    {
        $service = TMSVehicleService::getVehicleService($id);
        return view('tms.vehicle.service.edit', compact('service'));
    }

    public function update(VehicleServiceRequest $request, $id)
    {
        $service = TMSVehicleService::editVehicleService($id, $request);
        if (is_null($service))
            return redirect()->route('tms.vehicle.service.index');

        return Redirect::route('get.tms.vehicle.service.view', ['id' => $service->id]);
    }

    public function delete($id)
    {
        TMSVehicleService::deleteVehicleService($id);
        return Redirect::route('get.tms.vehicle.service.index');
    }

    public function search(Request $request)
    {
        $services = TMSVehicleService::search($request);
        return view('tms.vehicle.service.index', compact('services'));
    }

}
