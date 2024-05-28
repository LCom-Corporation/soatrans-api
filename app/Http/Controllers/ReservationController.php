<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Offre;
use App\Models\Trajet;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Events\SetPlaceEvent;
use App\Models\FideliteTaken;
use App\Models\PlaceWebsocket;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    /**
     * Liste reservation admin.
     */
    public function index()
    {
        $reservations = Reservation::with('offre')->orderBy('id', 'desc')->get();
        return response()->json($reservations);
    }

    public function create(Request $request)
    {
        $vs = Validator::make($request->all(), [
            "ville_depart_id" => "required",
            "ville_arrive_id" => 'required',
            "date_depart" => 'required',
            "classe_id" => 'required',
        ]);

        if($vs->fails()) return response()->json($vs->errors(), 422);

        $offres = Offre::join('trajets', 'offres.trajet_id', '=', 'trajets.id')
            ->join("vehicules", "offres.vehicule_id", "=", "vehicules.id")
            ->where(function ($query) use ($request) {
                $query->where('trajets.ville_depart_id', $request->ville_depart_id)
                    ->where('trajets.ville_arrivee_id', $request->ville_arrive_id)
                    ->where('trajets.classe_id', $request->classe_id)
                    ->where('offres.date_depart', $request->date_depart);
            })
            ->select('offres.*', 'vehicules.*')
            ->get();

        foreach ($offres as $offre) {
            $places = PlaceWebsocket::where('offre_id', $offre->id)
            ->where('created_at', '>=', now()->subMinutes(5))
            ->get();

           try {
            SetPlaceEvent::dispatch($offre, $places);
           } catch (\Throwable $th) {
               return response()->json($th->getMessage(), 500);
           }
        }
            
        return $offres;
    }

    /**
     * Store a newly created resource in storage.mba atao json stringify ilay num_place azafady
     */
    public function store(Request $request)
    {
        $vs = Validator::make($request->all(), [
            'nbr_place' => 'required',
            "num_place" => 'required|string',
            'offre_id' => 'required',
            'user_id' =>  'required',
        ]);

        if($vs->fails()) return response()->json($vs->errors(), 422);

        $string_place = implode(', ', json_decode($request->num_place));
        // return response()->json(['string' => $string_place], 200);
        $reservation = Reservation::create([
            'nbr_place' => $request->nbr_place,
            'num_place' => $request->num_place,
            'reference' => 'RES-' . time(), // 'REF-1623678976'
            'date_reservation' => Carbon::now()->format('Y-m-d'),
            'heure_reservation' => Carbon::now()->format('H:i:s'),
            "status" => "En attente de payement",
            'offre_id' => $request->offre_id,
            'user_id' => $request->user_id,
        ]);
        $offre = Offre::where("id", $request->offre_id)->first();
        $new_place_take = $offre->place_take ?  $offre->place_take.', '. $string_place : $offre->place_take ;
        $offre->update([
            'place_take' => $new_place_take,
            'place_disponible' => $offre->place_disponible - (int)$request->nbr_place,
        ]);
        DB::table("offre_user")->insert([
            "offre_id" => $offre->id,
            "user_id" => $request->user_id
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
     * Liste de reservation actuellement d'une personne authentifier 
     */
    public function list (Request $request)
    {
        $reservations = Reservation::with('offre')->where("user_id", $request->user->id)
            ->where("date_reservation", ">=", Carbon::now()->format('Y-m-d'))
            ->get();
        return response()->json($reservations);
    }

    /**
     * Liste de reservation historique d'une personne authentifier 
     */
    public function listHistorique (Request $request)
    {
        $reservations = Reservation::with('offre')->where("user_id", $request->user->id)
            ->where("date_reservation", "<", Carbon::now()->format('Y-m-d'))
            ->get();
        return response()->json($reservations);
    }

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
                    'class_id' => $trip['class_id'],
                    "name" => $trip['name'],
                    'ids' => [$trip['depart_id'],
                    $trip['arrivee_id']]                 
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
                'class_id' => $trajet->classe->id,
                'class' => $trajet->classe->nom,
                'price' => $trajet->tarif,
                'origin' => $trajet->villeDepart->nom,
                'destination' => $trajet->villeArrivee->nom,
                "name" => $trajet->villeDepart->nom . " < > " . $trajet->villeArrivee->nom,
                'depart_id' => $trajet->villeDepart->id,
                'arrivee_id' => $trajet->villeArrivee->id,
            ];
        });

        // Regrouper les trajets par classe et prix
        $groupedTrips = $this->groupTripsByClassAndPrice($trajets->toArray());

        return response()->json($groupedTrips);
    }

    public function trajetFidelite(Request $request)
    {
        $trajets = $this->getListWithoutDoublon();
        $data = [];
        
        foreach ($trajets->original as $trajet) {

            $reservationsCount = Reservation::with('offre')
                ->join('offres', 'reservations.offre_id', '=', 'offres.id')
                ->join('trajets', 'offres.trajet_id', '=', 'trajets.id')
                ->where(function($query) use ($trajet) {
                    $query
                          ->where("trajets.classe_id", $trajet["class_id"])
                          ->whereIn('trajets.ville_depart_id', $trajet["ids"])
                          ->whereIn('trajets.ville_arrivee_id', $trajet["ids"]);
                })
                ->where('reservations.user_id', $request->user->id)
                ->count();

            $fideliteTaken = FideliteTaken::where('classe_id', $trajet["class_id"])->where('ids', json_encode($trajet["ids"]))->where('user_id', $request->user->id)->first();
            $fidTaken = 0;
            if($fideliteTaken) {
                $fidTaken = $fideliteTaken->points;
            }
            unset($trajet['ids']);
            $data[] = [
                'trajet' => $trajet,
                'trajet_effectue' => $reservationsCount,
                'fidelite' => floor($reservationsCount / 20) - $fidTaken
            ];
        }
        
    
        return response()->json($data, 200);


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
