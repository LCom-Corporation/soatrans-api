<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getReservations(Request $request)
    {
        $reservations = $request->user->reservations;
        return response()->json($reservations);
    }

}
