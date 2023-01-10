<?php

namespace App\Http\Controllers\tms;

use App\Http\Controllers\Controller;
use App\Http\Requests\tms\CustomerPaperRequest;
use App\Models\tms\TMSCustomerPaper;
use Illuminate\Http\Request;

class CustomerPaperController extends Controller
{

    public function store(CustomerPaperRequest $request)
    {
        $filePath = "";
        if ($request->has("file"))
            $filePath = $request->file('file')->store('customer_papers', 'do_space');

        TMSCustomerPaper::addCustomerPaper($request->customer_id, $request->paper_type, $request->description, $filePath);
        $papers = TMSCustomerPaper::getCustomerPapersToDisplay($request->customer_id);
        return response()->json((["error" => false, "message" => "Evrak eklendi.", "papers" => $papers]));
    }

    public function edit(Request $request)
    {
        if (!$request->exists("id"))
            return response()->json((["error" => true, "message" => "Evrak bulunamadı."]));

        $paper = TMSCustomerPaper::find($request->id);
        return response()->json((["error" => false, "message" => "Evrak getirildi.", "paper" => $paper]));
    }

    public function update(CustomerPaperRequest $request)
    {
        if (!$request->exists("id") || !$request->exists("customer_id"))
            return response()->json((["error" => true, "message" => "Evrak bulunamadı."]));


        $paper = TMSCustomerPaper::getCustomerPaper($request->id);
        $filePath = $paper->path;

        if ($request->has("file"))
            $filePath = $request->file('file')->store('customer_papers', 'do_space');

        TMSCustomerPaper::editCustomerPaper($request->id, $request->customer_id, $request->paper_type, $request->description, $filePath);
        $papers = TMSCustomerPaper::getCustomerPapersToDisplay($request->customer_id);
        return response()->json((["error" => false, "message" => "Evrak güncellendi.", "papers" => $papers]));
    }

    public function delete(Request $request)
    {
        if (!$request->exists("id") || !$request->exists("customer_id"))
            return response()->json((["error" => true, "message" => "Evrak bulunamadı."]));

        $paper = TMSCustomerPaper::find($request->id);
        if (!is_null($paper))
            $paper->delete();

        $papers = TMSCustomerPaper::getCustomerPapersToDisplay($request->customer_id);
        return response()->json((["error" => false, "message" => "Evrak silindi.", "papers" => $papers]));
    }
}
