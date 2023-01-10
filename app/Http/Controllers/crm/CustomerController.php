<?php

namespace App\Http\Controllers\crm;

use App\Http\Controllers\Controller;
use App\Http\Requests\crm\CustomerRequest;
use App\Models\crm\CRMCustomer;
use App\Models\crm\CRMEmailTemplate;
use App\Models\crm\CRMMeeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{
    public function index()
    {
        Session::remove("CUSTOMER_SEARCH");
        $customers = CRMCustomer::getAllCustomers();
        return view('crm.customer.index', compact('customers'));
    }

    public function add()
    {
        return view('crm.customer.add');
    }

    public function store(CustomerRequest $request)
    {
        CRMCustomer::addCustomer($request);
        return Redirect::route('get.crm.customer.index');
    }

    public function edit($id)
    {
        $customer = CRMCustomer::find($id);
        $meetings = CRMMeeting::getCustomerMeetings($customer->id);
        return view('crm.customer.edit', compact('customer', 'meetings'));
    }

    public function show($id)
    {
        $customer = CRMCustomer::getCustomerById($id);
        $emailTemplates = CRMEmailTemplate::getAllEmailTemplates();
        return view('crm.customer.display', compact('customer', 'emailTemplates'));
    }

    public function update($id, CustomerRequest $request)
    {
        $customer = CRMCustomer::updateCustomer($id, $request);
        if ($customer == null)
            return Redirect::back()->withErrors(["User Bulunamadı"]);

        $queryString = Session::get("CUSTOMER_SEARCH");
        if (is_null($queryString))
            return Redirect::route('get.crm.customer.index');

        $redirectPath = route('get.crm.customer.search') . "?" . $queryString;
        return redirect($redirectPath);
    }
    public function delete($id)
    {
        $customer = CRMCustomer::getCustomerById($id);
        if ($customer == null)
            return Redirect::back()->withErrors(["User Bulunamadı"]);

        $customer->delete();
        return Redirect::route('get.crm.customer.index');
    }

    public function search(Request $request)
    {
        $queryString = $request->getQueryString();
        Session::put("CUSTOMER_SEARCH", $queryString);
        $customers = CRMCustomer::search($request);
        return view('crm.customer.index', compact('customers'));
    }

    public function updateResponsiblePerson(Request $request)
    {
        $oldResponsibleId = $request->old_responsible_id;
        $newResponsibleId = $request->new_responsible_id;
        CRMCustomer::updateResponsiblePerson($oldResponsibleId, $newResponsibleId);
        return "OK";
    }

}
