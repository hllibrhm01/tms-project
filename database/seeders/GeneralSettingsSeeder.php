<?php

namespace Database\Seeders;

use App\Models\GeneralSetting;
use Illuminate\Database\Seeder;

class GeneralSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = new GeneralSetting();
        $setting->copyright = "Telif Hakkı © 2022-2023 1K2A. Tüm hakları saklıdır.";
        $setting->daily_meal_price = 55.0;
        $setting->code_mandatory_status = "[8]";
        $setting->note_mandatory_status = "[6,11,12,13,14]";
        $setting->image_mandatory_status = "[4,6,7,9,10,11,12]";
        $setting->dealer_notify_mandatory_status = "[1,2,6,7,11,13]";
        $setting->planner_notify_mandatory_status = "[11,12,13]";
        $setting->orderer_notify_mandatory_status = "[2,7,12]";
        $setting->save();
    }
}