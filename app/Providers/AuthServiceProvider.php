<?php

namespace App\Providers;

use App\Models\tms\TMSCustomer;
use App\Models\tms\TMSPreorder;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // TMSPreorder::class => PreorderPolicy::class,
        'App\Models\Model' => 'App\Policies\ModelPolicy', //uncomment
    ];
    public function boot()
    {
        $this->registerPolicies();
        Passport::routes();
        Gate::before(function ($user, $ability) {
            return $user->hasRole('super-admin') ? true : null;
        });

        Gate::define('preorder', function (User $user, $preorder) {
            return $user->tms_id === $preorder;
        });
    }
}
