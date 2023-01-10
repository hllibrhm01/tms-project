<?php

namespace App\Models\wms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\City;
use App\Models\District;

class WMSLocation extends Model
{
    use SoftDeletes;

    protected $table = "wms_locations";
    protected $fillable = [
        'country',
        'city_id',
        'district_id',
        'address_description',
        'authorized_person',
        'email',
        'phone',
        'capacity'
    ]; 
    
    public function city()
    {
        return  $this->belongsTo(City::class, 'city_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public static function getCityAndDistrict($id)
    {
        return self::with('city' , 'district')->get();
    }


    public static function addLocation($request) 
    {
        $wmsLocations = new self();
        // $wmsLocations->country= $request->country;
        $wmsLocations->city_id= $request->city_id;
        $wmsLocations->district_id= $request->district_id;
        $wmsLocations->address_description= $request->address_description;
        $wmsLocations->authorized_person = $request->authorized_person;
        $wmsLocations->email= $request->email;
        $wmsLocations->phone= $request->phone;
        $wmsLocations->capacity= $request->capacity;
        $wmsLocations->save();
        return $wmsLocations;
    }

    public static function editLocation($id, $request) 
    { 
        $wmsLocation = self::find($id);
        if(is_null($id))
            return null;
            
        // $wmsLocation->country= $request->country;
        $wmsLocation->city_id= $request->city_id;
        $wmsLocation->district_id= $request->district_id;
        $wmsLocation->address_description= $request->address_description;
        $wmsLocation->authorized_person = $request->authorized_person;
        $wmsLocation->email= $request->email;
        $wmsLocation->phone= $request->phone;
        $wmsLocation->capacity= $request->capacity;
        $wmsLocation->save();
        return $wmsLocation;
    }

    /*
    public static function updateLocation($id)
    {
        $location = self::find($id);
        if (is_null($location))
            return null;

        $location->$id;
        $location->save();
        return $location;
    }
    */

    public static function deleteLocation($id) 
    {
        $wmsLocation = self::find($id);

        if(is_null($wmsLocation))
            return false;

        $wmsLocation->delete();
        return true;
    }
}
