<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Cuve;

class CuvePolicy
{
    public function view(User $user, Cuve $cuve)
    {
        return $user->hasRole('manager') || $user->hasRole('cuviste') || $user->hasRole('admin') ;
    }

    public function update(User $user, Cuve $cuve)
    {
        return $user->hasRole('cuviste') || $user->hasRole('admin') ;
    }

    public function delete(User $user, Cuve $cuve)
    {
        return $user->hasRole('cuviste') || $user->hasRole('admin');
    }

    public function addMout(User $user, Cuve $cuve)
    {
        return $user->hasRole('cuviste') || $user->hasRole('admin');
    }
}