<?php

namespace App\Models\tms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TMSEquipment extends Model
{
    use SoftDeletes;

    protected $table = 'tms_supplied_equipments';

    protected $fillable = [
        'equipment_name'
    ];

    public static function getAllEquipments()
    {
        return self::all();
    }

}
