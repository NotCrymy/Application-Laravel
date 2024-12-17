<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    // Gère les dates pour les soft deletes
    protected $dates = ['deleted_at'];

    // Champs modifiables
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    // Champs cachés lors de la sérialisation
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Attributs qui doivent être castés
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime', // Convertit en objet DateTime
            'password' => 'hashed', // Hashage sécurisé du mot de passe
        ];
    }

    // Relation : Un utilisateur peut avoir plusieurs logs
    public function logs()
    {
        return $this->hasMany(Log::class);
    }
}