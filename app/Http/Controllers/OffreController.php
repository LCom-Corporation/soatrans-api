<?php

namespace App\Http\Controllers;

use App\Models\Offre;
use App\Models\Vehicule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OffreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $offres = Offre::with('trajet', 'vehicule')->get();
        return response()->json($offres);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $vs = Validator::make($request->all(), [
            'trajet_id' => 'required|integer',
            'vehicule_id' => 'required|integer',
            'date_depart' => 'required|date',
            'heure_depart' => 'required|string',
        ]);

        if ($vs->fails()) {
            return response()->json($vs->errors(), 400);
        }

        $vehicule = Vehicule::find($request->vehicule_id);
        $offre = Offre::create([
            'trajet_id' => $request->trajet_id,
            'vehicule_id' => $request->vehicule_id,
            'date_depart' => $request->date_depart,
            'heure_depart' => $request->heure_depart,
            'date_arrivee' => $request->date_arrivee,
            'heure_arrivee' => $request->heure_arrivee,
            'place_disponible' => $vehicule->nbr_place,
            'reference' => "REF-" . time(), 
        ]);

        return response()->json($offre, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Offre $offre)
    {
        $offre->load('trajet', 'vehicule');
        return response()->json($offre);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Offre $offre)
    {
        $vs = Validator::make($request->all(), [
            'trajet_id' => 'required|integer',
            'vehicule_id' => 'required|integer',
            'date_depart' => 'required|date',
            'heure_depart' => 'required|string',
        ]);

        if ($vs->fails()) {
            return response()->json($vs->errors(), 400);
        }

        $vehicule = Vehicule::find($request->vehicule_id);
        $ville_depart = $offre->trajet->villeDepart->code;
        $ville_arrivee = $offre->trajet->villeArrivee->code;
        $offre->update([
            'trajet_id' => $request->trajet_id,
            'vehicule_id' => $request->vehicule_id,
            'date_depart' => $request->date_depart,
            'heure_depart' => $request->heure_depart,
            'date_arrivee' => $request->date_arrivee,
            'heure_arrivee' => $request->heure_arrivee,
            'place_disponible' => $vehicule->nbr_place,
            'reference' => "$ville_depart-$ville_arrivee-" . time(), 
        ]);

        return response()->json($offre);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Offre $offre)
    {
        $offre->delete();
        return response()->json(null, 204);
    }
}
