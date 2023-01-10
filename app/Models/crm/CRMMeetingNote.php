<?php

namespace App\Models\crm;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class CRMMeetingNote extends Model
{
    use SoftDeletes;

    protected $table = 'crm_meeting_notes';

    protected $fillable = ['user_id' , 'customer_id', 'meeting_id', 'discussed_topics', 'notes', 'to_dos'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $user = Auth::user();
            $model->user_id = $user->id;
        });
        static::updating(function ($model) {
            $user = Auth::user();
            $model->user_id = $user->id;
        });
        static::deleting(function ($model) {
            $user = Auth::user();
            $model->user_id = $user->id;
        });
    }

    public function meeting()
    {
        return $this->belongsTo(CRMMeeting::class, "meeting_id", "id");
    }

    public static function getMeetingNoteByAllFields($meetingId, $discussedTopics, $notes, $toDos)
    {
        return self::where("meeting_id", $meetingId)
            ->where("discussed_topics", $discussedTopics)
            ->where("to_dos", $toDos)
            ->where("notes", $notes)
            ->first();
    }

    public static function getAllMeetingNotes()
    {
        return self::all();
    }

    public static function getMeetingNotes($meetingId)
    {
        return self::where("meeting_id", $meetingId)->get();
    }

    public static function getCustomerMeetingNotes($customerId)
    {
        return self::with("meeting")->where("customer_id", $customerId)->get();
    }

    public static function addNote($customerId, $meetingId, $discussedTopics, $notes, $toDos)
    {
        $note = self::getMeetingNoteByAllFields($meetingId, $discussedTopics, $notes, $toDos);
        if (!is_null($note))
            return null;

        $note = new self();
        $note->customer_id = $customerId;
        $note->meeting_id = $meetingId;
        $note->discussed_topics = $discussedTopics;
        $note->to_dos = $toDos;
        $note->notes = $notes;
        $note->save();
        return $note;
    }

    public static function editNote($id, $customerId, $meetingId, $discussedTopics, $notes, $toDos)
    {
        $note = self::getMeetingNoteByAllFields($meetingId, $discussedTopics, $notes, $toDos);
        if (!is_null($note))
            return null;

        $note = self::find($id);
        $note->customer_id = $customerId;
        $note->meeting_id = $meetingId;
        $note->discussed_topics = $discussedTopics;
        $note->to_dos = $toDos;
        $note->notes = $notes;
        $note->save();
        return $note;
    }

    public static function deleteNote($id)
    {
        $note = self::find($id);
        if (is_null($note))
            return false;

        $note->delete();
        return true;
    }
}
