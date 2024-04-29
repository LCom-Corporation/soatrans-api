<?php

namespace App\Http\Controllers;

use App\Models\Trajet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TrajetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trajets = Trajet::with('villeDepart', 'villeArrivee')->get();

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
            'classe' => 'required|string',
        ]);

        if ($vs->fails()) {
            return response()->json($vs->errors(), 400);
        }

        $trajet = Trajet::create([
            'ville_depart_id' => $request->ville_depart_id,
            'ville_arrivee_id' => $request->ville_arrivee_id,
            'tarif' => $request->tarif,
            'classe' => $request->classe,
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
            'classe' => 'required|string',
        ]);

        if ($vs->fails()) {
            return response()->json($vs->errors(), 400);
        }

        $trajet->update([
            'ville_depart_id' => $request->ville_depart_id,
            'ville_arrivee_id' => $request->ville_arrivee_id,
            'tarif' => $request->tarif,
            'classe' => $request->classe,
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
