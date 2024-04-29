<?php

namespace App\Http\Controllers;

use App\Models\Vehicule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehiculeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehicules = Vehicule::all();
        return response()->json($vehicules);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $vs = Validator::make($request->all(), [
            'immatriculation' => 'required|string',
            'nbr_place' => 'required|integer',
        ]);

        if ($vs->fails()) {
            return response()->json($vs->errors(), 400);
        }

        $vehicule = Vehicule::create([
            'immatriculation' => $request->immatriculation,
            'nbr_place' => $request->nbr_place,
            'marque' => $request->marque,
        ]);

        return response()->json($vehicule, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehicule $vehicule)
    {
        return response()->json($vehicule);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicule $vehicule)
    {
        $vs = Validator::make($request->all(), [
            'immatriculation' => 'required|string',
            'nbr_place' => 'required|integer',
        ]);

        if ($vs->fails()) {
            return response()->json($vs->errors(), 400);
        }

        $vehicule->update([
            'immatriculation' => $request->immatriculation,
            'nbr_place' => $request->nbr_place,
            'marque' => $request->marque ? $request->marque : $vehicule->marque,
        ]);

        return response()->json($vehicule);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicule $vehicule)
    {
        $vehicule->delete();
        return response()->json(null, 204);
    }
}
