<?php

namespace App\Models\tms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TMSCustomerIncome extends Model
{
    use SoftDeletes;

    protected $table = 'tms_customer_incomes';

    protected $fillable = [
        'customer_id', 'date', 'income'
    ];

    public function customer()
    {
        return $this->belongsTo(TMSCustomer::class, 'customer_id');
    }

    public static function getCustomerIncomes($customerId)
    {
        return self::with('customer')->where('customer_id', $customerId)->get();
    }

    public function incomes()
    {
        return $this->hasMany(TMSCustomerIncome::class, 'customer_id');
    }

    public static function addCustomerIncome($customerId, $date, $income)
    {
        $customerHasIncome = self::where('date', $date)->first();
        if ($customerHasIncome)
            return null;

        $customerIncome = new self();
        $customerIncome->customer_id = $customerId;
        $customerIncome->date = $date;
        $customerIncome->income= str_replace(',', '.', $income);
        $customerIncome->save();
        return $customerIncome;
    }

    public static function updateCustomerIncome($id, $customerId, $date, $income)
    {
        $customerIncome = self::find($id);
        if (is_null($customerIncome)) {
            $customerIncome = new self();
            $customerIncome->customer_id= $customerId;
        }

        $customerIncome->date = $date;
        $customerIncome->income= str_replace(',', '.', $income);
        $customerIncome->save();
        return $customerIncome;
    }

    public static function deleteCustomerIncome($id)
    {
        $customerIncome = self::find($id);
        if (is_null($customerIncome))
            return false;

        $customerIncome->delete();
        return true;
    }

}
