<?php

namespace App\Providers;

use App\Models\GeneralSetting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /*
        URL::forceRootUrl(config('app.url'));
        if (str_contains(config('app.url'), 'https://')) {
            URL::forceScheme('https');
        }
        */

        if (Schema::hasTable('general_settings')) {
            $setting = GeneralSetting::getSettings();
            view()->share('setting', $setting);
        }
    }
}
