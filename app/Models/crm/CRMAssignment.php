<?php

namespace App\Models\crm;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CRMAssignment extends Model
{
    use SoftDeletes;

    protected $table = 'crm_assignments';

    protected $fillable = ['user_id', 'company_name', 'sector', 'name', 'title', 'email', 'phone', 'note'];

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

    public static function getAllAssignments()
    {
        return self::all();
    }

    public static function getAssingmentByFields($companyName, $name)
    {
        return self::where('company_name', $companyName)->where('name', $name)->first();
    }

    public static function addAssignment($companyName, $sector, $name, $title, $email, $phone, $note)
    {
        $customer = self::getAssingmentByFields($companyName, $name);
        if ($customer != null)
            return null;

        $assignment = new self();
        $assignment->company_name = $companyName;
        $assignment->sector = $sector;
        $assignment->name = $name;
        $assignment->title = $title;
        $assignment->email = self::cleanEmail($email);
        $assignment->phone = $phone;
        $assignment->note = $note;
        $assignment->save();
        return $assignment;
    }

    public static function updateAssignment($id, $companyName, $sector, $name, $title, $email, $phone, $note)
    {
        $assignment = self::find($id);
        $assignment->company_name = $companyName;
        $assignment->sector = $sector;
        $assignment->name = $name;
        $assignment->title = $title;
        $assignment->email = self::cleanEmail($email);
        $assignment->phone = $phone;
        $assignment->note = $note;
        $assignment->save();
        return $assignment;
    }

    public static function getAssignmentById($id)
    {
        return self::find($id);
    }

    public static function getAssignmentByTitle($title)
    {
        return self::when(!empty($sector), function ($query) use ($title) {
            $query->where('title', $title);
        })->get();
    }

    public static function getTitleGroupedAssignment()
    {
        return self::whereNotNull('title')->get()->groupBy("title");
    }

    public static function search(Request $request)
    {
        return self::when(!empty($request->get('company_name')), function ($query) use ($request) {
            $query->where('company_name', 'ILIKE', "%" . $request->input('company_name') . "%");
        })
            ->when(!empty($request->get('sector')), function ($query) use ($request) {
                $query->where('sector', 'ILIKE', "%" . $request->input('sector') . "%");
            })->when(!empty($request->get('title')), function ($query) use ($request) {
                $query->where('title', 'ILIKE', "%" . $request->input('title') . "%");
            })->when(!empty($request->get('name')), function ($query) use ($request) {
                $query->where('name', 'ILIKE', "%" . $request->input('name') . "%");
            })->get();
    }


    public static  function cleanEmail($str)
    {
        $before = array('ı', 'ğ', 'ü', 'ş', 'ö', 'ç', 'İ', 'Ğ', 'Ü', 'Ö', 'Ç'); // , '\'', '""'
        $after   = array('i', 'g', 'u', 's', 'o', 'c', 'i', 'g', 'u', 'o', 'c'); // , '', ''
        $clean = str_replace($before, $after, $str);
        $clean = strtolower(trim($clean));
        return $clean;
    }
}
