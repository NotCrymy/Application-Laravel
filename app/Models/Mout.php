<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mout extends Model
{
    use HasFactory;

    protected $fillable = ['volume', 'type', 'origine', 'cuve_id', 'proprietaire_id'];

    public function cuve()
    {
        return $this->belongsTo(Cuve::class);
    }

    public function proprietaire()
    {
        return $this->belongsTo(Proprietaire::class);
    }

    public function edit(Cuve $cuve)
    {
        $proprietaires = \App\Models\Proprietaire::all();
        return view('mouts.edit', compact('cuve', 'proprietaires'));
    }
}