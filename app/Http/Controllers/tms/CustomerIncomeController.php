<?php

namespace App\Http\Controllers\tms;

use App\Http\Controllers\Controller;
use App\Http\Requests\tms\CustomerIncomeRequest;
use Illuminate\Http\Request;
use App\Models\tms\TMSCustomerIncome;

class CustomerIncomeController extends Controller
{

    public function store(CustomerIncomeRequest $request)
    {
        TMSCustomerIncome::addCustomerIncome($request->customer_id, $request->date, $request->income);
        $incomes = TMSCustomerIncome::getCustomerIncomes($request->customer_id);
        return response()->json((["error" => false, "message" => "Hakediş eklendi.", "incomes" => $incomes]));
    }

    public function edit(Request $request)
    {
        if (!$request->exists("id"))
            return response()->json((["error" => true, "message" => "Hakediş bulunamadı."]));

        $income = TMSCustomerIncome::find($request->id);
        return response()->json((["error" => false, "message" => "Hakediş getirildi.", "income" => $income]));
    }

    public function update(CustomerIncomeRequest $request)
    {
        if (!$request->exists("id"))
            return response()->json((["error" => true, "message" => "Hakediş bulunamadı."]));

        TMSCustomerIncome::updateCustomerIncome($request->id, $request->customer_id, $request->date, $request->income);
        $incomes = TMSCustomerIncome::getCustomerIncomes($request->customer_id);
        return response()->json((["error" => false, "message" => "Hakediş güncellendi.", "incomes" => $incomes]));
    }

    public function delete(Request $request)
    {
        if (!$request->exists("id"))
            return response()->json((["error" => true, "message" => "Hakediş bulunamadı."]));

        $customerId = -1;
        $income = TMSCustomerIncome::find($request->id);
        if (!is_null($income)) {
            $customerId = $income->customer_id;
            $income->delete();
        }

        if ($customerId == -1)
            return response()->json((["error" => true, "message" => "Hakediş bulunamadı."]));

        $incomes = TMSCustomerIncome::getCustomerIncomes($request->customer_id);
        return response()->json((["error" => false, "message" => "Hakediş silindi.", "incomes" => $incomes]));
    }

}
