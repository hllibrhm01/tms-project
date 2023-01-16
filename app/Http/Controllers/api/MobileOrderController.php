<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\tms\TMSOrder;
use App\Models\tms\TMSVehicle;
use App\Models\tms\TMSVehiclePlan;
use App\Models\tms\TMSOrderImage;
use App\Models\tms\TMSVehicleService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class MobileOrderController extends Controller
{
   public function planInfo($vehicleId)
    {
        $planDate =  Carbon::now()->format('Y-m-d');
        $vehicleOrders = TMSVehiclePlan::getVehiclePlanByPlanDate($vehicleId, $planDate);
        return response()->json($vehicleOrders);
    }

    public function showForService($id)
    {
        $service = TMSVehicleService::getVehicleService($id);
        return response()->json($service);
    }

    public function order($orderId)
    {
        $order = TMSOrder::getOrder($orderId);
        return response()->json($order);
    }

    public function deletePlan($planId)
    {
        TMSVehiclePlan::deletePlan($planId);
        return true;
    }

    public function location($id, Request $request)
    {
        $data = $request->validate([
            'lat' => 'required',
            'lng' => 'required',
        ]);
        TMSVehicle::updateVehicleLocationById($id, $data);
        return response()->json(['success' => 'Location added'],200);
    }

    public function nextStatus(Request $request)
    {
        $nextStatusList = TMSOrder::getNextStatusForMobile($request->order_id);
        return response()->json(['status' => 'success', 'order_id' => $request->order_id, "status_list" => $nextStatusList]);
    }

    public static function getOrders($id)
    {
        $orders = TMSOrder::getOrders($id);
        return response()->json($orders);
    }

    public static function getOrder($orderId)
    {
        $order = TMSVehiclePlan::getPlanByOrder($orderId);
        return response()->json($order);
    }

    public function updatePlan(Request $request)
    {
        $planDate =  Carbon::now()->format('Y-m-d');
        $vehicleId = $request->vehicle_id;
        $date = $planDate;
        $orders = $request->orders;
        TMSVehiclePlan::updateVehiclePlan($vehicleId, $date, $orders);
        return response()->json(['success' => 'Plan updated successfully.'], 200);
    }

    public function getAllOrderStatusBySettings()
    {
        $orderStatus = GeneralSetting::getSettings();
        return response()->json($orderStatus);
    }

    public function updateOrderStatus(Request $request)
    {
        $orderId = $request->order_id;
        if ($request->exists('code') && $request->filled('code')) {
            $code = $request->get('code');
            $order = TMSOrder::getOrder($orderId);
            if ($code != $order->sms_verification_code)
                return response()->json(['error' => true, 'message' => 'Doğrulama kodu geçersiz.']);
        }

        $orderPath = "/orders/" . $orderId;
        $userId = $request->user_id;

        $hasAnotherOrder = TMSOrder::isUserHasActiveOrder($userId, $orderId);
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
            $vehicle = TMSVehicle::getVehicle(Auth::user()->vehicle_id);
            send_order_notification($order, $vehicle);

        return response()->json(['error' => false, 'message' => 'Sipariş durumu güncellendi.']);
    }
}