<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mout extends Model
{
    use HasFactory;

    protected $fillable = ['volume', 'type', 'origine', 'cuve_id'];

    public function cuve()
    {
        return $this->belongsTo(Cuve::class);
    }
}