<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use Illuminate\Http\Request;

class ClasseController extends Controller
{
    /**
     * Liste de toutes les classe pour l'accueil
     */
    public function index()
    {
        $classes = Classe::with('classeDetails')->get();
        $data = $classes->map->getInfoClasseAttribute();
        return response()->json($data);
    }
}
