<?php

namespace App\Http\Controllers\tms;

use App\Http\Controllers\Controller;
use App\Http\Requests\tms\CustomerProductRequest;
use App\Models\tms\TMSCustomerProduct;
use Illuminate\Http\Request;

class CustomerProductController extends Controller
{

    public function list(Request $request)
    {
        if (!$request->exists("customer_id"))
            return response()->json((["error" => true, "message" => "Ürün bulunamadı."]));
        $products = TMSCustomerProduct::getCustomerProducts($request->customer_id);

        return response()->json((["error" => false, "message" => "Ürünler getirildi.", "products" => $products]));
    }

    public function store(CustomerProductRequest $request)
    {
        TMSCustomerProduct::addCustomerProduct($request->customer_id, $request->name, $request->price);
        $products = TMSCustomerProduct::getCustomerProducts($request->customer_id);
        return response()->json((["error" => false, "message" => "Ürün eklendi.", "products" => $products]));
    }

    public function edit(Request $request)
    {
        if (!$request->exists("id"))
            return response()->json((["error" => true, "message" => "Ürün bulunamadı."]));

        $product = TMSCustomerProduct::find($request->id);
        return response()->json((["error" => false, "message" => "Ürün getirildi.", "product" => $product]));
    }

    public function update(CustomerProductRequest $request)
    {
        if (!$request->exists("id") || !$request->exists("customer_id"))
            return response()->json((["error" => true, "message" => "Ürün bulunamadı."]));

        TMSCustomerProduct::editCustomerProduct($request->id, $request->customer_id, $request->name, $request->price);
        $products = TMSCustomerProduct::getCustomerProducts($request->customer_id);
        return response()->json((["error" => false, "message" => "Ürün güncellendi.", "products" => $products]));
    }

    public function delete(Request $request)
    {
        if (!$request->exists("id") || !$request->exists("customer_id"))
            return response()->json((["error" => true, "message" => "Ürün bulunamadı."]));

        TMSCustomerProduct::deleteCustomerProduct($request->id);
        $products = TMSCustomerProduct::getCustomerProducts($request->customer_id);
        return response()->json((["error" => false, "message" => "Ürün silindi.", "products" => $products]));
    }
}
