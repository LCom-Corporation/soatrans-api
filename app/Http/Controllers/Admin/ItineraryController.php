<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ville;
use App\Models\Classe;
use App\Models\Trajet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItineraryController extends Controller
{
    private function groupTripsByClassAndPrice($trips)
    {
        // Initialiser un tableau pour stocker les trajets regroupés
        $groupedTrips = [];

        // Parcourir chaque trajet et les regrouper par classe et le depart et distination ont le meme prix si la depart  devinent la destination et la destination devien depart
        foreach ($trips as $trip) {
            $key = $trip['class'] . $trip['price'] . $trip['origin'] . $trip['destination'];
            $key2 = $trip['class'] . $trip['price'] . $trip['destination'] . $trip['origin'];

            if (!array_key_exists($key, $groupedTrips) && !array_key_exists($key2, $groupedTrips)) {
                $groupedTrips[$key] = [
                    'classe' => $trip['class'],
                    'tarif' => $trip['price'],
                    "name" => $trip['name'], 
                ];
            }
        }

        // Retourner les trajets regroupés
        return array_values($groupedTrips);
    }

    /**
     * Listes des trajets avec prix et classe
     */
    private function getListWithoutDoublon()
    {
        $trajets = Trajet::with('villeDepart', 'villeArrivee', "classe")->get();
        // Créer une collection à partir des trajets
        $trajets = $trajets->map(function ($trajet) {
            return [
                'class' => $trajet->classe->nom,
                'price' => $trajet->tarif,
                'origin' => $trajet->villeDepart->nom,
                'destination' => $trajet->villeArrivee->nom,
                "name" => $trajet->villeDepart->nom . " < > " . $trajet->villeArrivee->nom,
            ];
        });

        // Regrouper les trajets par classe et prix
        $groupedTrips = $this->groupTripsByClassAndPrice($trajets->toArray());

        return response()->json($groupedTrips);
    }

    public function index()  {
        $data = [];
        $trajets = Trajet::with("villeDepart", 'villeArrivee', 'classe')->orderBy('id','DESC')->get();
        foreach ($trajets as $trajet) {
            $data[] = [
                'id' => $trajet->id,
                'ville_depart' => $trajet->villeDepart->nom,
                'ville_arrivee' => $trajet->villeArrivee->nom,
                'tarif' => $trajet->tarif,
                'point_of_recup' => $trajet->point_of_recup,
                'classe' => $trajet->classe->nom
            ];
        }
        return  response()->json(
            ["trajets" => $data]
        );
    }

    public function create() 
    {
        $classe = Classe::all();
        $ville = Ville::all();

        return response()->json([
            'classes' => $classe,
            'villes' => $ville
        ]);
    }

    public function store(Request $request) 
    {
        $request->validate([
            'ville_depart_id' => 'required',
            'ville_arrivee_id' => 'required',
            'tarif' => 'required',
            'classe_id' => 'required'
        ]);

        $trajet = Trajet::create($request->all());

        return response()->json(['message' => 'Trajet créé avec succès',  'trajet' => $trajet]);
    } 
}
