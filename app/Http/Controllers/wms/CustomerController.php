<?php

namespace App\Http\Controllers\wms;

use App\Http\Controllers\Controller;
use App\Http\Requests\wms\CustomerRequest;
use App\Models\wms\WMSCustomer;
use Illuminate\Support\Facades\Redirect;

class CustomerController extends Controller
{
    public function index () 
    {
        $customers = WMSCustomer::all();

        return view('wms.customer.index', compact('customers'));
    }

    public function add () 
    {
        $customers = WMSCustomer::all();

        return view('wms.customer.add', compact('customers'));
    }
    
    public function store (CustomerRequest $request) 
    {
        $customer = WMSCustomer::addCustomer($request);
        
        return Redirect::route('get.wms.customer.index');
    }

    public function edit ($id) 
    {
        $customer = WMSCustomer::find($id);

        return view('wms.customer.edit', compact('customer'));
    }

    public function update(CustomerRequest $request, $id)
    {
        WMSCustomer::editCustomer($id, $request);

        return Redirect::route('get.wms.customer.index');
    }

    public function delete($id) 
    {
        $customer = WMSCustomer::find($id);
        if (!is_null($customer))
            WMSCustomer::deleteCustomer($id);

        return Redirect::route('get.wms.customer.index');
    }
}
