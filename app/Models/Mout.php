<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mout extends Model
{
    use HasFactory;

    // Champs modifiables
    protected $fillable = ['volume', 'type', 'origine', 'cuve_id', 'proprietaire_id'];

    // Relation : Un moût appartient à une cuve
    public function cuve()
    {
        return $this->belongsTo(Cuve::class);
    }

    // Relation : Un moût appartient à un propriétaire
    public function proprietaire()
    {
        return $this->belongsTo(Proprietaire::class);
    }
}