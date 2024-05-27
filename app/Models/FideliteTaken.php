<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FideliteTaken extends Model
{
    use HasFactory;

    protected $fillable = ["classe_id", "ids", "points", "user_id"];
}
