<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuve extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'volume_max'];

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