<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ville extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function trajets()
    {
        return $this->hasMany(Trajet::class);
    }
}
