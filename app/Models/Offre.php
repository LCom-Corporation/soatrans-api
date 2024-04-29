<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offre extends Model
{
    use HasFactory; 

    protected $guarded = [];

    public function trajet() 
    {
        return   $this->belongsTo(Trajet::class, 'trajet_id');
    }

    public function vehicule() 
    {
        return   $this->belongsTo(Vehicule::class, 'vehicule_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function users()
    {
        return $this->hasMany(User::class, 'user_id');
    }
}
 