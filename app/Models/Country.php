<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{

    use SoftDeletes;

    const TR_COUNTRY_ID = 1;

    protected $table = 'countries';

    protected $fillable = ['name', 'iso_code'];

    public static function getAllCountries()
    {
        return self::all();
    }

    public static function getCountry()
    {
        return self::find(self::TR_COUNTRY_ID);
    }

    public static function addCountry($name, $iso_code)
    {
        $country = new self();
        $country->name = $name;
        $country->iso_code = $iso_code;
        $country->save();
        return $country;
    }

    public static function editCountry($id, $name, $iso_code)
    {
        $country = self::find($id);
        $country->name = $name;
        $country->iso_code = $iso_code;
        $country->save();
        return $country;
    }

    public static function deleteCountry($id)
    {
        $country = self::find($id);
        if (is_null($country)) {
            return false;
        }

        $country->delete();
        return true;
    }
}
