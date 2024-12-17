<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Cuve;

class CuvePolicy
{
    // Vérifie si l'utilisateur peut consulter une cuve
    public function view(User $user, Cuve $cuve)
    {
        return $user->hasRole('manager') || $user->hasRole('cuviste') || $user->hasRole('admin');
    }

    // Vérifie si l'utilisateur peut mettre à jour une cuve
    public function update(User $user, Cuve $cuve)
    {
        return $user->hasRole('cuviste') || $user->hasRole('admin');
    }

    // Vérifie si l'utilisateur peut supprimer une cuve
    public function delete(User $user, Cuve $cuve)
    {
        return $user->hasRole('cuviste') || $user->hasRole('admin');
    }

    // Vérifie si l'utilisateur peut ajouter un moût à une cuve
    public function addMout(User $user, Cuve $cuve)
    {
        return $user->hasRole('cuviste') || $user->hasRole('admin');
    }
}