<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proprietaire extends Model
{
    use HasFactory;

    // Champs modifiables
    protected $fillable = ['nom', 'prenom', 'numtel', 'email'];

    // Relation : Un propriétaire peut avoir plusieurs moûts
    public function mouts()
    {
        return $this->hasMany(Mout::class);
    }
}