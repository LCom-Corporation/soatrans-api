<?php

namespace App\Http\Controllers;

use App\Class\Utils;
use App\Models\Ville;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VilleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Ville::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    { 
        $vs = Validator::make($request->all(), [
            'nom' => 'required|string',
        ]);

        if ($vs->fails()) {
            return response()->json($vs->errors(), 400);
        }

        $image = null;

        if($request->hasFile('image')) {
            $image = Utils::storePhoto($request->file('image'), 'villes');
        }

        $ville = Ville::create([
            'nom' =>$request->nom,
            'code' =>$request->code,
            'image' =>$image,
        ]);

        return response()->json($ville, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ville $ville)
    {
        $ville->load('trajets');
        return response()->json($ville);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ville $ville)
    {
        $vs = Validator::make($request->all(), [
            'nom' => 'required|string',
        ]);

        if ($vs->fails()) {
            return response()->json($vs->errors(), 400);
        }

        $image = $ville->image;
        if($request->hasFile('image')) {
            $image = Utils::storePhoto($request->file('image'), 'villes');
        }

        $ville->update([
            'nom' =>$request->nom,
            'code' =>$request->code,
            'image' =>$image,
        ]);

        return response()->json($ville, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ville $ville)
    {
        $ville->delete();
        return response()->json(null, 204);
    }
}
