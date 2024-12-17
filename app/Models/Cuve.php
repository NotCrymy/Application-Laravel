<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cuve extends Model
{
    use HasFactory, SoftDeletes;

    // Champs modifiables
    protected $fillable = ['nom', 'volume_max'];

    // Gère la date des soft deletes
    protected $dates = ['deleted_at'];
    
    // Relation : Une cuve contient plusieurs moûts
    public function mouts()
    {
        return $this->hasMany(Mout::class);
    }

    // Calcule le volume total des moûts dans la cuve
    public function volumeTotal()
    {
        return $this->mouts->sum('volume');
    }
}