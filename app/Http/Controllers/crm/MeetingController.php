<?php

namespace App\Http\Controllers\crm;

use App\Http\Controllers\Controller;
use App\Http\Requests\crm\MeetingRequest;
use App\Models\crm\CRMMeeting;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function store(MeetingRequest $request)
    {
        CRMMeeting::addMeeting($request->customer_id, $request->type, $request->header, $request->description, $request->schedule_date);

        $meetings = CRMMeeting::getCustomerMeetings($request->customer_id);
        foreach ($meetings as $meeting)
            $meeting->type = config('constants.meet_types')[$meeting->type];

        return response()->json((["error" => false, "message" => "Toplantı düzenlendi.", "meetings" => $meetings]));
    }

    public function edit(Request $request)
    {
        if (!$request->exists("id"))
            return response()->json((["error" => true, "message" => "Toplantı bulunamadı."]));

        $meeting = CRMMeeting::getMeeting($request->id);
        return response()->json((["error" => false, "message" => "Toplantı düzenlendi.", "meeting" => $meeting]));
    }

    public function update(MeetingRequest $request)
    {
        if (!$request->exists("id"))
            return response()->json((["error" => true, "message" => "Toplantı bulunamadı."]));

        CRMMeeting::editMeeting($request->id, $request->customer_id, $request->type, $request->header, $request->description, $request->schedule_date);

        $meetings = CRMMeeting::getCustomerMeetings($request->customer_id);
        foreach ($meetings as $meeting)
            $meeting->type = config('constants.meet_types')[$meeting->type];

        return response()->json((["error" => false, "message" => "Toplantı düzenlendi.", "meetings" => $meetings]));
    }

    public function delete(Request $request)
    {
        if (!$request->exists("id"))
            return response()->json((["error" => true, "message" => "Toplantı bulunamadı."]));

        $meeting = CRMMeeting::find($request->get("id"));
        if (!is_null($meeting))
            $meeting->delete();


        $meetings = CRMMeeting::getCustomerMeetings($request->customer_id);
        foreach ($meetings as $meeting)
            $meeting->type = config('constants.meet_types')[$meeting->type];

        return response()->json((["error" => false, "message" => "Toplantı Silindi.", "meetings" => $meetings]));
    }
}
