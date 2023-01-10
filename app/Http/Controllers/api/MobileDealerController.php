<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\District;
use App\Models\tms\TMSCustomerProduct;
use App\Models\tms\TMSOrder;
use App\Models\tms\TMSPreorder;
use App\Models\tms\TMSPreorderItem;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MobileDealerController extends Controller
{
    public function getByType($id)
    {
        $preorders = TMSPreorder::getOrdersByStatus($id);
        return response()->json($preorders);
    }

    public function list($customerId)
    {
        if (!$customerId)
            return response()->json((["error" => true, "message" => "Ürün bulunamadı."]));
        $products = TMSCustomerProduct::getCustomerProducts($customerId);
        return response()->json((["error" => false, "message" => "Ürünler getirildi.", "products" => $products]));
    }

    public function getCityName()
    {
        $data = City::all();
        return response()->json($data);
    }

    public function getDistrictName(Request $request)
    {
        $data = District::where("city_id", $request->tax_department_city_id)->get(["name", "id"]);
        return response()->json($data);
    }

    public function show($id)
    {
        $order = TMSPreorder::getPreorder($id);
        return response()->json($order);
    }
    public function store(Request $request)
    {
        $preorder = TMSPreorder::addOrder($request);
        for ($i = 0; $i < count($request->productId); $i++)
            TMSPreorderItem::addOrderProducts($preorder->id, $request->productId[$i], $request->productCount[$i]);
        return response()->json((["error" => false, "message" => "Ürün eklendi."]));
    }

    public function update($id, Request $request)
    {
        // TMSPreorder::updateOrder($request, $id);
        TMSPreorder::editOrder($id, $request);
        TMSPreorderItem::deleteOrderProducts($id);
        for ($i = 0; $i < count($request->productId); $i++)
            TMSPreorderItem::addOrderProducts($id, $request->productId[$i], $request->productCount[$i]);
        return response()->json((["error" => false, "message" => "Ürün güncellendi."]));
    }

    public function getOrderByStatusAndDate($id, Request $request)
    {
        $date = $request->created_at;
        $status = $request->status;
        $todayDate = Carbon::now()->format('Y-m-d');

        if ($date == null || $status == null) {
            $date = $todayDate;
            $status = 1;
        } else {
            $date = date('Y-m-d', strtotime($request->created_at));
            $status = $request->status;
        }
        
        $data = TMSOrder::getOrderByStatusAndDate($id, $date, $status);
        return response()->json($data);
    }
  
    public function delete($id)
    {
        TMSPreorder::deleteOrder($id);
        return response()->json((["error" => false, "message" => "Ürün silindi."]));
    }
}