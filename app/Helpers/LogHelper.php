<?php

namespace App\Helpers;

use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class LogHelper
{
    public static function logAction($action)
    {
        Log::create([
            'user_id' => Auth::id(), // Utilisateur actuellement connecté
            'action' => $action,    // Description de l'action
        ]);
    }
}
