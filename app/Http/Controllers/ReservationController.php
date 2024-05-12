<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = Reservation::with('offre')->get();
        return response()->json($reservations);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $vs = Validator::make($request->all(), [
            'nbr_place' => 'required',
            "num_place" => 'required',
            'offre_id' => 'required',
            'user_id' =>  'required',
        ]);

        if($vs->fails()) return response()->json($vs->errors(), 422);

        $reservation = Reservation::create([
            'nbr_place' => $request->nbr_place,
            'num_place' => $request->num_place,
            'reference' => 'RES-' . time(), // 'REF-1623678976'
            'date_reservation' => Carbon::now()->format('Y-m-d'),
            'heure_reservation' => Carbon::now()->format('H:i:s'),
            "statut" => "En attente de payement",
            'offre_id' => $request->offre_id,
            'user_id' => $request->user_id,
        ]);

        return response()->json($reservation, 201);

    }

    /** 
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        $reservation->load('offre');
        return response()->json($reservation);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        $vs = Validator::make($request->all(), [
            'nbr_place' => 'required',
            "num_place" => 'required',
            'offre_id' => 'required',
            'user_id' =>  'required',
        ]);

        if($vs->fails()) return response()->json($vs->errors(), 422);

        $reservation->update([
            'nbr_place' => $request->nbr_place,
            'num_place' => $request->num_place,
            'offre_id' => $request->offre_id,
            'user_id' => $request->user_id,
        ]);

        return response()->json($reservation, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return response()->json(null, 204);
    }

    /**
     * Liste de reservation d'une personne authentifier
     */
    public function list (Request $request)
    {
        $reservations = Reservation::with('offre')->where("user_id", $request->user->id)->get();
        return response()->json($reservations);
    }

    public function annulation(Reservation $reservation)
    {
        //voir si le jour de la reservation est inferieur a 24h
        $date_reservation = Carbon::parse($reservation->date_reservation);
        $date_now = Carbon::now();
        $diff = $date_reservation->diffInHours($date_now);

        if($diff < 24) {
            return response()->json([
                'message' => 'Vous ne pouvez plus annuler cette reservation'
            ], 400);
        }
        
        $reservation->update([
            'statut' => 'Annulée'
        ]);

        return response()->json($reservation, 200);
    }
}
