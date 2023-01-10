<?php

namespace App\Http\Controllers\tms;

use App\Http\Controllers\Controller;
use App\Helper\TMSOrderHelper;
use App\Http\Requests\tms\OrderRequest;
use Illuminate\Http\Request;
use App\Libraries\Hasher;
use App\Libraries\MailSender;
use App\Models\tms\TMSCustomer;
use App\Models\tms\TMSOrder;
use App\Models\City;
use App\Models\District;
use App\Models\GeneralSetting;
use App\Models\Notification;
use App\Models\tms\TMSCustomerAuthor;
use App\Models\tms\TMSCustomerProduct;
use App\Models\tms\TMSOrderImage;
use App\Models\tms\TMSOrderProduct;
use App\Models\tms\TMSOrderStatusChange;
use App\Models\tms\TMSVehicle;
use App\Models\tms\TMSVehiclePlan;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = TMSOrder::all();
        return view('tms.order.index', compact('orders'));
    }

    public function search(Request $request)
    {
        $orders = TMSOrder::search($request);
        return view('tms.order.index', compact('orders'));
    }

    public function getByType($id)
    {
        $orders = TMSOrder::getOrdersByStatus($id);
        $order = TMSOrder::find($id);
        return view('tms.order.index', compact('orders', 'order'));
    }

    public function add()
    {
        $customers = TMSCustomer::all();
        $cities = City::all();
        $districts = District::getCityDistricts($cities->first()->id);
        return view('tms.order.add', compact('customers', 'cities', 'districts'));
    }

    public function getCompanyName(Request $request)
    {
        $data = TMSCustomer::where("group_type", $request->group_type)->get(["company_name", "id"]);
        return response()->json($data);
    }

    public function store(OrderRequest $request)
    {
        $filePath = "";
        if ($request->has('attachment'))
            $filePath = $request->file('attachment')->store("/attachment", 'do_space');

        $tmsOrder = TMSOrder::addOrder($request, $filePath);
        for ($i = 0; $i < count($request->productId); $i++)
            TMSOrderProduct::addOrderProducts($tmsOrder->id, $request->productId[$i], $request->productCount[$i]);

        return Redirect::route('get.tms.order.type', ["typeld" => 1]);
    }

    public function show($id)
    {
        $cities = City::all();
        $order = TMSOrder::getOrder($id);
        $orders = TMSOrder::getOrders($id);
        $movements = TMSOrderStatusChange::getOrderMovements($id);
        $orderImageData = TMSOrderImage::getOrderImagesAll($id);
        $orderImages = [];
        foreach ($orderImageData as $image)
            $orderImages[$image->status]['images'][] = $image;

        return view('tms.order.view', compact('cities', 'order', 'orders', 'movements', 'orderImages'));
    }

    public function edit($id)
    {
        $order = TMSOrder::find($id);
        $cities = City::all();
        $orders = TMSOrder::getOrdersByStatus($id);
        $products = TMSCustomerProduct::getCustomerProducts($order->owner_id);
        $movements = TMSOrderStatusChange::getOrderMovements($id);
        $orderImageData = TMSOrderImage::getOrderImagesAll($id);
        $orderImages = [];
        foreach ($orderImageData as $image)
            $orderImages[$image->status]['images'][] = $image;

        return view('tms.order.edit', compact('order', 'cities', 'orders', 'movements', 'orderImages', 'products'));
    }

    public function update(OrderRequest $request, $id)
    {
        $order = TMSOrder::find($id);
        $filePath = $order->attachment;
        if ($request->has('attachment')) {
            $filePath = $request->file('attachment')->store("/attachment", 'do_space');
        }
        TMSOrder::editOrder($id, $request, $filePath);
        TMSOrderProduct::deleteOrderProducts($id);
        for ($i = 0; $i < count($request->productId); $i++)
            TMSOrderProduct::addOrderProducts($id, $request->productId[$i], $request->productCount[$i]);

        return Redirect::route('get.tms.order.view', ["id" => $order->id]);
    }

    public function delete($id)
    {
        $order = TMSOrder::find($id);
        if (!is_null($order))
            TMSOrder::deleteOrder($id);

        return Redirect::route('get.tms.order.type', ["typeld" => 1]);
    }

    public function tracking($id)
    {
        $order = TMSOrder::find($id);
        $status = TMSOrderStatusChange::getOrderMovements($id);
        $image = TMSOrderImage::getOrderImagesAll($id);
        // $location = TMSVehicle::find($order->vehicle_id);
        $vehicleId =  $order->vehicle_id;
        $orderId =  $order->id;
        $location = TMSVehicle::getVehicleLocation($vehicleId, $orderId);
        $imageStatus = [];
        foreach ($image as $images) {
            $imageStatus[$images->status]['images'][] = $images;
        }
        Redirect::route('get.tms.order.tracking', ["id" => $id]);
        return view('tms.order.tracking', compact('status', 'image', 'imageStatus', 'location', 'order'));
    }

    public function location(Request $request)
    {
        $id = $request->id;
        $data = TMSOrder::find($id);
        $vehicleId =  $data->vehicle_id;
        $orderId =  $data->id;
        $location = TMSVehicle::getVehicleLocation($vehicleId, $orderId);
        return response()->json($location);
    }

    public function nextStatus(Request $request)
    {
        $nextStatusList = TMSOrder::getNextStatus($request->order_id);
        $order = TMSOrder::getOrder($request->order_id);
        return response()->json(['status' => 'success', 'order_id' => $order->id, "status_list" => $nextStatusList, "code" => $order->sms_verification_code]);
    }

    public function orderTracking(Request $request)
    {
        if (!$request->exists('oid'))
            return view('notfound');

        $orderId = Hasher::decode($request->get('oid'));
        $order = TMSOrder::getOrder($orderId);

        if (is_null($order->vehicle_id))
            return view('notfound');
        $status = TMSOrderStatusChange::getOrderMovements($orderId);
        $image = TMSOrderImage::getOrderImagesAll($orderId);
        $imageStatus = [];
        foreach ($image as $images) {
            $imageStatus[$images->status]['images'][] = $images;
        }
        return view('tms.order.tracking', compact('status', 'image', 'imageStatus'));
    }


    public function updateOrderStatus(Request $request)
    {
        $orderId = $request->order_id;
        $order = TMSOrder::getOrder($orderId);
        if ($request->exists('code') && $request->filled('code')) {
            $code = $request->get('code');
            if ($code != $order->sms_verification_code)
                return response()->json(['error' => true, 'message' => 'Doğrulama kodu geçersiz.']);
        }

        $orderPath = "/orders/" . $orderId;
        $vehicleId = Auth::user()->vehicle_id;

        $hasAnotherOrder = TMSOrder::isUserHasActiveOrder($vehicleId, $orderId);
        if ($hasAnotherOrder)
            return response()->json(['error' => true, 'message' => 'Mevcut sipariş tamamlanmadan yeni siparişe başlayamazsınız.']);

        if ($request->has('file1')) {
            $filePath = $request->file('file1')->store($orderPath, 'do_space');
            TMSOrderImage::addImage($orderId, $filePath, $request->status);
        }

        if ($request->has('file2')) {
            $filePath = $request->file('file2')->store($orderPath, 'do_space');
            TMSOrderImage::addImage($orderId, $filePath, $request->status);
        }

        if ($request->has('file3')) {
            $filePath = $request->file('file3')->store($orderPath, 'do_space');
            TMSOrderImage::addImage($orderId, $filePath, $request->status);
        }

        if ($request->has('file4')) {
            $filePath = $request->file('file4')->store($orderPath, 'do_space');
            TMSOrderImage::addImage($orderId, $filePath, $request->status);
        }

        if ($request->has('file5')) {
            $filePath = $request->file('file5')->store($orderPath, 'do_space');
            TMSOrderImage::addImage($orderId, $filePath, $request->status);
        }

        if ($request->has('file6')) {
            $filePath = $request->file('file6')->store($orderPath, 'do_space');
            TMSOrderImage::addImage($orderId, $filePath, $request->status);
        }

        $order = TMSOrder::updateOrderStatus($orderId, $request->status, $request->note);
        if (!is_null($order)) {
            $vehicle = TMSVehicle::getVehicle(Auth::user()->vehicle_id);
            send_order_notification($order, $vehicle);
        }
        return response()->json(['error' => false, 'message' => 'Sipariş durumu güncellendi.']);
    }
}
