<?php

namespace App\Http\Controllers\crm;

use App\Http\Controllers\Controller;
use App\Http\Requests\crm\AssignmentRequest;
use App\Models\crm\CRMAssignment;
use App\Models\crm\CRMEmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class AssignmentController extends Controller
{
    public function index()
    {
        Session::remove("ASSIGNMENT_SEARCH");
        $assignments = CRMAssignment::getAllAssignments();
        $emailTemplates = CRMEmailTemplate::getAllEmailTemplates();
        return view('crm.assignment.index', compact('assignments', 'emailTemplates'));
    }

    public function add()
    {
        return view('crm.assignment.add');
    }

    public function store(AssignmentRequest $request)
    {
        CRMAssignment::addAssignment($request->company_name, $request->sector,  $request->name,  $request->title,  $request->email,  $request->phone,  $request->note);
        return Redirect::route('get.crm.assignment.index');
    }

    public function edit($id)
    {
        $assignment = CRMAssignment::find($id);
        return view('crm.assignment.edit', compact('assignment'));
    }

    public function show($id)
    {
        $assignment = CRMAssignment::getCustomerById($id);
        return view('crm.assignment.display', compact('assignment'));
    }

    public function update($id, AssignmentRequest $request)
    {
        $assignment = CRMAssignment::updateAssignment($id, $request->company_name, $request->sector, $request->name,  $request->title,  $request->email,  $request->phone,  $request->note);
        if ($assignment == null)
            return Redirect::back()->withErrors(["Atama Bulunamadı"]);

        $queryString = Session::get("ASSIGNMENT_SEARCH");
        if (is_null($queryString))
            return Redirect::route('get.crm.assignment.index');

        $redirectPath = route('get.crm.assignment.search') . "?" . $queryString;
        return redirect($redirectPath);
    }
    public function delete($id)
    {
        $assignment = CRMAssignment::getAssignmentById($id);

        if ($assignment == null)
            return Redirect::back()->withErrors(["Atama Bulunamadı"]);

        $assignment->delete();

        return Redirect::route('get.crm.assignment.index');
    }


    public function search(Request $request)
    {

        $queryString = $request->getQueryString();
        Session::put("ASSIGNMENT_SEARCH", $queryString);

        $assignments = CRMAssignment::search($request);
        $emailTemplates = CRMEmailTemplate::getAllEmailTemplates();
        return view('crm.assignment.index', compact('assignments', 'emailTemplates'));
    }
}
