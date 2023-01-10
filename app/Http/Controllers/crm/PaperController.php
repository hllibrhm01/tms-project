<?php

namespace App\Http\Controllers\crm;

use App\Http\Controllers\Controller;
use App\Http\Requests\crm\PaperRequest;
use App\Models\crm\CRMCustomerPaper;
use Illuminate\Http\Request;

class PaperController extends Controller
{

    public function store(PaperRequest $request)
    {
        $filePath = "";
        if ($request->has("file"))
            $filePath = $request->file('file')->store('papers', 'do_space');

        CRMCustomerPaper::addCustomerPaper($request->customer_id, $request->paper_type, $request->description, $filePath);
        $papers = CRMCustomerPaper::getCustomerPapersToDisplay($request->customer_id);
        return response()->json((["error" => false, "message" => "Evrak eklendi.", "papers" => $papers]));
    }

    public function edit(Request $request)
    {
        if (!$request->exists("id"))
            return response()->json((["error" => true, "message" => "Evrak bulunamadı."]));

        $paper = CRMCustomerPaper::find($request->id);
        return response()->json((["error" => false, "message" => "Evrak güncellendi.", "paper" => $paper]));
    }

    public function update(PaperRequest $request)
    {
        if (!$request->exists("id") || !$request->exists("customer_id"))
            return response()->json((["error" => true, "message" => "Evrak bulunamadı."]));

        $paper = CRMCustomerPaper::getCustomerPaper($request->id);
        $filePath = $paper->path;
        if ($request->has("file"))
            $filePath = $request->file('file')->store('papers', 'do_space');

        CRMCustomerPaper::editCustomerPaper($request->id, $request->customer_id, $request->paper_type, $request->description, $filePath);
        $papers = CRMCustomerPaper::getCustomerPapersToDisplay($request->customer_id);
        return response()->json((["error" => false, "message" => "Evrak güncellendi.", "papers" => $papers]));
    }

    public function delete(Request $request)
    {
        if (!$request->exists("id") || !$request->exists("customer_id"))
            return response()->json((["error" => true, "message" => "Evrak bulunamadı."]));

        $paper = CRMCustomerPaper::find($request->id);
        if (!is_null($paper))
            $paper->delete();

        $papers = CRMCustomerPaper::getCustomerPapersToDisplay($request->customer_id);
        return response()->json((["error" => false, "message" => "Evrak silindi.", "papers" => $papers]));
    }

    public function file($file)
    {
        $file = storage_path('app/papers/' . $file);
        $file = str_replace('\\', '/', $file);
        return response()->download($file);
    }
}
