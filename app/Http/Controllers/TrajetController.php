<?php

namespace App\Http\Controllers;

use App\Models\Trajet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TrajetController extends Controller
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
    public function getListWithoutDoublon()
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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trajets = Trajet::with('villeDepart', 'villeArrivee', "classe")->get();

        return response()->json($trajets);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $vs  = Validator::make($request->all(), [
            'ville_depart_id' => 'required|integer',
            'ville_arrivee_id' => 'required|integer',
            'tarif' => 'required|numeric',
            'classe_id' => 'required',
        ]);

        if ($vs->fails()) {
            return response()->json($vs->errors(), 400);
        }

        $trajet = Trajet::create([
            'ville_depart_id' => $request->ville_depart_id,
            'ville_arrivee_id' => $request->ville_arrivee_id,
            'tarif' => $request->tarif,
            'classe_id' => $request->classe_id,
        ]);

        return response()->json($trajet, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Trajet $trajet)
    {
        $trajet->load('villeDepart', 'villeArrivee');
        
        return response()->json($trajet);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Trajet $trajet)
    {
        $vs  = Validator::make($request->all(), [
            'ville_depart_id' => 'required|integer',
            'ville_arrivee_id' => 'required|integer',
            'tarif' => 'required|numeric',
            'classe_id' => 'required',
        ]);

        if ($vs->fails()) {
            return response()->json($vs->errors(), 400);
        }

        $trajet->update([
            'ville_depart_id' => $request->ville_depart_id,
            'ville_arrivee_id' => $request->ville_arrivee_id,
            'tarif' => $request->tarif,
            'classe_id' => $request->classe_id,
        ]);

        return response()->json($trajet);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trajet $trajet)
    {
        $trajet->delete();

        return response()->json(null, 204);
    }


}
