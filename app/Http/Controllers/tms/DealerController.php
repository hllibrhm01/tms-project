<?php

namespace App\Http\Controllers\tms;

use App\Http\Controllers\Controller;
use App\Http\Requests\tms\PreorderRequest;
use App\Models\tms\TMSCustomerProduct;
use Illuminate\Support\Facades\Auth;
use App\Models\City;
use App\Models\District;
use App\Models\tms\TMSOrder;
use App\Models\tms\TMSPreorder;
use App\Models\tms\TMSPreorderItem;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DealerController extends Controller
{
    public function getPreorderByType($id)
    {
        $customerId = Auth::user()->tms_id;
        if (is_null($customerId))
            return "TMS Customer set edilmedi.";

        $type = $id;
        $preorders = TMSPreorder::getCustomerOrdersByStatus($customerId, $type);
        return view('tms.dealer.preorder.index', compact('preorders', 'type'));
    }

    public function addPreorder()
    {
        $customerId = Auth::user()->tms_id;
        if (is_null($customerId))
            return "TMS Customer set edilmedi.";

        $cities = City::all();
        $districts = District::getCityDistricts($cities->first()->id);
        $products = TMSCustomerProduct::getCustomerProducts($customerId);
        return view('tms.dealer.preorder.add', compact('customerId', 'products', 'districts', 'cities'));
    }

    public function storePreorder(PreorderRequest $request)
    {
        $preorder = TMSPreorder::addOrder($request);
        for ($i = 0; $i < count($request->productId); $i++)
            TMSPreorderItem::addOrderProducts($preorder->id, $request->productId[$i], $request->productCount[$i]);

        send_notification_to_planners($preorder, TMSOrder::PLANNER_NOTIFICATION_TYPE_PREORDER_RECEIVED);
        return Redirect::route('get.tms.dealer.preorder.type', ["typeld" => 1]);
    }

    public function showPreorder($id)
    {
        $cities = City::all();
        $order = TMSPreorder::getPreorder($id);
        $preorders = TMSPreorder::getOrders($id);
        if (Gate::allows('preorder', $preorders->first()->tms_customer_id))
            return view('tms.dealer.preorder.view', compact('cities', 'order', 'preorders'));
        else
            return "Bu siparişi görüntüleme yetkiniz yok.";
    }


    public function editPreorder($id)
    {
        $cities = City::all();
        $order = TMSPreorder::getPreorder($id);
        $preorders = TMSPreorder::getOrders($id);
        $products = TMSCustomerProduct::getCustomerProducts($order->tms_customer_id);

        if (Gate::allows('preorder', $preorders->first()->tms_customer_id))
            return view('tms.dealer.preorder.edit', compact('products', 'cities', 'order', 'preorders'));
        else
            return "Bu siparişi düzenleme yetkiniz yok.";
    }

    public function updatePreorder(PreorderRequest $request, $id)
    {
        $order = TMSPreorder::find($id);
        TMSPreorder::editOrder($id, $request);
        TMSPreorderItem::deleteOrderProducts($id);
        for ($i = 0; $i < count($request->productId); $i++)
            TMSPreorderItem::addOrderProducts($id, $request->productId[$i], $request->productCount[$i]);

        send_notification_to_planners($order, TMSOrder::PLANNER_NOTIFICATION_TYPE_PREORDER_RECEIVED);
        return Redirect::route('get.tms.dealer.preorder.view', ["id" => $order->id]);
    }

    public function deletePreorder($id)
    {
        TMSPreorder::deleteOrder($id);
        return Redirect::route('get.tms.order.type', ["typeld" => 1]);
    }

    public function searchPreorder(Request $request)
    {
        $customerId = Auth::user()->tms_id;
        if (is_null($customerId))
            return "TMS Customer set edilmedi.";

        $type = $request->status;
        $preorders = TMSPreorder::getCustomerOrdersByStatus($customerId, $type);
        return view('tms.dealer.preorder.index', compact('preorders', 'type'));
    }

    // Order

    public function getOrderByType($id)
    {
        $customerId = Auth::user()->tms_id;
        if (is_null($customerId))
            return "TMS Customer set edilmedi.";

        $type = $id;
        $orders = TMSOrder::getCustomerOrdersByStatus($customerId, $type);
        return view('tms.dealer.order.index', compact('orders', 'type'));
    }

    public function searchOrders(Request $request)
    {
        $customerId = Auth::user()->tms_id;
        if (is_null($customerId))
            return "TMS Customer set edilmedi.";

        $type = $request->status;
        $orders = TMSOrder::getCustomerOrdersByStatus($customerId, $type);
        return view('tms.dealer.order.index', compact('orders', 'type'));
    }
}
