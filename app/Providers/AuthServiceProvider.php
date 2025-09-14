<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User;
use App\Models\Setting;
use App\Policies\UserPolicy;
use App\Policies\SettingPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class => UserPolicy::class,
        Setting::class => SettingPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}