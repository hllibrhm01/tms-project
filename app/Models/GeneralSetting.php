<?php

namespace App\Models;

use App\Http\Requests\GeneralSettingRequest;
use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    protected $table = 'general_settings';

    protected $fillable = [
        'copyright', 'daily_meal_price', 'code_mandatory_status', 'note_mandatory_status', 'image_mandatory_status',  'dealer_notify_mandatory_status',  'planner_notify_mandatory_status', 'orderer_notify_mandatory_status'
    ];

    protected $casts = [
        'code_mandatory_status', 'note_mandatory_status', 'image_mandatory_status', 'dealer_notify_mandatory_status', 'orderer_notify_mandatory_status',  'planner_notify_mandatory_status'
    ];

    public static function getSettings()
    {
        return self::first();
    }

    public static function updateSettings(GeneralSettingRequest $request)
    {
        $setting = self::first();
        if (is_null($setting))
            $setting = new self();

        $setting->copyright = $request->copyright;
        $setting->daily_meal_price = str_replace(',', '.', $request->daily_meal_price);
        $setting->code_mandatory_status = $request->code_mandatory_status;
        $setting->note_mandatory_status = $request->note_mandatory_status;
        $setting->image_mandatory_status = $request->image_mandatory_status;
        $setting->dealer_notify_mandatory_status = $request->dealer_notify_mandatory_status;
        $setting->planner_notify_mandatory_status = $request->planner_notify_mandatory_status;
        $setting->orderer_notify_mandatory_status = $request->orderer_notify_mandatory_status;
        $setting->save();
        return $setting;
    }
}
