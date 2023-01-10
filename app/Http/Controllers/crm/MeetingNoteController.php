<?php

namespace App\Http\Controllers\crm;

use App\Http\Controllers\Controller;
use App\Http\Requests\crm\MeetingNoteRequest;
use App\Models\crm\CRMMeetingNote;
use Illuminate\Http\Request;

class MeetingNoteController  extends Controller
{
    public function store(MeetingNoteRequest $request)
    {
        CRMMeetingNote::addNote($request->customer_id, $request->meeting_id, $request->discussed_topics, $request->notes, $request->to_dos);
        $meetingNotes = CRMMeetingNote::getCustomerMeetingNotes($request->customer_id);
        foreach ($meetingNotes as $meetingNote)
            $meetingNote->meeting->meet_type = config('constants.meet_types')[$meetingNote->meeting->type];

        return response()->json((["error" => false, "message" => "Toplantı notu eklendi.", "meetingNotes" => $meetingNotes]));
    }

    public function edit(Request $request)
    {
        if (!$request->exists("id"))
            return response()->json((["error" => true, "message" => "Toplantı notu bulunamadı."]));

        $meetingNote = CRMMeetingNote::find($request->id);
        return response()->json((["error" => false, "message" => "Toplantı notu düzenlendi.", "meetingNote" => $meetingNote]));
    }

    public function update(MeetingNoteRequest $request)
    {
        if (!$request->exists("id"))
            return response()->json((["error" => true, "message" => "Toplantı notu bulunamadı."]));

        CRMMeetingNote::editNote($request->id, $request->customer_id, $request->meeting_id, $request->discussed_topics, $request->notes, $request->to_dos);
        $meetingNotes = CRMMeetingNote::getCustomerMeetingNotes($request->customer_id);
        foreach ($meetingNotes as $meetingNote)
            $meetingNote->meeting->meet_type = config('constants.meet_types')[$meetingNote->meeting->type];

        return response()->json((["error" => false, "message" => "Toplantı notu düzenlendi.", "meetingNotes" => $meetingNotes]));
    }

    public function delete(Request $request)
    {
        if (!$request->exists("id"))
            return response()->json((["error" => true, "message" => "Toplantı notu bulunamadı."]));

        $meetingNote = CRMMeetingNote::find($request->id);
        if (!is_null($meetingNote))
            $meetingNote->delete();

        $meetingNotes = CRMMeetingNote::getCustomerMeetingNotes($request->customer_id);
        foreach ($meetingNotes as $meetingNote)
            $meetingNote->meeting->meet_type = config('constants.meet_types')[$meetingNote->meeting->type];

        return response()->json((["error" => false, "message" => "Toplantı notu silindi.", "meetingNotes" => $meetingNotes]));
    }
}
