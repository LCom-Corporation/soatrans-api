<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function offre()
    {
        return $this->belongsTo(Offre::class, 'offre_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getDataAttribute()
    {
        return [
            'id' => $this->id,
            'reference' => $this->reference,
            'offre' => $this->offre->trajet->villeDepart->nom . ' -> ' . $this->offre->trajet->villeArrivee->nom,
            'date_reservation' => Carbon::parse($this->date_reservation)->format('d/m/Y'),
            'date_depart' => Carbon::parse($this->offre->date_depart)->format('d/m/Y') . ' ' . $this->offre->heure_depart,
            'user' => ($this->user->prenom ?? "") . ' ' .( $this->user->name ?? ""),
            'place' => implode(', ', json_decode($this->num_place, true)),
            "nbr_place" => $this->nbr_place,
            "prix" => $this->prix,
            'tarif' => (int) $this->prix / (int)$this->nbr_place,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
