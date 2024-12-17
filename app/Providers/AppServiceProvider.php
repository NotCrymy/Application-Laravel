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
        // Accorde toutes les permissions au super-admin
        Gate::before(function ($user, $ability) {
            if ($user->hasRole('super-admin')) {
                return true;
            }
        });

        // Gates pour les rôles spécifiques
        Gate::define('admin-access', function ($user) {
            return $user->hasRole('admin');
        });

        Gate::define('manage-admins', function ($user) {
            return $user->hasRole('super-admin');
        });

        Gate::define('manager-access', function ($user) {
            return $user->hasRole('manager');
        });

        Gate::define('cuviste-access', function ($user) {
            return $user->hasRole('cuviste');
        });

        // Configuration pour le fil d'Ariane (breadcrumbs)
        // Le View::composer('*', ...) s'applique à toutes les vues de l'application.
        // Il permet de partager des données globales (comme ici les breadcrumbs) avec chaque vue avant son rendu.
        // Cela évite de passer ces données manuellement à chaque appel de `view()`.
        View::composer('*', function ($view) {
            $route = request()->route();
            $proprietaire = $route->parameter('proprietaire');

            // Récupération de l'ID de la cuve à partir du propriétaire
            $cuveId = null;
            if ($proprietaire && $proprietaire->mouts->isNotEmpty()) {
                $cuveId = $proprietaire->mouts->first()->cuve->id;
            }

            // Configuration des chemins du fil d'Ariane
            $breadcrumbsConfig = [
                'dashboard' => [
                    ['name' => 'Dashboard', 'url' => null],
                ],
                'cuves.etat' => [
                    ['name' => 'Dashboard', 'url' => route('dashboard')],
                    ['name' => 'Etat des cuves', 'url' => null],
                ],
                'cuves.index' => [
                    ['name' => 'Dashboard', 'url' => route('dashboard')],
                    ['name' => 'Cuves', 'url' => null],
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
                    ['name' => 'Utilisateurs', 'url' => null],
                ],
                'proprietaires.show' => [
                    ['name' => 'Dashboard', 'url' => route('dashboard')],
                    ['name' => 'Cuves', 'url' => route('cuves.index')],
                    ['name' => 'Détails de la Cuve', 'url' => $cuveId ? route('cuves.show', $cuveId) : route('cuves.index')],
                    ['name' => 'Fiche du Propriétaire', 'url' => null],
                ],
                'users.edit' => [
                    ['name' => 'Dashboard', 'url' => route('dashboard')],
                    ['name' => 'Utilisateurs', 'url' => route('users.index')],
                    ['name' => 'Modifier Utilisateur', 'url' => null],
                ],
                'logs.index' => [
                    ['name' => 'Dashboard', 'url' => route('dashboard')],
                    ['name' => 'Logs', 'url' => null],
                ],
                'proprietaires.index' => [
                    ['name' => 'Dashboard', 'url' => route('dashboard')],
                    ['name' => 'Propriétaires', 'url' => null],
                ],
            ];

            // Détermine le chemin actuel pour le fil d'Ariane
            $routeName = Route::currentRouteName();
            $breadcrumbs = $breadcrumbsConfig[$routeName] ?? [];
            $view->with('breadcrumbs', $breadcrumbs);
        });
    }

    // Déclaration des politiques
    protected $policies = [
        \App\Models\Cuve::class => \App\Policies\CuvePolicy::class,
    ];
}