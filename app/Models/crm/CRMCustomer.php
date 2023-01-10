<?php

namespace App\Models\crm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class CRMCustomer extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'crm_customers';
    
    protected $fillable = ['user_id', 'company_name', 'sector', 'author', 'title', 'email', 'phone', 'call_content', 'call_detail', 'note'];

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

    public function user()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public function meetings()
    {
        return $this->hasMany(CRMMeeting::class, "customer_id", "id");
    }

    public function meetingNotes()
    {
        return $this->hasMany(CRMMeetingNote::class, "customer_id", "id");
    }

    public function papers()
    {
        return $this->hasMany(CRMCustomerPaper::class, "customer_id", "id");
    }

    public function mails()
    {
        return $this->hasMany(CRMCustomerMail::class, "customer_id", "id");
    }

    public function reminders()
    {
        return $this->hasMany(CRMCustomerReminder::class, "customer_id", "id")->orderBy("finish_time");
    }

    public static function getCustomerById($id)
    {
        return self::whereId($id)
            ->with(["mails", "papers", "meetings", "meetingNotes.meeting", "reminders"])->first();
    }

    public static function getAllCustomers()
    {
        return self::with('user')->get();
    }

    public static function getCustomerByFields($companyName, $author)
    {
        return self::where('company_name', $companyName)->where('author', $author)->first();
    }

    public static function getCustomerBySector($sector, $title)
    {
        return self::when(!empty($sector), function ($query) use ($sector) {
            $query->where('sector', $sector);
        })->when(!empty($title), function ($query) use ($title) {
            $query->where('title', $title);
        })->get();
    }

    public static function addCustomer($request)
    {
        $customer = self::getCustomerByFields($request->company_name , $request->author);
        if ($customer != null)
            return null;

        $customer = new self();
        $customer->company_name = $request->company_name;
        $customer->sector = $request->sector;
        $customer->author = $request->author;
        $customer->title = $request->title;
        $customer->email = self::cleanEmail($request->email);
        $customer->phone =  $request->phone;
        $customer->call_content =   $request->call_content;
        $customer->call_detail = $request->call_detail;
        $customer->note =   $request->note;
        $customer->save();

        return $customer;
    }

    public static function updateCustomer($id, $request)
    {
        $customer = self::find($id);
        if ($customer == null)
            return null;

        $customer->company_name = $request->company_name;
        $customer->sector = $request->sector;
        $customer->author = $request->author;
        $customer->title = $request->title;
        $customer->email =  self::cleanEmail($request->email);
        $customer->phone =  $request->phone;
        $customer->call_content =   $request->call_content;
        $customer->call_detail = $request->call_detail;
        $customer->note =   $request->note;
        $customer->save();
        return $customer;
    }


    public static function getSectorGroupedCustomers()
    {
        return self::whereNotNull('sector')->get()->groupBy("sector");
    }

    public static function getTitleGroupedCustomers()
    {
        return self::whereNotNull('title')->get()->groupBy("title");
    }

    public static function updateResponsiblePerson($oldUserId, $newUserId)
    {
        $oldUserCustomers = self::where('user_id', $oldUserId)->get();
        foreach ($oldUserCustomers as $customer) {
            $customer->user_id = $newUserId;
            $customer->save();
        }
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
            })->when(!empty($request->get('author')), function ($query) use ($request) {
                $query->where('author', 'ILIKE', "%" . $request->input('author') . "%");
            })->with('user')->get();
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
