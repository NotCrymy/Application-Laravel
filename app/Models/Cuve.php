<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cuve extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['nom', 'volume_max'];
    protected $dates = ['deleted_at'];
    
    public function mouts()
    {
        return $this->hasMany(Mout::class);
    }

    // Calculer le volume total des moûts dans la cuve
    public function volumeTotal()
    {
        return $this->mouts->sum('volume');
    }

    // Vérifie si un volume supplémentaire peut être ajouté
    public function peutAccepterVolume($volume)
    {
        return ($this->volumeTotal() + $volume) <= $this->volume_max;
    }
}