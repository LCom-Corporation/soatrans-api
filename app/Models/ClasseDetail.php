<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClasseDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'classe_id'
    ];

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function getInfoClasseDetailAttribute()
    {
        return  $this->description;
    }
}
