<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{

    use SoftDeletes;

    protected $table = 'cities';

    protected $fillable = [
        'country_id', 'name'
    ];

    public static function getAllCitiesByCountryId($countryId)
    {
        return self::where('country_id', $countryId)->get();
    }

    public static function getTurkeyCities()
    {
        return self::where('country_id', Country::TR_COUNTRY_ID)->get();
    }

    public static function addCity($name, $countryId)
    {
        $city = new self();
        $city->name = $name;
        $city->country_id = $countryId;
        $city->save();
        return $city;
    }


    public static function editCity($id, $name, $countryId)
    {
        $city = self::find($id);
        if (is_null($city))
            return null;

        $city->name = $name;
        $city->country_id = $countryId;
        $city->save();
        return $city;
    }

    public static function deleteCity($id)
    {
        $city = self::find($id);
        if (is_null($city))
            return false;

        $city->delete();
        return true;
    }
}
