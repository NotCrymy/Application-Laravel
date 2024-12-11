<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proprietaire extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'prenom', 'numtel', 'email'];

    public function mouts()
    {
        return $this->hasMany(Mout::class);
    }
}