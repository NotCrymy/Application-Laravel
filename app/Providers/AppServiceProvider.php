<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Gate pour les administrateurs
        Gate::define('admin-access', function ($user) {
            return $user->hasRole('admin');
        });

        // Gate pour les managers
        Gate::define('manager-access', function ($user) {
            return $user->hasRole('manager');
        });

        // Gate pour les cavistes
        Gate::define('caviste-access', function ($user) {
            return $user->hasRole('caviste');
        });
    }
}
