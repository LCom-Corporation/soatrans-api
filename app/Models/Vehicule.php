<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicule extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function offres() 
    {
        return $this->hasMany(Offre::class)->orderBy('date_depart', 'asc');
    }
}
 