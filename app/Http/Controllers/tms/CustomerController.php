<?php

namespace App\Http\Controllers\tms;

use App\Http\Controllers\Controller;
use App\Http\Requests\tms\CustomerRequest;
use App\Models\City;
use App\Models\District;
use App\Models\TaxDepartment;
use App\Models\tms\TMSCustomer;
use App\Models\tms\TMSOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;


class CustomerController extends Controller
{
    public function index()
    {
        $customers = TMSCustomer::all();
        return view('tms.customer.index', compact('customers'));
    }

    public function getCityName(Request $request)
    {
        $data = City::all();
        return response()->json($data);
    }

    public function getDistrictName(Request $request)
    {
        $data = District::where("city_id", $request->tax_department_city_id)->get(["name", "id"]);
        return response()->json($data);
    }

    public function getTaxDepartmentName(Request $request)
    {
        $data = TaxDepartment::where("district_id", $request->tax_department_district_id)->get(["name", "id"]);
        return response()->json($data);
    }

    public function getOrder(Request $request)
    {
        $data = TMSOrder::where("owner_id", $request->customer_id)->get(["weight", "id"]);
        return response()->json($data);
    }

    public function add()
    {
        $customers = TMSCustomer::all();
        $cities = City::all();
        $districts = District::getCityDistricts($cities->first()->id);
        $tax_departments = TaxDepartment::getDistrictTaxDepartment($districts->first()->id);
        return view('tms.customer.add', compact('customers', 'cities', 'districts', 'tax_departments'));
    }

    public function store(CustomerRequest $request)
    {
        $customer = TMSCustomer::addCustomer($request);
        if (is_null($customer))
            return Redirect::route('get.tms.customer.index');
        return Redirect::route('get.tms.customer.view', ['id' => $customer->id]);
    }

    public function show($id)
    {
        $customer = TMSCustomer::getCustomer($id);
        $cities = City::all();
        $districts = District::getCityDistricts($cities->first()->id);
        $tax_departments = []; //TaxDepartment::getDistrictTaxDepartment($districts->first()->id);
        $order = TMSCustomer::getOrders($id);
        return view('tms.customer.view', compact('customer', 'cities', 'districts', 'tax_departments', 'order'));
    }


    public function edit($id)
    {
        $spaceUrl = do_space_url();
        $customer = TMSCustomer::getCustomer($id);
        $cities = City::all();
        $districts = District::getCityDistricts($cities->first()->id);
        $tax_departments = TaxDepartment::getDistrictTaxDepartment($districts->first()->id);
        $customers = TMSOrder::getOrdersByStatus($id);
        $order = TMSCustomer::getOrders($id);
        return view('tms.customer.edit', compact('customer', 'cities', 'districts', 'tax_departments', 'order' , 'spaceUrl'));
    }

    public function update(CustomerRequest $request, $id)
    {
        $customer = TMSCustomer::editCustomer($id, $request);
        if (is_null($customer))
            return Redirect::route('get.tms.customer.index');
        return Redirect::route('get.tms.customer.view', ['id' => $customer->id]);
    }

    public function delete($id)
    {
        $customer = TMSCustomer::find($id);
        if (!is_null($customer))
            TMSCustomer::deleteCustomer($id);

        return Redirect::route('get.tms.customer.index');
    }

    public function search(Request $request)
    {
        $customers = TMSCustomer::search($request);
        return view('tms.customer.index', compact('customers'));
    }
}
