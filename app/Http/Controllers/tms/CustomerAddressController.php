<?php

namespace App\Http\Controllers\tms;

use App\Http\Controllers\Controller;
use App\Models\tms\TMSCustomerAddress;
use Illuminate\Http\Request;

class CustomerAddressController extends Controller
{
    public function store(Request $request)
    {
        TMSCustomerAddress::addCustomerAddress($request->customer_id, $request->city_id, $request->district_id, $request->address, $request->is_invoice_address);
        $addresses = TMSCustomerAddress::getCustomerAddresses($request->customer_id);
        return response()->json((["error" => false, "message" => "Adres eklendi.", "addresses" => $addresses]));
    }

    public function edit(Request $request)
    {
        if (!$request->exists("id"))
            return response()->json((["error" => true, "message" => "Ekipman bulunamadı."]));

        $address = TMSCustomerAddress::find($request->id);
        return response()->json((["error" => false, "message" => "Adres getirildi.", "address" => $address]));
    }

    public function update(Request $request)
    {
        if (!$request->exists("id"))
            return response()->json((["error" => true, "message" => "Adres bulunamadı."]));

        TMSCustomerAddress::updateCustomerAddress($request->id, $request->customer_id, $request->city_id, $request->district_id, $request->address, $request->is_invoice_address);
        $addresses = TMSCustomerAddress::getCustomerAddresses($request->customer_id);
        return response()->json((["error" => false, "message" => "Adres güncellendi.", "addresses" => $addresses]));
    }

    public function delete(Request $request)
    {
        if (!$request->exists("id"))
            return response()->json((["error" => true, "message" => "Adres bulunamadı."]));

        $customerId = -1;
        $address = TMSCustomerAddress::find($request->id);
        if (!is_null($address)) {
            $customerId = $address->customerId;
            $address->delete();
        }

        if ($customerId == -1)
            return response()->json((["error" => true, "message" => "Adres bulunamadı."]));

        $addresses = TMSCustomerAddress::getCustomerAddresses($request->customer_id);
        return response()->json((["error" => false, "message" => "Adres silindi.", "addresses" => $addresses]));
    }
}
