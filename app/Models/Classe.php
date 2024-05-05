<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'image_path'
    ];

    public function classeDetails()
    {
        return $this->hasMany(ClasseDetail::class);
    }

    public function getInfoClasseAttribute()
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'image_path' => $this->image_path,
            'classe_details' => $this->classeDetails->map->getInfoClasseDetailAttribute()
        ];
    }
}
