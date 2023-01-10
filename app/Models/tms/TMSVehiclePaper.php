<?php

namespace App\Models\tms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class TMSVehiclePaper extends Model
{
    use SoftDeletes;

    protected $table = 'tms_vehicle_papers';

    protected $fillable = ['vehicle_id', 'type', 'description', 'path'];


    public static function getVehiclePaper($id)
    {
        return self::find($id);
    }

    public static function getVehiclePapers($vehicleId)
    {
        return self::where("vehicle_id", $vehicleId)->get();
    }

    public static function getVehiclePapersToDisplay($vehicleId)
    {
        $papers = self::where("vehicle_id", $vehicleId)->get();
        foreach ($papers as $paper)
            $paper->type = config('constants.vehicle_paper_types')[$paper->type];

        return $papers;
    }

    public static function addVehiclePaper($vehicleId, $type, $description, $path)
    {

        $paper = new self();
        $paper->vehicle_id = $vehicleId;
        $paper->type = $type;
        $paper->description = $description;
        $paper->path = $path;
        $paper->save();
        return $paper;
    }

    public static function editVehiclePaper($id, $vehicleId, $type, $description, $path)
    {
        $paper = self::find($id);
        if (is_null($paper))
            return null;

        $paper->vehicle_id = $vehicleId;
        $paper->type = $type;
        $paper->description = $description;
        $paper->path = $path;
        $paper->save();
        return $paper;
    }
}
