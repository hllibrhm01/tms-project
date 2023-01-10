<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaxDepartment extends Model
{
    use SoftDeletes;

    protected $table = 'tax_departments';

    protected $fillable = [
        'id',
        'district_id',
        'name'
    ];

    public static function addTaxDepartment() {}

    public static function getDistrictTaxDepartment($districtId)
    {
        return self::where('district_id', $districtId)->get();
    }

}
