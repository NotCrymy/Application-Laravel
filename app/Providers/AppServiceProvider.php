<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;

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
        // Grant all permissions to super admin
        Gate::before(function ($user, $ability) {
            if ($user->hasRole('super-admin')) {
                return true;
            }
        });

        // Gate pour les administrateurs
        Gate::define('admin-access', function ($user) {
            return $user->hasRole('admin');
        });

        // Gate spécifique pour gérer les administrateurs
        Gate::define('manage-admins', function ($user) {
            return $user->hasRole('super-admin');
        });

        // Gate pour les managers
        Gate::define('manager-access', function ($user) {
            return $user->hasRole('manager');
        });

        // Gate pour les cuviste
        Gate::define('cuviste-access', function ($user) {
            return $user->hasRole('cuviste');
        });

        View::composer('*', function ($view) {
            $route = request()->route();
            $proprietaire = $route->parameter('proprietaire');

            $cuveId = null;
            if ($proprietaire && $proprietaire->mouts->isNotEmpty()) {
                $cuveId = $proprietaire->mouts->first()->cuve->id;
            }
            $breadcrumbsConfig = [
                'dashboard' => [
                    ['name' => 'Dashboard', 'url' => route('dashboard')],
                ],
                'cuves.index' => [
                    ['name' => 'Dashboard', 'url' => route('dashboard')],
                    ['name' => 'Cuves', 'url' => route('cuves.index')],
                ],
                'cuves.show' => [
                    ['name' => 'Dashboard', 'url' => route('dashboard')],
                    ['name' => 'Cuves', 'url' => route('cuves.index')],
                    ['name' => 'Détails de la Cuve', 'url' => null],
                ],
                'cuves.edit' => [
                    ['name' => 'Dashboard', 'url' => route('dashboard')],
                    ['name' => 'Cuves', 'url' => route('cuves.index')],
                    ['name' => 'Modifier la Cuve', 'url' => null],
                ],
                'mouts.edit' => [
                    ['name' => 'Dashboard', 'url' => route('dashboard')],
                    ['name' => 'Cuves', 'url' => route('cuves.index')],
                    ['name' => 'Gestion des Moûts de la Cuve', 'url' => null],
                ],
                'users.index' => [
                    ['name' => 'Dashboard', 'url' => route('dashboard')],
                    ['name' => 'Utilisateurs', 'url' => route('users.index')],
                ],
                'proprietaires.show' => [
                    ['name' => 'Dashboard', 'url' => route('dashboard')],
                    ['name' => 'Cuves', 'url' => route('cuves.index')],
                    ['name' => 'Détails de la Cuve', 'url' => $cuveId ? route('cuves.show', $cuveId) : route('cuves.index')],
                    ['name' => 'Détails du Propriétaire', 'url' => null],
                ],
                'users.edit' => [
                    ['name' => 'Dashboard', 'url' => route('dashboard')],
                    ['name' => 'Utilisateurs', 'url' => route('users.index')],
                    ['name' => 'Modifier Utilisateur', 'url' => null],
                ],
                'logs.index' => [
                    ['name' => 'Dashboard', 'url' => route('dashboard')],
                    ['name' => 'Logs', 'url' => route('logs.index')],
                ],
            ];
    
            $routeName = Route::currentRouteName();
            $breadcrumbs = $breadcrumbsConfig[$routeName] ?? [];
            $view->with('breadcrumbs', $breadcrumbs);
        });
    }

    protected $policies = [
        \App\Models\Cuve::class => \App\Policies\CuvePolicy::class,
    ];
}
