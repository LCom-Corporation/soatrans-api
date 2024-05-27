<?php

namespace App\Http\Controllers;

use App\Events\SetPlaceEvent;
use App\Models\PlaceWebsocket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlaceController extends Controller
{
    public function setPlace(Request $request)
    {
        $vs = Validator::make($request->all(), [
            'place' => 'required',
            'offre_id' => 'required',
        ]);

      
            PlaceWebsocket::create([
                'num_place' => $request->place,
                'offre_id' => $request->offre_id,
            ]);
        

        //prendre tous les places de l'offre qui etait creer en moin de 5 minutes
        $places = PlaceWebsocket::where('offre_id', $request->offre_id)
            ->where('created_at', '>=', now()->subMinutes(5))
            ->get();
        
            SetPlaceEvent::dispatch($request->offre_id, $places);
    }

    public function unSetPlace(Request $request)
    {
        $vs = Validator::make($request->all(), [
            'place' => 'required',
            'offre_id' => 'required',
        ]);

        PlaceWebsocket::where('num_place', $request->place)
            ->where('offre_id', $request->offre_id)
            ->delete();

        //prendre tous les places de l'offre qui etait creer en moin de 5 minutes
        $places = PlaceWebsocket::where('offre_id', $request->offre_id)
            ->where('created_at', '>=', now()->subMinutes(5))
            ->get();
        
            SetPlaceEvent::dispatch($request->offre_id, $places);

        }
}
