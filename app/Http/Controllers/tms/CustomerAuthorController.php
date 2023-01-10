<?php

namespace App\Http\Controllers\tms;

use App\Http\Controllers\Controller;
use App\Http\Requests\tms\CustomerAuthorRequest;
use App\Models\tms\TMSCustomerAuthor;
use Illuminate\Http\Request;

class CustomerAuthorController extends Controller
{

    public function store(CustomerAuthorRequest $request)
    {
        TMSCustomerAuthor::addAuthor($request->customer_id, $request->name, $request->title, $request->phone, $request->email);
        $authors = TMSCustomerAuthor::getCustomerAuthors($request->customer_id);
        return response()->json((["error" => false, "message" => "Yetkili eklendi.", "authors" => $authors]));
    }

    public function edit(Request $request)
    {
        if (!$request->exists("id"))
            return response()->json((["error" => true, "message" => "Yetkili bulunamadı."]));

        $author = TMSCustomerAuthor::find($request->id);
        return response()->json((["error" => false, "message" => "Yetkili getirildi.", "author" => $author]));
    }

    public function update(CustomerAuthorRequest $request)
    {
        if (!$request->exists("id"))
            return response()->json((["error" => true, "message" => "Yetkili bulunamadı."]));

        TMSCustomerAuthor::updateAuthor($request->id, $request->customer_id, $request->name, $request->title, $request->phone, $request->email);
        $authors = TMSCustomerAuthor::getCustomerAuthors($request->customer_id);
        return response()->json((["error" => false, "message" => "Yetkili güncellendi.", "authors" => $authors]));
    }

    public function delete(Request $request)
    {
        if (!$request->exists("id"))
            return response()->json((["error" => true, "message" => "Yetkili bulunamadı."]));

        $customerId = -1;
        $author = TMSCustomerAuthor::find($request->id);
        if (!is_null($author)) {
            $customerId = $author->customer_id;
            $author->delete();
        }

        if ($customerId == -1)
            return response()->json((["error" => true, "message" => "Yetkili bulunamadı."]));

        $authors = TMSCustomerAuthor::getCustomerAuthors($customerId);
        return response()->json((["error" => false, "message" => "Yetkili silindi.", "authors" => $authors]));
    }
}
