<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    // Champs modifiables
    protected $fillable = ['user_id', 'action'];

    // Relation : Un log appartient à un utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}