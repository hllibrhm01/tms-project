<?php

namespace App\Http\Controllers\wms;

use App\Http\Controllers\Controller;
use App\Http\Requests\wms\OrderRequest;
use App\Models\City;
use App\Models\District;
use App\Models\wms\WMSCustomer;
use App\Models\wms\WMSOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class OrderController extends Controller
{
    public function index ($id, $status) {
        $orders = WMSOrder::getOrdersByOwnerTypeAndOrderType($id, $status);
        $order = WMSOrder::find($id);
        return view('wms.order.index', compact('orders', 'order'));
    }
    
    public function add () {
        $customers = WMSCustomer::all();
        $cities = City::all();
        $districts = District::getCityDistricts($cities->first()->id);
        return view('wms.order.add', compact('customers', 'cities', 'districts'));
    }

    public function getCompanyName(Request $request)
    {
        $data = WMSCustomer::where("type", $request->type)->get(["company_name","id"]);
        return response()->json($data);
    } 

    public function store (OrderRequest $request) {
        WMSOrder::addOrder($request);
        return Redirect::route('get.wms.order.index', ["id" => 1, "typeld" => 1]);
    }

    public function edit ($id) {
        $order = WMSOrder::find($id);
        $cities = City::all();
        $orders = WMSOrder::getOrdersByType($id);
        return view('wms.order.edit', compact('order', 'cities', 'orders'));
    }

    public function update(OrderRequest $request, $id)
    {
        WMSOrder::editOrder($id, $request);
        $order = WMSOrder::find($id);
        return Redirect::route('get.wms.order.index', ["id" => $order->id, "typeld" => $order->status]);
    }

    public function delete($id) 
    {
        $order = WMSOrder::find($id);
        if (!is_null($order))
            WMSOrder::deleteOrder($id);

        return Redirect::route('get.wms.order.index', ["id" => 1, "typeld" => 1]);
    }
}
