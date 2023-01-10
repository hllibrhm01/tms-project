<?php

namespace App\Http\Controllers\tms;

use App\Http\Controllers\Controller;
use App\Http\Requests\tms\VehicleRequest;
use App\Models\tms\TMSCustomer;
use App\Models\tms\TMSEquipment;
use App\Models\tms\TMSOrder;
use App\Models\tms\TMSOrderImage;
use App\Models\tms\TMSVehicle;
use App\Models\tms\TMSVehiclePlan;
use App\Models\tms\TMSVehicleService;
use App\Models\tms\TMSVehicleSupplier;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;


class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $vehicles = TMSVehicle::getAllVehicles();
        return view('tms.vehicle.index', compact('vehicles'));
    }

    public function getServiceName(Request $request)
    {
        $data = TMSVehicleService::all();
        return response()->json($data);
    }

    public function add()
    {
        $drivers = User::getUsersByRole("driver");
        $services = TMSVehicleService::all();
        $suppliers = TMSVehicleSupplier::all();
        $customers = TMSCustomer::all();
        return view('tms.vehicle.add', compact('customers', 'drivers', 'services', 'suppliers'));
    }

    public function store(VehicleRequest $request)
    {
        $vehicle = TMSVehicle::addVehicle($request);
        if (is_null($vehicle))
            return redirect()->route('tms.vehicle.index');

        return Redirect::route('get.tms.vehicle.view', ['id' => $vehicle->id]);
    }

    public function show($id)
    {
        $drivers = User::getUsersByRole("driver");
        $vehicle = TMSVehicle::getVehicle($id);
        $services = TMSVehicleService::all();
        $suppliers = TMSVehicleSupplier::all();
        $vehiclePoints = TMSVehicle::getVehicleStats($id);
        $customers = TMSCustomer::all();
        $isPlan = TMSVehiclePlan::getVehiclePlanByVehicleId($id);
        return view('tms.vehicle.view', compact('customers', 'drivers', 'vehicle', 'services', 'suppliers', 'vehiclePoints', 'isPlan'));
    }

    public function edit($id)
    {
        $spaceUrl = do_space_url();
        $drivers = User::getUsersByRole("driver");
        $equipments = TMSEquipment::getAllEquipments();
        $vehicle = TMSVehicle::getVehicle($id);
        $services = TMSVehicleService::all();
        $suppliers = TMSVehicleSupplier::all();
        $vehiclePoints = TMSVehicle::getVehicleStats($id);
        $customers = TMSCustomer::all();
        return view('tms.vehicle.edit', compact('customers', 'drivers', 'vehicle', 'equipments', 'services', 'spaceUrl', 'suppliers', 'vehiclePoints'));
    }

    public function update(VehicleRequest $request, $id)
    {
        $vehicle = TMSVehicle::editVehicle($id, $request);
        if (is_null($vehicle))
            return redirect()->route('tms.vehicle.index');

        return Redirect::route('get.tms.vehicle.view', ['id' => $vehicle->id]);
    }

    public function delete($id)
    {
        TMSVehicle::deleteVehicle($id);
        return Redirect::route('get.tms.vehicle.index');
    }

    public function vehicle($vehicleId)
    {
        $date = Carbon::now()->format('Y-m-d');
        $vehicle = TMSVehicle::getVehicle($vehicleId);
        return view('tms.vehicle.plan/vehicle', compact('date', 'vehicle', 'vehicleOrders', 'images'));
    }

    public function vehiclePlanByDate(Request $request)
    {
        $date = $request->plan_date;
        $vehicle = TMSVehicle::getVehicle($request->vehicle_id);
        $vehicleOrders = TMSVehiclePlan::getVehiclePlanByPlanDate($request->vehicle_id, $request->plan_date);
        return view('tms.vehicle.plan.vehicle', compact('date', 'vehicle', 'vehicleOrders'));
    }

    public function makePlan($vehicleId)
    {
        $date = Carbon::now()->format('Y-m-d');
        $vehicle = TMSVehicle::getVehicle($vehicleId);
        $vehicle->capacity = 1000;
        $vehiclePlans = TMSVehiclePlan::all();
        $status = 1;
        $vehicleOrders = TMSVehiclePlan::getVehiclePlanByPlanDate($vehicleId, $date);
        $vehicleOrderIds = $vehicleOrders->pluck('order_id')->toArray();
        $orders = TMSOrder::getAllOrdersExceptVehicles($vehicleOrderIds);
        $ordersWeight = $this->getOrdersWeight($vehicleOrders);
        $avg = $this->getAvgOrderWeight($vehicle, $ordersWeight);
        $getOrderId = TMSVehiclePlan::select('order_id');
        $getOrdersOnStatusOpen = TMSOrder::getOrdersOnStatusOpen($getOrderId);
        return view('tms.vehicle.plan.make', compact('date', 'orders', 'vehicle', 'vehicleOrders', 'avg', 'ordersWeight', 'vehiclePlans', 'getOrdersOnStatusOpen'));
    }

    public function getVehiclePlanByDate(Request $request)
    {
        $date = $request->plan_date;
        $vehicle = TMSVehicle::getVehicle($request->vehicle_id);
        $vehicle->capacity = 1000;
        $vehiclePlans = TMSVehiclePlan::all();
        $vehicleOrders = TMSVehiclePlan::getVehiclePlanByPlanDate($request->vehicle_id, $date);
        $vehicleOrderIds = $vehicleOrders->pluck('order_id')->toArray();
        $orders = TMSOrder::getAllOrdersExceptVehicles($vehicleOrderIds);
        $ordersWeight = $this->getOrdersWeight($vehicleOrders);
        $avg = $this->getAvgOrderWeight($vehicle, $ordersWeight);
        $getOrderId = TMSVehiclePlan::select('order_id');
        $getOrdersOnStatusOpen = TMSOrder::getOrdersOnStatusOpen($getOrderId);
        return view('tms.vehicle.plan.make', compact('date', 'orders', 'vehicle', 'vehicleOrders', 'avg', 'ordersWeight', 'vehiclePlans', 'getOrdersOnStatusOpen'));
    }

    public function updatePlan(Request $request)
    {
        $vehicleId = $request->vehicle_id;
        $date = $request->plan_date;
        $orders = $request->orders;
        TMSVehiclePlan::updateVehiclePlan($vehicleId, $date, $orders);
        return response()->json(['success' => 'Plan updated successfully.'], 200);
    }

    public function deletePlan($planId)
    {
        $plan = TMSVehiclePlan::getVehiclePlanByPlanId($planId);
        $vehicleId = $plan->vehicle_id;
        TMSVehiclePlan::deletePlan($planId);
        return Redirect::route('get.tms.vehicle.plan.make', ['vehicleId' => $vehicleId]);
    }

    private function getAvgOrderWeight($vehicle, $weight)
    {
        return 0; // geçici olarak koyduk, kapasite formülü netleşince güncellicez
        $avg = intval(($weight / $vehicle->capacity) * 100);
        return $avg;
    }

    private function getOrdersWeight($vehicleOrders)
    {
        $weight = 0;
        foreach ($vehicleOrders as $vehicleOrder)
            $weight += $vehicleOrder->order->weight;

        return $weight;
    }

    public function planIndex($vehicleId)
    {
        $vehicle = TMSVehicle::getVehicle($vehicleId);
        $planDate =  Carbon::now()->format('Y-m-d');
        $vehicleOrders = TMSVehiclePlan::getVehiclePlanByPlanDate($vehicleId, $planDate);
        $orderId = TMSOrder::pluck('id')->first();
        $planDate =  Carbon::now()->format('Y-m-d');
        return view('tms.vehicle.plan.index', ['vehicleId' => $vehicleId], compact('vehicle', 'vehicleOrders', 'planDate'));
    }

    public function search(Request $request)
    {
        $vehicles = TMSVehicle::search($request);
        return view('tms.vehicle.index', compact('vehicles'));
    }
}
