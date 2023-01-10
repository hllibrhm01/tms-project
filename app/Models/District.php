<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class District extends Model
{

    use SoftDeletes;

    protected $table = 'districts';

    protected $fillable = [
        'city_id', 'name'
    ];


    public static function getCityDistricts($cityId)
    {
        return self::where('city_id', $cityId)->get();
    }
}
