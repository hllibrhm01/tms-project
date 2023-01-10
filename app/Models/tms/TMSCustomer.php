<?php

namespace App\Models\tms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\City;
use App\Models\District;
use App\Models\TaxDepartment;
use App\Models\tms\TMSOrder;
use Illuminate\Database\Eloquent\SoftDeletes;

class TMSCustomer extends Model
{

    use SoftDeletes;

    protected $table = "tms_customers";
    protected $fillable = [
        'group_type',
        'work_type',
        'company_name',
        'billing_period',
        'payment_type',
        'iban',
        'tax_department_city_id',
        'tax_department_district_id',
        'tax_number',
        'progress_payment_type',
        'progress_payment_rate',
        'note'
    ];

    const  PROGRESS_PAYMENT_TYPES = [
        "ORAN" => 1,
        "TEK FİYAT"  => 2,
        "ÜRÜN LİSTESİ" =>  3
    ];

    public function papers()
    {
        return $this->hasMany(TMSCustomerPaper::class, 'customer_id');
    }

    public function authors()
    {
        return $this->hasMany(TMSCustomerAuthor::class, 'customer_id');
    }

    public function addresses()
    {
        return $this->hasMany(TMSCustomerAddress::class, 'customer_id');
    }

    public function incomes()
    {
        return $this->hasMany(TMSCustomerIncome::class, 'customer_id');
    }

    public function products()
    {
        return $this->hasMany(TMSCustomerProduct::class, 'customer_id');
    }

    public function order()
    {
        return $this->belongsTo(TMSOrder::class, 'owner_id');
    }

    public static function getOrders($customerId)
    {
        return TMSOrder::where('owner_id', $customerId)->get();
    }

    public static function getCustomer($id)
    {
        return self::with(['addresses.district', 'addresses.city', 'products', 'incomes', 'authors', 'papers'])->whereId($id)->first();
    }

    public function city()
    {
        return  $this->belongsTo(City::class, 'tax_department_city_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'tax_department_district_id');
    }

    public function tax_department()
    {
        return $this->belongsTo(TaxDepartment::class, 'tax_department_district_id');
    }

    public static function addCustomer($request)
    {
        $tmsCustomer = new self();
        $tmsCustomer->group_type = $request->group_type;
        $tmsCustomer->work_type = $request->work_type;
        $tmsCustomer->billing_period = $request->billing_period;
        $tmsCustomer->payment_type = $request->payment_type;
        $tmsCustomer->company_name = strtoupper($request->company_name);
        $tmsCustomer->tax_department_city_id = $request->tax_department_city_id;
        $tmsCustomer->tax_department_district_id = $request->tax_department_district_id;
        $tmsCustomer->tax_department_id = $request->tax_department_id;
        $tmsCustomer->tax_number = $request->tax_number;
        $tmsCustomer->progress_payment_rate = str_replace(',', '.', $request->progress_payment_rate);
        $tmsCustomer->progress_payment_type = $request->progress_payment_type;
        $tmsCustomer->iban = strtoupper($request->iban);
        $tmsCustomer->note = strtoupper($request->note);
        $tmsCustomer->save();
        $tmsCustomer = self::getCustomer($tmsCustomer->id);
        return $tmsCustomer;
    }

    public static function editCustomer($id, $request)
    {
        $tmsCustomer = self::find($id);
        if (is_null($id))
            return null;

        $tmsCustomer->group_type = $request->group_type;
        $tmsCustomer->work_type = $request->work_type;
        $tmsCustomer->billing_period = $request->billing_period;
        $tmsCustomer->payment_type = $request->payment_type;
        $tmsCustomer->company_name = strtoupper($request->company_name);
        $tmsCustomer->tax_department_city_id = $request->tax_department_city_id;
        $tmsCustomer->tax_department_district_id = $request->tax_department_district_id;
        $tmsCustomer->tax_department_id = $request->tax_department_id;
        $tmsCustomer->tax_number = $request->tax_number;
        $tmsCustomer->progress_payment_rate = str_replace(',', '.', $request->progress_payment_rate);
        $tmsCustomer->progress_payment_type = $request->progress_payment_type;
        $tmsCustomer->iban = strtoupper($request->iban);
        $tmsCustomer->note = strtoupper($request->note);
        $tmsCustomer->save();
        $tmsCustomer = self::getCustomer($tmsCustomer->id);
        return $tmsCustomer;
    }

    public static function deleteCustomer($id)
    {
        $tmsCustomer = self::find($id);

        if (is_null($tmsCustomer))
            return false;

        $tmsCustomer->delete();
        return true;
    }

    public static function search($request)
    {
        return self::when(!empty($request->company_name), function ($query) use ($request) {
            $query->where('company_name', 'like', '%' . $request->company_name . '%');
        })->get();
    }
}
