<?php

namespace App\Http\Controllers\crm;

use App\Http\Controllers\Controller;
use App\Http\Requests\crm\ReminderRequest;
use App\Models\crm\CRMCustomerReminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ReminderController  extends Controller
{

    public function store(ReminderRequest $request)
    {
        CRMCustomerReminder::addCustomerReminder($request->customer_id, $request->email, $request->abstract, $request->body, $request->is_completed, $request->finish_time);
        $reminders = CRMCustomerReminder::getCustomerReminders($request->customer_id);
        return response()->json((["error" => false, "message" => "Hatırlatma eklendi.", "reminders" => $reminders]));
    }

    public function edit(Request $request)
    {
        if (!$request->exists("id"))
            return response()->json((["error" => true, "message" => "Hatırlatma bulunamadı."]));

        $reminder = CRMCustomerReminder::find($request->id);
        return response()->json((["error" => false, "message" => "Hatırlatma güncellendi.", "reminder" => $reminder]));
    }

    public function update(ReminderRequest $request)
    {
        if (!$request->exists("id") || !$request->exists("customer_id"))
            return response()->json((["error" => true, "message" => "Hatırlatma bulunamadı."]));

        CRMCustomerReminder::editCustomerReminder($request->id, $request->customer_id, $request->email, $request->abstract, $request->body, $request->is_completed, $request->finish_time);

        $reminders = CRMCustomerReminder::getCustomerReminders($request->customer_id);
        return response()->json((["error" => false, "message" => "Hatırlatma güncellendi.", "reminders" => $reminders]));
    }

    public function delete(Request $request)
    {
        if (!$request->exists("id") || !$request->exists("customer_id"))
            return response()->json((["error" => true, "message" => "Hatırlatma bulunamadı."]));

        $reminder = CRMCustomerReminder::find($request->id);
        if (!is_null($reminder))
            $reminder->delete();

        $reminders = CRMCustomerReminder::getCustomerReminders($request->customer_id);
        return response()->json((["error" => false, "message" => "Hatırlatma silindi.", "reminders" => $reminders]));
    }
}
