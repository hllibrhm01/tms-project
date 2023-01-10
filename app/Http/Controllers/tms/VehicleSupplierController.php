<?php

namespace App\Http\Controllers\tms;

use App\Http\Controllers\Controller;
use App\Models\tms\TMSVehicleSupplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class VehicleSupplierController extends Controller
{

    public function index()
    {
        $suppliers = TMSVehicleSupplier::all();
        return view('tms.vehicle.supplier.index', compact('suppliers'));
    }

    public function show($id)
    {
        $supplier = TMSVehicleSupplier::getVehiclesupplier($id);
        return view('tms.vehicle.supplier.view', compact('supplier'));
    }

    public function add()
    {
        return view('tms.vehicle.supplier.add');
    }

    public function store(Request $request)
    {
        $supplier = TMSVehicleSupplier::addVehicleSupplier($request);
        if (is_null($supplier))
            return redirect()->route('get.tms.vehicle.supplier.index');

        return Redirect::route('get.tms.vehicle.supplier.view', ['id' => $supplier->id]);
    }

    public function edit($id)
    {
        $supplier = TMSVehicleSupplier::getVehicleSupplier($id);
        return view('tms.vehicle.supplier.edit', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
        $supplier = TMSVehicleSupplier::editVehicleSupplier($id, $request);
        if (is_null($supplier))
        return redirect()->route('get.tms.vehicle.supplier.index');

        return Redirect::route('get.tms.vehicle.supplier.view', ['id' => $supplier->id]);
    }

    public function delete($id)
    {
        TMSVehicleSupplier::deleteVehicleSupplier($id);
        return Redirect::route('get.tms.vehicle.supplier.index');
    }

    public function search(Request $request)
    {
        $suppliers = TMSVehicleSupplier::search($request);
        return view('tms.vehicle.supplier.index', compact('suppliers'));
    }
}
