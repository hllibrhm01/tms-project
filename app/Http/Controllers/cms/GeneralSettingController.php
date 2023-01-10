<?php

namespace App\Http\Controllers\cms;

use App\Http\Controllers\Controller;
use App\Http\Requests\GeneralSettingRequest;
use App\Models\GeneralSetting;
use Illuminate\Support\Facades\Redirect;

class GeneralSettingController extends Controller
{
    public function index()
    {
        $setting = GeneralSetting::getSettings();   
        return view('cms.general-settings.index', compact('setting'));
    }

    public function update(GeneralSettingRequest $request)
    {
        GeneralSetting::updateSettings($request);
        return Redirect::route('get.cms.general.settings');    
    }
}
