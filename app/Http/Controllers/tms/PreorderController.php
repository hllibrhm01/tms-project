<?php

namespace App\Http\Controllers\tms;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\tms\TMSOrder;
use App\Models\tms\TMSPreorder;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PreorderController extends Controller
{
    public function index()
    {
        $type = 1;
        $preorders = TMSPreorder::all();
        return view('tms.preorder.index', compact('preorders', 'type'));
    }

    public function getByType($id)
    {
        $type = $id;
        $preorders = TMSPreorder::getOrdersByStatus($id);
        return view('tms.preorder.index', compact('preorders', 'type'));
    }

    public function show($id)
    {
        $cities = City::all();
        $order = TMSPreorder::getPreorder($id);
        $preorders = TMSPreorder::getOrders($id);
        return view('tms.preorder.view', compact('cities', 'order', 'preorders'));
    }

    public function close($id)
    {
        $preorder = TMSPreorder::getPreorder($id);
        TMSOrder::createOrderFromPreorder($preorder);
        if ($preorder)
            TMSPreorder::closeOrder($id);
        return Redirect::route('get.tms.preorder.view', ["id" => $id]);
    }

    public function delete($id)
    {
        TMSPreorder::deleteOrder($id);
        return Redirect::route('get.tms.order.type', ["typeld" => 1]);
    }

    public function search(Request $request)
    {
        $type = $request->status;
        $preorders = TMSPreorder::getOrdersByStatus($type);
        return view('tms.preorder.index', compact('preorders', 'type'));
    }
}
