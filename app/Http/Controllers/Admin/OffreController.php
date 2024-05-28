<?php

namespace App\Http\Controllers\Admin;

use App\Models\Offre;
use App\Models\Ville;
use App\Models\Classe;
use App\Models\Trajet;
use App\Models\Vehicule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class OffreController extends Controller
{
    public function index()
    {
        $offres = Offre::with('trajet', 'vehicule')->get();
        $data = [];
        foreach($offres as $offre) {
            $data[$offre->reference] = [
                'reference' => $offre->reference,
                'trajet' => $offre->trajet->villeDepart->nom . ' -> ' . $offre->trajet->villeArrivee->nom,
                'date_depart' => $offre->date_depart,
                'heure_depart' => $offre->heure_depart,
                'date_arrivee' => $offre->date_arrivee,
                'heure_arrivee' => $offre->heure_arrivee,
                'place_disponible' => $offre->place_disponible,
                'vehicules' => isset($data[$offre->reference]['vehicules']) ?$data[$offre->reference]['vehicules']  : [],
            ];
            $data[$offre->reference]['vehicules'][] = $offre->vehicule;
        }
        return response()->json(array_values($data));
    }

    public function create()
    {
        $villes = Ville::all();
        $classes = Classe::all();
        $vehicules = Vehicule::all();

        return response()->json([
            'villes' => $villes,
            'classes' => $classes,
            'vehicules' => $vehicules,
        ]);
    }

    public function store(Request $request)
    {
        $vs = Validator::make($request->all(), [
            'vehicule_ids' => 'required|array',
            'classe_id' => 'required',
            'ville_depart_id' => 'required',
            'ville_arrivee_id' => 'required',
            'date_depart' => 'required',
            'heure_depart' => 'required',
        ]);

        if ($vs->fails()) {
            return response()->json($vs->errors());
        }

        $trajet = Trajet::where('ville_depart_id', $request->ville_depart_id)
            ->where('ville_arrivee_id', $request->ville_arrivee_id)
            ->where('classe_id', $request->classe_id)
            ->first();

        if(is_null($trajet)) {
           return response()->json(['message' => 'Trajet not found'], 404);
        }
        $vehiculesIds = $request->vehicule_ids;
        
        foreach ($vehiculesIds as $vehiculeId) {
            $vehicule = Vehicule::find($vehiculeId);
            $offre = Offre::create([
                'trajet_id' => $trajet->id,
                'vehicule_id' => $vehiculeId,
                'date_depart' => $request->date_depart,
                'heure_depart' => $request->heure_depart,
                'date_arrivee' => $request->date_arrivee,
                'heure_arrivee' => $request->heure_arrivee,
                'place_disponible' => $vehicule->nbr_place,
                'reference' => "REF-" . time(),
            ]);
        }
        return response()->json($offre);
    }
}
